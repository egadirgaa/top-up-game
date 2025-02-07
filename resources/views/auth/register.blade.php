<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-800 flex items-center justify-center min-h-screen relative">
    
    <!-- Background Image -->
    <img src="{{ asset('img/wallpaper1.png') }}" class="fixed top-0 left-0 w-full h-full object-cover">
    
    <div class="absolute inset-0 flex flex-col items-center justify-center px-6">
        <!-- Register Form -->
        <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-lg p-8 shadow-lg w-96" id="register-box">
            <h2 class="text-2xl font-bold text-white mb-4">Daftar</h2>
            <p class="text-white">
                Sudah punya akun? <a href="{{ route('showLogin') }}" class="text-blue-600 hover:underline">Login</a>
            </p>
            
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-white mb-2">Nama Lengkap</label>
                    <input name="name" type="text" id="name" class="w-full px-4 py-2 rounded-lg bg-white bg-opacity-20 text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-white mb-2">Email</label>
                    <input name="email" type="email" id="email" class="w-full px-4 py-2 rounded-lg bg-white bg-opacity-20 text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-white mb-2">Nomor Telepon</label>
                    <input name="phone" type="text" id="phone" class="w-full px-4 py-2 rounded-lg bg-white bg-opacity-20 text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-white mb-2">Password</label>
                    <input name="password" type="password" id="password" class="w-full px-4 py-2 rounded-lg bg-white bg-opacity-20 text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-white mb-2">Konfirmasi Password</label>
                    <input name="password_confirmation" type="password" id="password_confirmation" class="w-full px-4 py-2 rounded-lg bg-white bg-opacity-20 text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <button type="submit" class="w-full py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Register</button>
            </form>
        </div>
    </div>

    <script>
        ScrollReveal().reveal('#register-box', {
            duration: 700,
            origin: 'bottom',
            distance: '50px',
            easing: 'ease-in-out'
        });
    </script>
</body>
</html>