<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

<div class="container">
    <aside class="sidebar">
        <h2 class="logo">Task Reminder</h2>
        <ul>
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('manage.index') }}">Manajemen Tugas</a></li>
            <li><a href="/tasks">Pengingat Tugas</a></li>
            <li><a href="/forums">Forum</a></li>
            <li><a href="/notes">Catatan</a></li>

            <!-- MENU PROFILE -->
            <li><a href="{{ route('profile') }}">Profile Pengguna</a></li>
        </ul>
    </aside>

    <main class="content">
        {{-- Notifikasi sukses --}}
        @if (session('success'))
            <div class="alert-success-banner" id="successAlert">
                <span>✅ {{ session('success') }}</span>
                <button onclick="document.getElementById('successAlert').remove()" class="alert-close">&times;</button>
            </div>
        @endif

        @yield('content')
    </main>
</div>
<script>
    // Auto-dismiss notifikasi setelah 4 detik
    const alert = document.getElementById('successAlert');
    if (alert) {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        }, 4000);
    }
</script>

</body>
</html>
