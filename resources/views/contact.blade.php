{{-- resources/views/contact.blade.php --}}
@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<div class="contact-page">
    <div class="contact-header">
        <h2>Contact</h2>
        <p>Silakan pilih platform yang ingin kamu kunjungi.</p>
    </div>

    <div class="contact-grid">
        <a href="https://github.com/KangSulHUB" class="social-card" target="_blank" rel="noopener noreferrer">
            <img src="{{ asset('foto/git.webp') }}" alt="Github" class="social-icon">
            <span>GitHub</span>
        </a>
        <a href="https://www.facebook.com/profile.php?id=100075752011620" class="social-card" target="_blank" rel="noopener noreferrer">
            <img src="{{ asset('foto/FB.jpg') }}" alt="Facebook" class="social-icon">
            <span>Facebook</span>
        </a>
        <a href="https://www.tiktok.com/@smptv77?_r=1&_t=ZS-94HyMQcEprl" class="social-card" target="_blank" rel="noopener noreferrer">
            <img src="{{ asset('foto/tiktok.png') }}" alt="TikTok" class="social-icon">
            <span>TikTok</span>
        </a>
        <a href="https://www.instagram.com/5mp_tv?igsh=ZXg4dDBhNWkxdTU1" class="social-card" target="_blank" rel="noopener noreferrer">
            <img src="{{ asset('foto/IG.jpg') }}" alt="Instagram" class="social-icon">
            <span>Instagram</span>
        </a>
        <a href="https://youtube.com/@smptv77?si=PH1WQtWo-VXZOJwi" class="social-card" target="_blank" rel="noopener noreferrer">
            <img src="{{ asset('foto/YT.jpg') }}" alt="YouTube" class="social-icon">
            <span>YouTube</span>
        </a>
        <a href="https://www.linkedin.com/in/sultan-prayoga-aa7a89291" class="social-card" target="_blank" rel="noopener noreferrer">
            <img src="{{ asset('foto/Linkdin.jpg') }}" alt="LinkedIn" class="social-icon">
            <span>LinkedIn</span>
        </a>
    </div>
</div>
@endsection

