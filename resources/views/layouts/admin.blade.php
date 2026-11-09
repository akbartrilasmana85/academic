<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('judul', 'Admin') - Master Data Akademik</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 0; background: #f4f6f8; color: #222; }
        nav { background: #1e3a5f; padding: 12px 24px; }
        nav a { color: #fff; text-decoration: none; margin-right: 18px; }
        nav a.aktif { text-decoration: underline; font-weight: bold; }
        main { max-width: 960px; margin: 24px auto; padding: 0 16px; }
        .header-halaman { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { border: 1px solid #ccd; padding: 8px; text-align: left; vertical-align: middle; }
        th { background: #1e3a5f; color: #fff; }
        .kartu { background: #fff; padding: 16px; border-radius: 6px; margin-bottom: 16px; }
        .btn { display: inline-block; padding: 6px 12px; border-radius: 4px; border: none; cursor: pointer; text-decoration: none; font-size: 14px; }
        .btn-primary { background: #1e3a5f; color: #fff; }
        .btn-secondary { background: #6b7280; color: #fff; }
        .btn-danger { background: #b91c1c; color: #fff; }
        .aksi form { display: inline; }
        .aksi a, .aksi button { margin-right: 6px; }
        .alert { padding: 10px 14px; border-radius: 4px; margin-bottom: 16px; }
        .alert-success { background: #dcfce7; color: #166534; }
        .field { margin-bottom: 12px; }
        .field label { display: block; font-weight: bold; margin-bottom: 4px; }
        .field input[type="text"], .field input[type="email"], .field input[type="number"] { width: 100%; max-width: 420px; padding: 6px; box-sizing: border-box; }
        .error { color: #b91c1c; font-size: 13px; }
        .tombol { display: flex; gap: 8px; margin-top: 16px; }
        .paginasi { margin-top: 12px; }
    </style>
</head>
<body>
<nav>
    <a href="{{ route('admin.mahasiswa.index') }}" class="{{ request()->routeIs('admin.mahasiswa.*') ? 'aktif' : '' }}">Mahasiswa</a>
    <a href="{{ route('admin.matakuliah.index') }}" class="{{ request()->routeIs('admin.matakuliah.*') ? 'aktif' : '' }}">Mata Kuliah</a>
</nav>
<main>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('konten')
</main>
</body>
</html>
