<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Perpustakaan Digital</title>
    <!-- Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        .bg-library {
            background-image: url('{{ asset('images/library-bg.png') }}');
            background-size: cover;
            background-position: center;
            filter: blur(8px);
            -webkit-filter: blur(8px);
            height: 100%;
            width: 100%;
            position: absolute;
            z-index: -1;
            transform: scale(1.1); /* Prevent white edges from blur */
        }
        
        .overlay {
            background-color: rgba(0, 0, 0, 0.6);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .fade-in {
            animation: fadeIn 1.5s ease-out forwards;
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

        .btn-modern {
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.6);
            background-color: #2563eb; /* blue-600 */
        }
    </style>
</head>
<body class="font-poppins h-screen w-screen overflow-hidden flex items-center justify-center text-white relative">
    
    <!-- Background and Overlay -->
    <div class="bg-library"></div>
    <div class="overlay"></div>

    <!-- Main Content -->
    <div class="relative z-10 text-center px-4 fade-in">
        <h1 class="text-4xl md:text-6xl font-bold tracking-wider mb-4 uppercase">
            Selamat Datang di <br class="md:hidden"> Perpustakaan
        </h1>
        <p class="text-xl md:text-2xl font-light tracking-widest mb-12 uppercase opacity-90">
            Silahkan Masuk
        </p>
        
        <a href="{{ route('auth.selection') }}" class="btn-modern inline-block bg-blue-500 text-white font-semibold py-4 px-12 rounded-full text-lg tracking-widest uppercase cursor-pointer">
            Get In
        </a>
    </div>

</body>
</html>
