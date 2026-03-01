<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CV Website')</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="profile">
                <img src="{{ asset('foto/sultan.jpg') }}" alt="Foto Profil" class="profile-photo">
                <h3>Sultan Maulana</h3>
            </div>

            <nav class="menu">
                <a href="{{ route('cv') }}" class="menu-item {{ request()->routeIs('cv') ? 'active' : '' }}">Lihat CV</a>
                <a href="{{ route('project') }}" class="menu-item {{ request()->routeIs('project') ? 'active' : '' }}">Project</a>
                <a href="{{ route('contact') }}" class="menu-item {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
                <a href="{{ route('admin.projects') }}" class="menu-item {{ request()->routeIs('admin.*') ? 'active' : '' }}">Admin</a>
            </nav>

            @if(session('is_admin'))
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="btn btn-danger" type="submit">Logout Admin</button>
                </form>
            @else
                <a href="{{ route('admin.login') }}" class="btn" style="display:inline-block;box-sizing:border-box;text-align:center;text-decoration:none;">Login Admin</a>
            @endif
        </aside>

        <main class="main-content">
            <section class="section">
                @yield('content')
            </section>
        </main>
    </div>
</body>
</html>
