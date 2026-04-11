<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Perpustakaan.digital</title>
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .glass-card {
            background: rgba(0, 150, 255, 0.25);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        }

        .input-glass {
            background: rgba(255, 255, 255, 0.8);
            border: none;
            transition: all 0.3s ease;
        }

        .input-glass:focus {
            background: rgba(255, 255, 255, 1);
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-login {
            background: #ff2d20;
            /* Matching the red "Sign in" button in image */
            color: white;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(255, 45, 32, 0.3);
            filter: brightness(1.1);
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="font-sans antialiased text-white min-h-screen flex items-center justify-center relative py-12 px-6">

    <!-- Background Library with Blur and Dark Overlay -->
    <div class="fixed inset-0 z-0 overflow-hidden">
        <div class="absolute inset-0 bg-black/40 z-10"></div>
        <img src="{{ asset('images/library-bg.png') }}"
            class="w-full h-full object-cover filter blur-[4px] scale-110"
            alt="Library Background">
    </div>

    <!-- Main Content: Glassmorphism Card -->
    <div class="relative z-20 w-full max-w-[420px]">
        <div class="glass-card rounded-[20px] p-10 text-center fade-in">
            <!-- Round Logo -->
            <div class="flex justify-center mb-8">
                <div class="w-24 h-24 rounded-full bg-white flex items-center justify-center border-4 border-white/20 shadow-xl overflow-hidden">
                    <div class="flex flex-col items-center">
                        @if(isset($appSettings['app_logo']) && $appSettings['app_logo'])
                        <img src="{{ asset('storage/logo/pCwchhx4rSPGKHs7DyZjYSCMxjRBpMLn217MhNbY.png') }}"> @else
                        <i class="fas fa-book-open text-[#0096ff] text-3xl mb-1"></i>
                        <div class="w-8 h-1 bg-[#0096ff] rounded-full"></div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Title & Branding -->
            <div class="mb-10">
                <h1 class="text-2xl font-bold tracking-wider">LOGIN</h1>
                <p class="text-white font-medium text-sm">{{ $appSettings['app_name'] ?? 'Perpustakaan.digital' }}</p>
            </div>

            @if(session('success'))
            <div class="bg-emerald-500/20 border border-emerald-500/50 text-emerald-100 text-[10px] px-4 py-2 rounded-full mb-6 font-bold">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="bg-red-500/20 border border-red-500/50 text-red-100 text-[10px] px-4 py-2 rounded-full mb-6 font-bold">
                {{ $errors->first() }}
            </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email/Username -->
                <div>
                    <input type="email" name="email" value="{{ old('email') }}"
                        placeholder="Username" required
                        class="input-glass w-full py-3.5 px-6 rounded-full text-slate-800 text-sm font-medium placeholder-slate-400 focus:outline-none">
                </div>

                <!-- Password -->
                <div class="relative group">
                    <input type="password" id="password" name="password"
                        placeholder="Password" required
                        class="input-glass w-full py-3.5 px-6 pr-12 rounded-full text-slate-800 text-sm font-medium placeholder-slate-400 focus:outline-none transition-all">
                    <button type="button" onclick="togglePassword('password', 'eyeIcon')" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#0096ff] transition-colors focus:outline-none">
                        <i class="fas fa-eye text-[14px]" id="eyeIcon"></i>
                    </button>
                </div>

                <!-- Remember & Forgot Password (Subtle links) -->
                <div class="flex justify-between px-4 text-[10px] font-medium text-white/50">
                    <label class="flex items-center gap-2 cursor-pointer hover:text-white transition-colors">
                        <input type="checkbox" name="remember" class="accent-[#0096ff]"> Ingat saya
                    </label>
                    <a href="{{ route('password.request') }}" class="hover:text-white transition-colors italic">Lupa sandi?</a>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="btn-login w-full py-3.5 px-6 rounded-full font-bold text-sm tracking-widest uppercase">
                        Sign in
                    </button>
                </div>
            </form>

            <!-- Register Link -->
            <div class="mt-8">
                <a href="{{ route('register') }}" class="text-[#00c6ff] font-medium text-sm hover:underline italic">
                    Don't have account? DAFTAR
                </a>
            </div>

            <!-- Demo Helper Buttons (Very Subtle) -->
            <div class="mt-8 flex gap-2 justify-center opacity-30 hover:opacity-100 transition-opacity">
                <button onclick="fill('admin@perpustakaan.id', 'admin123')" class="text-[8px] bg-white/10 px-2 py-1 rounded-full border border-white/10">Kepala Demo</button>
                <button onclick="fill('petugas@perpustakaan.id', 'petugas123')" class="text-[8px] bg-white/10 px-2 py-1 rounded-full border border-white/10">Petugas Demo</button>
                <button onclick="fill('budi@gmail.com', 'member123')" class="text-[8px] bg-white/10 px-2 py-1 rounded-full border border-white/10">Anggota Demo</button>
            </div>

            <!-- Footer Copyright -->
            <div class="mt-8 opacity-40 text-[9px] uppercase tracking-[0.2em] font-semibold">
                &copy; 2026 PERPUSTAKAAN DIGITAL
            </div>
        </div>
    </div>

    <script>
        function fill(email, password) {
            document.querySelector('input[name="email"]').value = email;
            document.querySelector('input[name="password"]').value = password;
        }

        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

</body>

</html>