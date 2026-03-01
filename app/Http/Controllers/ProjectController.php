<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        try {
            $projects = Project::query()
                ->where('is_published', true)
                ->latest()
                ->get()
                ->map(fn (Project $project) => $this->toProjectCard($project));

            return view('project', compact('projects'));
        } catch (QueryException $e) {
            return view('project', [
                'projects' => collect(),
                'db_error' => 'Database belum terhubung. Aktifkan MySQL lalu jalankan migrate.',
            ]);
        }
    }

    public function adminIndex()
    {
        try {
            $projects = Project::query()
                ->latest()
                ->get()
                ->map(fn (Project $project) => $this->toProjectCard($project));

            return view('admin.projects', compact('projects'));
        } catch (QueryException $e) {
            return view('admin.projects', [
                'projects' => collect(),
                'db_error' => 'Database belum terhubung. Aktifkan MySQL lalu jalankan migrate.',
            ]);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'project_file' => ['nullable', 'file', 'max:20480'],
            'external_url' => ['nullable', 'url', 'max:2048'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $filePath = null;
        $mimeType = null;

        if ($request->hasFile('project_file')) {
            $uploaded = $request->file('project_file');
            $filePath = $this->storeFile($uploaded);
            $mimeType = $uploaded->getMimeType();
        }

        try {
            Project::create([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'file_path' => $filePath,
                'mime_type' => $mimeType,
                'external_url' => $validated['external_url'] ?? null,
                'is_published' => $request->boolean('is_published'),
            ]);
        } catch (QueryException $e) {
            return redirect()
                ->route('admin.projects')
                ->with('error', 'Gagal menyimpan project. Pastikan MySQL aktif dan tabel projects sudah dibuat.');
        }

        return redirect()
            ->route('admin.projects')
            ->with('success', 'Project berhasil ditambahkan.');
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'project_file' => ['nullable', 'file', 'max:20480'],
            'external_url' => ['nullable', 'url', 'max:2048'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        try {
            $project->title = $validated['title'];
            $project->description = $validated['description'] ?? null;
            $project->external_url = $validated['external_url'] ?? null;
            $project->is_published = $request->boolean('is_published');

            if ($request->hasFile('project_file')) {
                if ($project->file_path && Storage::disk('public')->exists($project->file_path)) {
                    Storage::disk('public')->delete($project->file_path);
                }

                $uploaded = $request->file('project_file');
                $project->file_path = $this->storeFile($uploaded);
                $project->mime_type = $uploaded->getMimeType();
            }

            $project->save();
        } catch (QueryException $e) {
            return redirect()
                ->route('admin.projects')
                ->with('error', 'Gagal memperbarui project. Periksa koneksi database Anda.');
        }

        return redirect()
            ->route('admin.projects')
            ->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        try {
            if ($project->file_path && Storage::disk('public')->exists($project->file_path)) {
                Storage::disk('public')->delete($project->file_path);
            }

            $project->delete();
        } catch (QueryException $e) {
            return redirect()
                ->route('admin.projects')
                ->with('error', 'Gagal menghapus project. Periksa koneksi database Anda.');
        }

        return redirect()
            ->route('admin.projects')
            ->with('success', 'Project berhasil dihapus.');
    }

    private function storeFile($file): string
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $safeBaseName = Str::slug($originalName);

        if ($safeBaseName === '') {
            $safeBaseName = 'file';
        }

        $fileName = $safeBaseName.'-'.Str::random(8).($extension ? '.'.$extension : '');

        return $file->storeAs('projects', $fileName, 'public');
    }

    private function toProjectCard(Project $project): array
    {
        $mimeType = $project->mime_type ?? '';
        $url = $project->external_url ?: ($project->file_path ? Storage::url($project->file_path) : null);
        $urlExtension = $url ? strtolower(pathinfo(parse_url($url, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION)) : null;
        $isImage = str_starts_with($mimeType, 'image/') || in_array($urlExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'], true);
        $isVideo = str_starts_with($mimeType, 'video/') || in_array($urlExtension, ['mp4', 'webm', 'mov', 'm4v'], true);

        return [
            'id' => $project->id,
            'title' => $project->title,
            'description' => $project->description,
            'url' => $url,
            'mime' => $mimeType,
            'external_url' => $project->external_url,
            'is_published' => (bool) $project->is_published,
            'is_image' => $isImage,
            'is_video' => $isVideo,
            'file_ext' => $urlExtension ? strtoupper($urlExtension) : null,
            'created_at' => optional($project->created_at)->format('d M Y'),
        ];
    }
}
