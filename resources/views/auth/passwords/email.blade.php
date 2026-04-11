<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi — Perpustakaan.digital</title>
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

        .btn-reset {
            background: #4f46e5;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-reset:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
            filter: brightness(1.1);
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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
                       <i class="fas fa-key text-[#0096ff] text-3xl mb-1"></i>
                       <div class="w-8 h-1 bg-[#0096ff] rounded-full"></div>
                   </div>
                </div>
            </div>

            <!-- Title & Branding -->
            <div class="mb-10">
                <h1 class="text-2xl font-bold tracking-wider">LUPA SANDI</h1>
                <p class="text-white font-medium text-sm">Perpustakaan.digital</p>
            </div>

            @if (session('status'))
            <div class="bg-emerald-500/20 border border-emerald-500/50 text-emerald-100 text-[10px] px-4 py-2 rounded-full mb-6 font-bold">
                {{ session('status') }}
            </div>
            @endif

            <!-- Forgot Password Form -->
            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Email/Gmail -->
                <div>
                    <input type="email" name="email" value="{{ old('email') }}" 
                           placeholder="Masukkan Email Anda" required
                           class="input-glass w-full py-3.5 px-6 rounded-full text-slate-800 text-sm font-medium placeholder-slate-400 focus:outline-none">
                    @error('email')<p class="text-[10px] text-red-200 mt-2 font-bold">{{ $message }}</p>@enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" 
                            class="btn-reset w-full py-3.5 px-6 rounded-full font-bold text-sm tracking-widest uppercase">
                            KIRIM TAUTAN
                    </button>
                </div>
            </form>

            <!-- Back to Login Link -->
            <div class="mt-10">
                <a href="{{ route('login') }}" class="text-[#00c6ff] font-medium text-sm hover:underline italic">
                    Back to Login...
                </a>
            </div>
            
            <!-- Footer Copyright -->
            <div class="mt-8 opacity-40 text-[9px] uppercase tracking-[0.2em] font-semibold">
                &copy; 2026 DigiLib Digital Library
            </div>
        </div>
    </div>

</body>
</html>
