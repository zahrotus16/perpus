@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Pusat Akun')
@section('page-subtitle', 'Manajemen identitas dan keamanan data akun personal')



@section('content')
<div class="max-w-2xl mx-auto space-y-8">

    {{-- Universal Account Header Card --}}
    <div class="bg-white dark:bg-dark-card rounded-2xl shadow-xl dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 overflow-hidden">
        <div class="h-24 bg-gradient-to-r from-[#00bcd4] to-indigo-700 opacity-90"></div>
        <div class="px-8 pb-8 -mt-12">
            <div class="flex flex-col md:flex-row items-end gap-6 mb-8">
                <div class="w-24 h-24 rounded-3xl bg-white dark:bg-dark-card p-1.5 shadow-2xl relative z-10 group">
                    <div class="w-full h-full rounded-2xl overflow-hidden relative">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) . '?v=' . time() }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-[#00bcd4] to-indigo-600 flex items-center justify-center text-white text-4xl font-black">
                                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                            </div>
                        @endif
                        
                        {{-- Hover Overlay for Change --}}
                        <label for="avatar-input" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center cursor-pointer transition-opacity duration-300">
                            <i class="fas fa-camera text-white text-xl"></i>
                        </label>
                    </div>
                </div>
                <div class="flex-1 pb-2">
                    <h2 class="text-2xl font-black text-slate-800 dark:text-white tracking-tight leading-none mb-1">{{ auth()->user()->name }}</h2>
                    <p class="text-sm font-bold text-slate-400 dark:text-gray-500 mb-2">{{ auth()->user()->email }}</p>
                    <span class="inline-flex items-center gap-2 bg-slate-50 dark:bg-dark text-slate-400 dark:text-gray-600 px-3 py-1 rounded-xl font-mono text-[10px] font-black uppercase tracking-tighter border border-slate-100 dark:border-dark-border/10">
                        <i class="fas fa-fingerprint text-[8px]"></i> {{ auth()->user()->member_id }}
                    </span>
                </div>
            </div>

            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 pt-6 border-t border-slate-50 dark:border-dark-border/10">
                @csrf @method('PATCH')
                
                {{-- Hidden Avatar Input --}}
                <input type="file" name="avatar" id="avatar-input" class="hidden" onchange="previewAvatar(this)">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-500 dark:text-gray-400 mb-2 uppercase tracking-widest">Identitas Lengkap <span class="text-red-500 font-black">*</span></label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                            class="w-full px-5 py-3.5 bg-white dark:bg-dark border border-slate-200 dark:border-dark-border/10 rounded-2xl text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none transition-all shadow-sm @error('name') border-red-500 @enderror">
                        @error('name')<p class="text-red-500 text-[10px] mt-2 font-bold uppercase">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 dark:text-gray-400 mb-2 uppercase tracking-widest">Alamat Email Korespondensi <span class="text-red-500 font-black">*</span></label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                            class="w-full px-5 py-3.5 bg-white dark:bg-dark border border-slate-200 dark:border-dark-border/10 rounded-2xl text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none transition-all shadow-sm @error('email') border-red-500 @enderror">
                        @error('email')<p class="text-red-500 text-[10px] mt-2 font-bold uppercase">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 dark:text-gray-400 mb-2 uppercase tracking-widest">Nomor Handphone Terdaftar</label>
                        <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            class="w-full px-5 py-3.5 bg-white dark:bg-dark border border-slate-200 dark:border-dark-border/10 rounded-2xl text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none transition-all shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-500 dark:text-gray-400 mb-2 uppercase tracking-widest">Alamat Fisik Saat Ini</label>
                    <textarea name="address" rows="3" class="w-full px-5 py-3.5 bg-white dark:bg-dark border border-slate-200 dark:border-dark-border/10 rounded-2xl text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none transition-all shadow-sm resize-none leading-relaxed">{{ old('address', auth()->user()->address) }}</textarea>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="flex items-center gap-3 bg-[#2e7d32] hover:bg-[#1b5e20] text-white px-8 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest transition shadow-xl active:scale-95">
                        <i class="fas fa-save mr-1"></i> Perbarui Profil
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Security & Password Card --}}
    <div class="bg-white dark:bg-dark-card rounded-2xl shadow-sm dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 p-8">
        <h3 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-widest mb-6 flex items-center gap-3">
            <i class="fas fa-shield-halved text-primary-500"></i> Keamanan Data & Password
        </h3>
        <form action="{{ route('user.profile.password') }}" method="POST" class="space-y-6">
            @csrf @method('PATCH')
            <div>
                <label class="block text-[10px] font-black text-slate-500 dark:text-gray-400 mb-2 uppercase tracking-widest">Konfirmasi Password Saat Ini <span class="text-red-500 font-black">*</span></label>
                <input type="password" name="current_password" required
                    class="w-full px-5 py-3.5 bg-white dark:bg-dark border border-slate-200 dark:border-dark-border/10 rounded-2xl text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none transition-all shadow-sm @error('current_password') border-red-500 @enderror">
                @error('current_password')<p class="text-red-500 text-[10px] mt-2 font-bold uppercase">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 dark:text-gray-400 mb-2 uppercase tracking-widest">Password Baru <span class="text-red-500 font-black">*</span></label>
                    <input type="password" name="password" required
                        class="w-full px-5 py-3.5 bg-white dark:bg-dark border border-slate-200 dark:border-dark-border/10 rounded-2xl text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none transition-all shadow-sm @error('password') border-red-500 @enderror">
                    @error('password')<p class="text-red-500 text-[10px] mt-2 font-bold uppercase">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 dark:text-gray-400 mb-2 uppercase tracking-widest">Verifikasi Password Baru <span class="text-red-500 font-black">*</span></label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-5 py-3.5 bg-white dark:bg-dark border border-slate-200 dark:border-dark-border/10 rounded-2xl text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none transition-all shadow-sm">
                </div>
            </div>
            <div class="flex justify-end pt-4">
                <button type="submit" class="flex items-center gap-3 bg-slate-800 dark:bg-dark hover:bg-slate-700 dark:hover:bg-white/5 text-white px-8 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest transition border border-transparent dark:border-dark-border/20 shadow-xl active:scale-95">
                    <i class="fas fa-lock-open mr-1"></i> Mutakhirkan Password
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const container = input.closest('form').previousElementSibling.querySelector('.group .w-full.h-full');
                const img = container.querySelector('img');
                const placeholder = container.querySelector('.bg-gradient-to-br');
                
                if (img) {
                    img.src = e.target.result;
                } else {
                    const newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.className = 'w-full h-full object-cover';
                    if (placeholder) placeholder.remove();
                    container.prepend(newImg);
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
