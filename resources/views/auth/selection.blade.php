<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Autentikasi — Perpustakaan.digital</title>
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
        
        .btn-glass {
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
        }

        .btn-glass:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            background: rgba(255, 255, 255, 1);
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
<body class="font-sans antialiased text-white min-h-screen overflow-hidden flex items-center justify-center relative">
    
    <!-- Background Library with Blur and Dark Overlay -->
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-black/50 z-10"></div>
        <img src="{{ asset('images/library-bg.png') }}" 
             class="w-full h-full object-cover filter blur-[4px] scale-110" 
             alt="Library Background">
    </div>

    <!-- Main Content: Glassmorphism Card -->
    <div class="relative z-20 w-full max-w-[400px] px-6">
        <div class="glass-card rounded-[20px] p-10 text-center fade-in">
            <!-- Round Logo -->
            <div class="flex justify-center mb-8">
                <div class="w-20 h-20 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30 shadow-lg">
                    <i class="fas fa-book-open text-white text-3xl"></i>
                </div>
            </div>

            <!-- Title & Branding -->
            <div class="mb-10">
                <h1 class="text-2xl font-bold tracking-wide">
                    Perpustakaan<span class="font-light">.digital</span>
                </h1>
                <p class="text-white/80 text-sm mt-2 font-medium tracking-wider uppercase">Platform Literasi Modern</p>
            </div>

            <!-- Navigation Buttons -->
            <div class="space-y-4">
                <a href="{{ route('register') }}" 
                   class="btn-glass block w-full py-3.5 px-6 rounded-full text-slate-800 font-extrabold text-sm tracking-widest uppercase">
                   DAFTAR
                </a>
                
                <a href="{{ route('login') }}" 
                   class="btn-glass block w-full py-3.5 px-6 rounded-full text-slate-800 font-extrabold text-sm tracking-widest uppercase">
                   LOGIN
                </a>
            </div>

            <!-- Footer Small Text -->
            <div class="mt-12 opacity-60 text-[10px] uppercase tracking-[0.2em] font-semibold">
                &copy; 2026 DigiLib Digital Library
            </div>
        </div>
    </div>

</body>
</html>
