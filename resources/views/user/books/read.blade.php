<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesi Baca: {{ $book->title }} — DigiLib</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        dark: '#121212',
                        'dark-card': '#1e1e1e',
                        'dark-border': '#B0B0B0',
                        primary: { 500: '#6366f1', 600: '#4f46e5', 700: '#4338ca', 900: '#312e81' }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; cursor: default; }
        body { background: #121212; color: #FFFFFF; }
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #444; }
        .reader-header { background: #1e1e1e; border-bottom: 1px solid rgba(176,176,176,0.1); }
        .btn-reader { cursor: pointer; transition: all .2s; }
        .btn-reader:hover { background: rgba(255,255,255,0.05); }
    </style>
</head>
<body class="h-screen flex flex-col overflow-hidden select-none">

    {{-- Universal High-Contrast Reader Bar --}}
    <header class="reader-header h-16 flex items-center px-6 gap-6 flex-shrink-0 relative z-20 shadow-2xl">
        <a href="{{ route('user.books.show', $book) }}"
           class="btn-reader group flex items-center gap-3 text-gray-400 hover:text-white px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all border border-transparent hover:border-gray-800">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
            <span class="hidden sm:inline">Tutup</span>
        </a>

        <div class="h-8 w-px bg-gray-800 hidden sm:block"></div>

        {{-- Dynamic Identity --}}
        <div class="flex items-center gap-4 flex-1 min-w-0">
            @if($book->cover)
                <img src="{{ asset('storage/'.$book->cover) }}" alt="" class="h-10 w-8 object-cover rounded shadow-lg flex-shrink-0 ring-1 ring-white/10">
            @endif
            <div class="min-w-0">
                <p class="text-white text-sm font-black truncate tracking-tight uppercase">{{ $book->title }}</p>
                <p class="text-gray-500 text-[10px] font-bold truncate tracking-widest uppercase italic opacity-80">{{ $book->author }}</p>
            </div>
        </div>

        {{-- Meta Controls --}}
        <div class="flex items-center gap-3 flex-shrink-0">
            <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest hidden lg:flex items-center gap-2 px-3 py-1.5 bg-emerald-500/10 rounded-xl border border-emerald-500/20 shadow-sm">
                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                Digital Secured
            </span>
            
            <a href="{{ asset('storage/'.$book->pdf_file) }}" download="{{ $book->title }}.pdf"
               class="btn-reader flex items-center gap-3 text-gray-400 hover:text-white px-4 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all border border-transparent hover:border-gray-800">
                <i class="fas fa-download"></i>
                <span class="hidden sm:inline">Arsipkan</span>
            </a>
            
            <button onclick="toggleFullscreen()"
                    class="btn-reader w-10 h-10 flex items-center justify-center text-gray-400 hover:text-white rounded-xl transition-all border border-transparent hover:border-gray-800">
                <i class="fas fa-expand text-sm" id="fs-icon"></i>
            </button>
        </div>
    </header>

    {{-- Immersive Frame Container --}}
    <main class="flex-1 overflow-hidden relative bg-black/50">
        <iframe
            id="pdf-frame"
            src="{{ asset('storage/'.$book->pdf_file) }}#toolbar=0&navpanes=0&scrollbar=1&view=FitH"
            class="w-full h-full border-none opacity-0 transition-opacity duration-1000"
            title="{{ $book->title }}"
            onload="this.style.opacity='1'">
        </iframe>
        
        {{-- Custom Loading --}}
        <div id="pdf-loader" class="absolute inset-0 flex flex-col items-center justify-center bg-[#121212] z-10 pointer-events-none transition-opacity duration-700">
            <div class="w-12 h-12 border-4 border-gray-800 border-t-primary-500 rounded-full animate-spin mb-4"></div>
            <p class="text-[10px] font-black text-gray-600 uppercase tracking-widest animate-pulse">Memuat Transkrip Digital...</p>
        </div>
    </main>

    <script>
        function toggleFullscreen() {
            const icon = document.getElementById('fs-icon');
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
                icon.className = 'fas fa-compress text-sm';
            } else {
                document.exitFullscreen();
                icon.className = 'fas fa-expand text-sm';
            }
        }

        document.addEventListener('fullscreenchange', () => {
            if (!document.fullscreenElement) {
                document.getElementById('fs-icon').className = 'fas fa-expand text-sm';
            }
        });
        
        const iframe = document.getElementById('pdf-frame');
        iframe.onload = () => {
            iframe.style.opacity = '1';
            document.getElementById('pdf-loader').style.opacity = '0';
        };
    </script>
</body>
</html>
