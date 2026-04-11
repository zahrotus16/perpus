@extends('layouts.app')
@section('title', 'Tambah Anggota')

@section('content')
<div class="relative min-h-screen p-6 lg:p-10 flex items-center justify-center fade-in">
    
    {{-- Form Container --}}
    <div class="relative z-20 w-full max-w-4xl bg-white rounded-2xl shadow-2xl p-10 overflow-hidden">
        
        <h2 class="text-3xl font-black text-slate-800 mb-8 tracking-tight">Tambah Anggota</h2>
        
        <div class="border-t-2 border-slate-100 mb-8"></div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Nama --}}
                <div class="space-y-2">
                    <label class="block text-xl font-black text-slate-800">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama anggota" required
                           class="w-full px-6 py-4 bg-white border border-slate-200 rounded-lg text-lg font-bold text-slate-800 focus:ring-2 focus:ring-[#00b4ff] transition-all">
                </div>

                {{-- NIS --}}
                <div class="space-y-2">
                    <label class="block text-xl font-black text-slate-800">NIS</label>
                    <input type="text" name="member_id" value="{{ old('member_id') }}" placeholder="Masukkan NIS" required
                           class="w-full px-6 py-4 bg-white border border-slate-200 rounded-lg text-lg font-bold text-slate-800 focus:ring-2 focus:ring-[#00b4ff] transition-all">
                </div>

                {{-- Nomor Handphone Terdaftar --}}
                <div class="space-y-2">
                    <label class="block text-xl font-black text-slate-800">Nomor Handphone Terdaftar</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Masukkan nomor telepon"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                           class="w-full px-6 py-4 bg-white border border-slate-200 rounded-lg text-lg font-bold text-slate-800 focus:ring-2 focus:ring-[#00b4ff] transition-all">
                </div>

                {{-- Status / Setatus --}}
                <div class="space-y-2">
                    <label class="block text-xl font-black text-slate-800">Status</label>
                    <div class="relative">
                        <select name="status" class="w-full px-6 py-4 bg-white border border-slate-200 rounded-lg text-lg font-bold text-slate-800 focus:ring-2 focus:ring-[#00b4ff] transition-all appearance-none">
                            <option value="active" selected>Aktif</option>
                            <option value="inactive">Nonaktif</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none"></i>
                    </div>
                </div>

                {{-- Jenis Kelamin --}}
                <div class="space-y-2">
                    <label class="block text-xl font-black text-slate-800">Jenis Kelamin</label>
                    <div class="relative">
                        <select name="gender" class="w-full px-6 py-4 bg-white border border-slate-200 rounded-lg text-lg font-bold text-slate-800 focus:ring-2 focus:ring-[#00b4ff] transition-all appearance-none">
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none"></i>
                    </div>
                </div>

                {{-- Alamat --}}
                <div class="space-y-2">
                    <label class="block text-xl font-black text-slate-800">Alamat</label>
                    <textarea name="address" rows="1" placeholder="Masukkan alamat"
                              class="w-full px-6 py-4 bg-white border border-slate-200 rounded-lg text-lg font-bold text-slate-800 focus:ring-2 focus:ring-[#00b4ff] transition-all resize-none">{{ old('address') }}</textarea>
                </div>

                {{-- Hidden Fields for System --}}
                <input type="hidden" name="role" value="anggota">
                <input type="hidden" name="email" value="user_{{ time() }}@digilib.test">
                <input type="hidden" name="password" value="password123">
            </div>

            <div class="flex flex-col md:flex-row items-center justify-between gap-6 mt-10">
                <a href="{{ route('admin.users.index') }}" 
                   class="w-full md:w-auto bg-[#c62828] hover:bg-[#b71c1c] text-white px-20 py-3 rounded-full font-black text-lg transition-all active:scale-95 text-center shadow-lg uppercase tracking-wider">
                    Batal
                </a>
                <button type="submit" 
                        class="w-full md:w-auto bg-[#a5d6a7] hover:bg-[#81c784] text-white px-24 py-3 rounded-full font-black text-lg transition-all active:scale-95 text-center shadow-lg uppercase tracking-wider">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>



<style>
    .fade-in { animation: fadeIn 0.6s ease-out forwards; }
    .modal-appear { animation: modalAppear 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes modalAppear { from { opacity: 0; transform: scale(0.9) translateY(20px); } to { opacity: 1; transform: scale(1) translateY(0); } }
</style>
@endsection
