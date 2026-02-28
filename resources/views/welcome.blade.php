<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - CV Sultan</title>
    <link rel="stylesheet" href="/css/welcome.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="profile">
                <img src="foto/sultan.jpg" alt="Foto Profil" class="profile-photo">
                <h3>Sultan Maulana</h3>
            </div>
            <nav class="menu">
                <a href="{{ route('cv') }}" class="menu-item">Lihat CV</a>
                <a href="{{ route('project') }}" class="menu-item">Project</a>
                <a href="{{ route('contact') }}" class="menu-item">Contact</a>
            </nav>
            <button class="btn">Download CV</button>
        </aside>
        <main class="main-content">
            <section class="section">
                <h1>Selamat Datang di CV Saya</h1>
                <p>Klik menu di sebelah kiri untuk melihat informasi lebih lanjut.</p>
            </section>
        </main>
    </div>
</body>
</html>