<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
</head>
<body class="bg-gray-100 flex">

    {{-- Sidebar --}}
    <aside class="bg-gray-800 text-white w-64 min-h-screen p-5">
        <h2 class="text-2xl font-bold mb-5">Admin Panel</h2>
        <nav>
            <ul>
                <li class="mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="block p-3 bg-gray-700 rounded hover:bg-gray-600">
                        📊 Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#" class="block p-3 bg-gray-700 rounded hover:bg-gray-600">
                        📂 Kelola Transaksi
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#" class="block p-3 bg-gray-700 rounded hover:bg-gray-600">
                        ⚙️ Pengaturan
                    </a>
                </li>
                <li class="mt-10">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full p-3 bg-red-600 rounded hover:bg-red-500">🚪 Logout</button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>

    {{-- Konten Utama --}}
    <main class="flex-1 p-6">
        <div class="bg-white p-4 rounded-lg shadow-lg">
            @yield('content')
        </div>
    </main>

    @yield('scripts')

    <script>
        ScrollReveal().reveal('.reveal', { delay: 200, distance: '50px', origin: 'bottom', easing: 'ease-in-out' });
    </script>

</body>
</html>
