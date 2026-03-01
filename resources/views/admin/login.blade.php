@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<div class="admin-login-card">
    <h2>Admin Login</h2>
    <p>Login untuk mengelola CRUD project portfolio.</p>

    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    @if($errors->has('login'))
        <div class="alert-error">{{ $errors->first('login') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}" class="project-form">
        @csrf
        <input type="text" name="username" placeholder="Username admin" value="{{ old('username') }}" required>
        <input type="password" name="password" placeholder="Password admin" required>
        <button type="submit" class="btn">Login</button>
    </form>
</div>
@endsection
