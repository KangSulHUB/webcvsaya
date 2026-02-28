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
                ->latest()
                ->get()
                ->map(function (Project $project) {
                    $mimeType = $project->mime_type ?? '';

                    return [
                        'id' => $project->id,
                        'title' => $project->title,
                        'description' => $project->description,
                        'url' => $project->file_path ? Storage::url($project->file_path) : null,
                        'mime' => $mimeType,
                        'is_image' => str_starts_with($mimeType, 'image/'),
                        'is_video' => str_starts_with($mimeType, 'video/'),
                        'file_ext' => $project->file_path ? strtoupper(pathinfo($project->file_path, PATHINFO_EXTENSION)) : null,
                        'created_at' => optional($project->created_at)->format('d M Y'),
                    ];
                });

            return view('project', compact('projects'));
        } catch (QueryException $e) {
            return view('project', [
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
            ]);
        } catch (QueryException $e) {
            return redirect()
                ->route('project')
                ->with('error', 'Gagal menyimpan project. Pastikan MySQL aktif dan tabel projects sudah dibuat.');
        }

        return redirect()
            ->route('project')
            ->with('success', 'Project berhasil ditambahkan.');
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'project_file' => ['nullable', 'file', 'max:20480'],
        ]);

        try {
            $project->title = $validated['title'];
            $project->description = $validated['description'] ?? null;

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
                ->route('project')
                ->with('error', 'Gagal memperbarui project. Periksa koneksi database Anda.');
        }

        return redirect()
            ->route('project')
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
                ->route('project')
                ->with('error', 'Gagal menghapus project. Periksa koneksi database Anda.');
        }

        return redirect()
            ->route('project')
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
}
