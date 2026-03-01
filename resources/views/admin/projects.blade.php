@extends('layouts.app')

@section('title', 'Admin Project')

@section('content')
<h2>Admin Project</h2>
<p class="project-public-note">
    Semua perubahan di sini langsung tersimpan ke database.
    Project yang dicentang "Tampilkan di publik" akan muncul di halaman portfolio HRD.
</p>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert-error">{{ session('error') }}</div>
@endif

@if(!empty($db_error))
    <div class="alert-error">{{ $db_error }}</div>
@endif

@if($errors->any())
    <div class="alert-error">
        <p>Proses gagal:</p>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="project-form-card">
    <h3>Tambah Project</h3>
    <form class="project-form" method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="text" name="title" placeholder="Judul project" value="{{ old('title') }}" required>
        <textarea name="description" placeholder="Deskripsi singkat project">{{ old('description') }}</textarea>
        <input type="url" name="external_url" placeholder="https://... (opsional, link cloud/file publik)" value="{{ old('external_url') }}">
        <input type="file" id="project-upload" name="project_file">
        <label class="checkbox-inline">
            <input type="checkbox" name="is_published" value="1" {{ old('is_published', '1') ? 'checked' : '' }}>
            Tampilkan di publik
        </label>
        <button type="submit" class="btn">Simpan Project</button>
    </form>
</div>

<div class="projects">
    @forelse($projects as $project)
        <div class="project-item">
            @if($project['url'] && $project['is_image'])
                <img src="{{ $project['url'] }}" alt="{{ $project['title'] }}" class="project-img">
            @elseif($project['url'] && $project['is_video'])
                <video class="project-img" controls>
                    <source src="{{ $project['url'] }}" type="{{ $project['mime'] }}">
                    Browser Anda tidak mendukung video.
                </video>
            @elseif($project['url'])
                <div class="project-file">{{ $project['file_ext'] ?: 'FILE' }}</div>
            @else
                <div class="project-file">NO FILE</div>
            @endif

            <p class="project-name"><strong>{{ $project['title'] }}</strong></p>
            @if($project['description'])
                <p class="project-desc">{{ $project['description'] }}</p>
            @endif
            <p class="project-status {{ $project['is_published'] ? 'is-published' : 'is-private' }}">
                {{ $project['is_published'] ? 'Publik' : 'Private' }}
            </p>

            @if($project['url'])
                <a href="{{ $project['url'] }}" target="_blank" class="btn project-btn">Lihat File</a>
            @endif

            <form class="project-form edit-form" method="POST" action="{{ route('admin.projects.update', $project['id']) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="text" name="title" value="{{ $project['title'] }}" required>
                <textarea name="description" placeholder="Deskripsi singkat project">{{ $project['description'] }}</textarea>
                <input type="url" name="external_url" placeholder="https://... (opsional, link cloud/file publik)" value="{{ $project['external_url'] }}">
                <input type="file" name="project_file">
                <label class="checkbox-inline">
                    <input type="checkbox" name="is_published" value="1" {{ $project['is_published'] ? 'checked' : '' }}>
                    Tampilkan di publik
                </label>
                <button type="submit" class="btn project-btn">Update</button>
            </form>

            <form method="POST" action="{{ route('admin.projects.destroy', $project['id']) }}" onsubmit="return confirm('Hapus project ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger project-btn">Hapus</button>
            </form>
        </div>
    @empty
        <p>Belum ada project.</p>
    @endforelse
</div>
@endsection
