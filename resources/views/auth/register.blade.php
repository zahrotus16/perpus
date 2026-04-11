<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Perpustakaan.digital</title>
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

        .btn-register {
            background: #ff2d20;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(255, 45, 32, 0.3);
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
    <div class="relative z-20 w-full max-w-[800px]">
        <div class="glass-card rounded-[30px] p-8 md:p-12 text-center fade-in">
            <!-- Round Logo -->
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 rounded-full bg-white flex items-center justify-center border-4 border-white/20 shadow-xl overflow-hidden">
                   <div class="flex flex-col items-center">
                       <i class="fas fa-book-open text-[#0096ff] text-2xl mb-1"></i>
                       <div class="w-6 h-0.5 bg-[#0096ff] rounded-full"></div>
                   </div>
                </div>
            </div>

            <!-- Title & Branding -->
            <div class="mb-8">
                <h1 class="text-3xl font-black tracking-tight uppercase">DAFTAR AKUN</h1>
                <p class="text-white/80 font-medium text-sm mt-1">Perpustakaan<span class="font-light">.digital</span></p>
            </div>

            <!-- Registration Form -->
            <form action="{{ route('register.post') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-left">
                    <!-- Nama -->
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-white/70 uppercase tracking-widest ml-4">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" 
                               placeholder="Nama Lengkap" required
                               class="input-glass w-full py-3.5 px-6 rounded-full text-slate-800 text-sm font-semibold placeholder-slate-400 focus:outline-none @error('name') ring-2 ring-red-400 @enderror">
                        @error('name')<p class="text-[10px] text-red-200 mt-1 ml-4 font-bold italic">{{ $message }}</p>@enderror
                    </div>

                    <!-- NIS (member_id) -->
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-white/70 uppercase tracking-widest ml-4">NIS (Nomor Induk Siswa)</label>
                        <input type="text" name="member_id" value="{{ old('member_id') }}" 
                               placeholder="Contoh: 12345" required
                               class="input-glass w-full py-3.5 px-6 rounded-full text-slate-800 text-sm font-semibold placeholder-slate-400 focus:outline-none @error('member_id') ring-2 ring-red-400 @enderror">
                        @error('member_id')<p class="text-[10px] text-red-200 mt-1 ml-4 font-bold italic">{{ $message }}</p>@enderror
                    </div>

                    <!-- Gmail (Email) -->
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-white/70 uppercase tracking-widest ml-4">Alamat Email (Gmail)</label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                               placeholder="nama@gmail.com" required
                               class="input-glass w-full py-3.5 px-6 rounded-full text-slate-800 text-sm font-semibold placeholder-slate-400 focus:outline-none @error('email') ring-2 ring-red-400 @enderror">
                        @error('email')<p class="text-[10px] text-red-200 mt-1 ml-4 font-bold italic">{{ $message }}</p>@enderror
                    </div>

                    <!-- No. Telepon -->
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-white/70 uppercase tracking-widest ml-4">No. Telepon</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" 
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                               placeholder="0812xxxxxx" required
                               class="input-glass w-full py-3.5 px-6 rounded-full text-slate-800 text-sm font-semibold placeholder-slate-400 focus:outline-none @error('phone') ring-2 ring-red-400 @enderror">
                        @error('phone')<p class="text-[10px] text-red-200 mt-1 ml-4 font-bold italic">{{ $message }}</p>@enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-white/70 uppercase tracking-widest ml-4">Jenis Kelamin</label>
                        <select name="gender" required
                                class="input-glass w-full py-3.5 px-6 rounded-full text-slate-800 text-sm font-semibold placeholder-slate-400 focus:outline-none appearance-none @error('gender') ring-2 ring-red-400 @enderror">
                            <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')<p class="text-[10px] text-red-200 mt-1 ml-4 font-bold italic">{{ $message }}</p>@enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-white/70 uppercase tracking-widest ml-4">Password</label>
                        <div class="relative group">
                            <input type="password" id="password" name="password" 
                                   placeholder="********" required
                                   class="input-glass w-full py-3.5 px-6 pr-12 rounded-full text-slate-800 text-sm font-semibold placeholder-slate-400 focus:outline-none transition-all @error('password') ring-2 ring-red-400 @enderror">
                            <button type="button" onclick="togglePassword('password', 'eyeIcon')" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#0096ff] transition-colors focus:outline-none">
                                <i class="fas fa-eye text-[14px]" id="eyeIcon"></i>
                            </button>
                        </div>
                        @error('password')<p class="text-[10px] text-red-200 mt-1 ml-4 font-bold italic">{{ $message }}</p>@enderror
                    </div>

                    <!-- Alamat -->
                    <div class="space-y-1 md:col-span-2">
                        <label class="block text-xs font-bold text-white/70 uppercase tracking-widest ml-4">Alamat Lengkap</label>
                        <textarea name="address" rows="2" placeholder="Masukkan alamat lengkap Anda..." required
                                  class="input-glass w-full py-4 px-6 rounded-[20px] text-slate-800 text-sm font-semibold placeholder-slate-400 focus:outline-none resize-none @error('address') ring-2 ring-red-400 @enderror">{{ old('address') }}</textarea>
                        @error('address')<p class="text-[10px] text-red-200 mt-1 ml-4 font-bold italic">{{ $message }}</p>@enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="hidden">
                        {{-- Hidden but included because of confirmation validation --}}
                        <input type="password" name="password_confirmation" id="password_confirmation">
                    </div>
                </div>

                {{-- We'll sync password_confirmation manually using JS to keep the UI clean, 
                     or just add it back if the user prefers. Let's add it back within the grid for safety. --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-left">
                     <div class="space-y-1 md:col-span-2">
                         <div class="border-t border-white/10 my-2"></div>
                     </div>
                     <div class="space-y-1 md:col-span-2">
                        <label class="block text-xs font-bold text-white/70 uppercase tracking-widest ml-4">Konfirmasi Password</label>
                        <div class="relative group">
                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                   placeholder="Ulangi Password" required
                                   class="input-glass w-full py-3.5 px-6 pr-12 rounded-full text-slate-800 text-sm font-semibold placeholder-slate-400 focus:outline-none transition-all">
                            <button type="button" onclick="togglePassword('password_confirmation', 'eyeIconConfirm')" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#0096ff] transition-colors focus:outline-none">
                                <i class="fas fa-eye text-[14px]" id="eyeIconConfirm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6">
                    <button type="submit" 
                            class="btn-register w-full max-w-[300px] py-4 px-10 rounded-full font-black text-sm tracking-[0.2em] uppercase mx-auto block shadow-2xl">
                            DAFTAR SEKARANG
                    </button>
                </div>
            </form>

            <!-- Login Link -->
            <div class="mt-10">
                <a href="{{ route('login') }}" class="text-white hover:text-[#00c6ff] font-medium text-sm transition-all italic border-b border-white/20 pb-1">
                    Sudah punya akun? Silakan Login...
                </a>
            </div>
            
            <!-- Footer Copyright -->
            <div class="mt-8 opacity-40 text-[9px] uppercase tracking-[0.2em] font-semibold">
                &copy; 2026 DigiLib Digital Library • Platform Literasi Masa Depan
            </div>
        </div>
    </div>

    <script>
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

