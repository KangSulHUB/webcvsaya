@extends('layouts.app')

@section('title', 'Project')

@section('content')
<h2>Portfolio Project</h2>
<p class="project-public-note">
    Ini adalah halaman publik yang bisa diakses HRD.
    Untuk kelola data project, gunakan halaman <a href="{{ route('admin.projects') }}">Admin Project</a>.
</p>

@if(!empty($db_error))
    <div class="alert-error">{{ $db_error }}</div>
@endif

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
            @if($project['created_at'])
                <p class="project-date">{{ $project['created_at'] }}</p>
            @endif

            @if($project['url'])
                <a href="{{ $project['url'] }}" target="_blank" class="btn project-btn">Lihat File</a>
            @endif
        </div>
    @empty
        <p>Belum ada project publik.</p>
    @endforelse
</div>
@endsection
