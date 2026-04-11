@extends('layouts.app')
@section('title', 'Data Anggota')
@section('page-title', 'Data Anggota')
@section('page-subtitle', 'Manajemen keanggotaan dan status aktif perpustakaan')

@section('content')
<div class="space-y-6">
    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Direktori Keanggotaan</h2>
        </div>
        <a href="{{ route('admin.users.create') }}" class="flex items-center justify-center gap-3 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition shadow-xl shadow-emerald-900/20 active:scale-95">
            <i class="fas fa-plus text-sm"></i> Tambah Anggota Baru
        </a>
    </div>

    {{-- Main Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        {{-- Card Header/Search (Optional) --}}
        <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between bg-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <i class="fas fa-users text-lg"></i>
                </div>
                <div>
                    <h3 class="font-black text-slate-800 uppercase tracking-widest text-xs">Daftar Anggota</h3>
                    <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase">Total {{ $users->total() }} anggota terdaftar</p>
                </div>
            </div>
        </div>

        {{-- Table Container --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5">Nama Lengkap</th>
                        <th class="px-8 py-5">ID / NISN</th>
                        <th class="px-8 py-5 text-center">Status</th>
                        <th class="px-8 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-medium whitespace-nowrap">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 border border-slate-200 overflow-hidden shrink-0">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-xs font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-slate-800 block leading-none">{{ $user->name }}</span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase mt-1 block">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <span class="px-2.5 py-1 bg-slate-50 rounded-lg text-[10px] font-bold font-mono text-slate-600 border border-slate-200 group-hover:border-emerald-500/30 transition-colors tracking-wider">
                                {{ $user->member_id }}
                            </span>
                        </td>
                        <td class="px-8 py-4 text-center">
                            @if($user->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 text-[9px] font-black uppercase tracking-tighter">
                                    <span class="w-1 h-1 rounded-full bg-emerald-600"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-500 border border-slate-200 text-[9px] font-black uppercase tracking-tighter">
                                    <span class="w-1 h-1 rounded-full bg-slate-500"></span>
                                    Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.users.show', $user) }}" 
                                   class="px-4 py-1.5 bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white rounded-lg text-[10px] font-black uppercase tracking-widest transition shadow-sm hover:shadow-emerald-900/10 active:scale-95">
                                    Detail
                                </a>
                                <div class="flex items-center gap-1 border-l border-slate-200 pl-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all duration-200 text-xs">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            onclick="openDeleteModal('{{ route('admin.users.destroy', $user) }}')"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-red-500 hover:text-red-700 hover:bg-red-50 transition-all duration-200 text-xs">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center mb-4">
                                    <i class="fas fa-users-slash text-slate-300 text-xl"></i>
                                </div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Belum ada data anggota ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Footer --}}
        @if($users->hasPages())
        <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/30">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Custom Delete Modal --}}
<div id="deleteModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300" onclick="closeDeleteModal()"></div>
    
    <div class="relative z-10 w-full max-w-md bg-white rounded-2xl p-8 text-center shadow-2xl border border-slate-100 transform transition-all duration-300 scale-100">
        <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6 text-red-500">
            <i class="fas fa-user-times text-3xl"></i>
        </div>
        
        <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-2">Hapus Anggota?</h2>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-10 leading-relaxed">
            Data anggota yang dihapus tidak dapat dikembalikan. <br>Lanjutkan penghapusan?
        </p>

        <div class="flex items-center gap-4">
            <button onclick="closeDeleteModal()" 
                    class="flex-1 px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all active:scale-95 shadow-sm">
                Batal
            </button>
            <form id="deleteForm" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="w-full px-6 py-3.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all active:scale-95 shadow-lg shadow-red-900/20">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openDeleteModal(actionUrl) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        form.action = actionUrl;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endpush
@endsection
