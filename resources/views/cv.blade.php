{{-- resources/views/cv.blade.php --}}
@extends('layouts.app')

@section('title', 'CV')

@section('content')
<div class="cv-page">
    <div class="cv-header">
        <h1>CV Sultan Maulana</h1>
        <p>Mahasiswa Sistem Informasi yang fokus pada pengembangan web, analisis data, dan AI automation.</p>
    </div>

    <section class="cv-card">
        <h2>About</h2>
        <p>Saya adalah mahasiswa Sistem Informasi yang memiliki minat kuat di bidang teknologi informasi, khususnya pengembangan perangkat lunak dan pengelolaan data. Saat ini saya belum memiliki pengalaman kerja formal, namun saya aktif belajar melalui tugas perkuliahan, latihan mandiri, dan pembuatan project untuk meningkatkan kemampuan teknis. Saya berkomitmen untuk terus berkembang dan siap berkontribusi sebagai profesional IT yang disiplin, adaptif, dan bertanggung jawab.</p>
    </section>

    <section class="cv-card">
        <h2>Study</h2>
        <ul class="cv-list">
            <li><strong>STIMIK IKMI CIREBON</strong> - Sistem Informasi - 2024 - Sekarang (Mahasiswa)</li>
            <li><strong>SMA Negeri 8 Kuningan</strong> - Teknik Otomotif - 2020 - 2022</li>
        </ul>
    </section>

    <section class="cv-card">
        <h2>Project & Pengalaman Relevan</h2>
        <ul class="cv-list">
            <li>Mengerjakan berbagai project kuliah dari semester 1 sampai semester 4 sebagai latihan membangun solusi digital secara bertahap.</li>
            <li>Melakukan analisis data untuk kebutuhan tugas perkuliahan, mulai dari pengolahan data hingga penyajian hasil analisis.</li>
            <li>Membangun aplikasi web menggunakan Laravel untuk memahami alur pengembangan backend, database, dan fitur aplikasi.</li>
            <li>Membuat program AI Automation menggunakan n8n untuk mengotomatisasi alur kerja dan integrasi antar layanan.</li>
        </ul>
    </section>

    <section class="cv-card">
        <h2>Skills</h2>
        <ul class="cv-list">
            <li>Programming Languages: PHP, Pemrograman SQL,Python</li>
            <li>Frameworks: Laravel, Oracle, Jupyter Notebook, RStudio</li>
            <li>Tools: Github, SQL, Docker, Xampp, VS Code</li>
            <li>Soft Skills: Problem Solving, Teamwork, Communication</li>
        </ul>
    </section>

    <section class="cv-card">
        <h2>Contact</h2>
        <ul class="cv-list cv-contact-list">
            <li>Email: sultanprayoga2023@gmail.com</li>
            <li>Telepon: +62 812 2439 3950</li>
        </ul>
    </section>
</div>
@endsection
