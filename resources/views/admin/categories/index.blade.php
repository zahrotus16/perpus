@extends('layouts.app')
@section('title','Kategori')
@section('page-title','Kategori Buku')
@section('page-subtitle','Kelola kategori koleksi perpustakaan')


@section('content')
<div class="space-y-6">
    {{-- Content Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Manajemen Taksonomi Koleksi</h2>
        </div>
        <button onclick="openModal('addModal')" class="flex items-center justify-center gap-3 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition shadow-xl shadow-emerald-900/20 active:scale-95">
            <i class="fas fa-plus"></i> Tambah Kategori Baru
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    @forelse($categories as $cat)
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 group">
        <div class="flex items-start justify-between mb-5">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-inner" style="background:{{ $cat->color }}20; border: 1px solid {{ $cat->color }}30">
                <i class="fas fa-tag text-lg" style="color:{{ $cat->color }}"></i>
            </div>
            <div class="flex gap-1.5">
                <button onclick="openEdit({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ addslashes($cat->description ?? '') }}', '{{ $cat->color }}')"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition transition-all duration-200 text-sm">
                    <i class="fas fa-pen"></i>
                </button>
                <button type="button" 
                        onclick="openDeleteModal('{{ route('admin.categories.destroy', $cat) }}')"
                        class="w-8 h-8 flex items-center justify-center rounded-lg text-red-500 hover:text-red-700 hover:bg-red-50 transition transition-all duration-200 text-sm">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        <h3 class="font-bold text-slate-800 mb-1.5 group-hover:text-emerald-600 transition-colors">{{ $cat->name }}</h3>
        <p class="text-slate-400 text-xs mb-4 line-clamp-2 min-h-[32px]">{{ $cat->description ?: 'Tidak ada deskripsi' }}</p>
        <div class="flex items-center justify-between pt-4 border-t border-slate-50">
            <span class="text-[10px] font-bold px-2.5 py-1 rounded-full ring-1 ring-inset" 
                  style="background:{{ $cat->color }}20; color:{{ $cat->color }}; ring-color:{{ $cat->color }}40">
                {{ $cat->books_count }} buku
            </span>
            <div class="w-3.5 h-3.5 rounded-full border-2 border-white shadow-sm" style="background:{{ $cat->color }}"></div>
        </div>
    </div>
    @empty
    <div class="col-span-full bg-white rounded-2xl border border-slate-100 py-20 text-center shadow-sm">
        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-tags text-slate-300 text-3xl"></i>
        </div>
        <h3 class="font-bold text-slate-800 mb-2">Kategori Kosong</h3>
        <p class="text-sm text-slate-400 mb-6">Mulai dengan menambahkan kategori buku pertama anda.</p>
        <button onclick="openModal('addModal')" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition shadow-lg shadow-emerald-900/20">
            <i class="fas fa-plus mr-1"></i> Tambah Kategori
        </button>
    </div>
    @endforelse
</div>

{{-- Add Modal --}}
<div id="addModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 transition-all duration-300">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl border border-slate-200">
        <h3 class="font-extrabold text-slate-800 text-lg mb-6 border-b border-slate-100 pb-4">Tambah Kategori</h3>
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase">Nama Kategori <span class="text-red-500 font-bold">*</span></label>
                    <input type="text" name="name" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all shadow-sm">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all shadow-sm resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-2 uppercase">Palet Warna</label>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                        <div class="flex items-center gap-4 mb-3">
                            <input type="color" name="color" value="#6366f1" class="h-10 w-16 rounded-lg border border-slate-300 cursor-pointer p-1 bg-white shadow-sm">
                            <span class="text-xs text-slate-400 italic">Pilih warna kustom atau gunakan preset:</span>
                        </div>
                        <div class="flex gap-2.5 flex-wrap">
                            @foreach(['#6366f1','#0ea5e9','#10b981','#f59e0b','#ec4899','#8b5cf6','#ef4444','#06b6d4','#1e293b','#fbbf24'] as $c)
                            <button type="button" onclick="document.querySelector('[name=color]').value='{{ $c }}'" 
                                    class="w-7 h-7 rounded-full border-2 border-white shadow-sm hover:scale-110 active:scale-95 transition-all" 
                                    style="background:{{ $c }}"></button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-3 mt-8">
                <button type="button" onclick="closeModal('addModal')" class="flex-1 py-3 border border-slate-200 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold transition shadow-lg shadow-emerald-900/20">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div id="editModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 transition-all duration-300">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl border border-slate-200">
        <h3 class="font-extrabold text-slate-800 text-lg mb-6 border-b border-slate-100 pb-4">Edit Kategori</h3>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase">Nama Kategori <span class="text-red-500 font-bold">*</span></label>
                    <input type="text" name="name" id="edit-name" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all shadow-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase">Deskripsi</label>
                    <textarea name="description" id="edit-desc" rows="3" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all shadow-sm resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-2 uppercase">Warna Kategori</label>
                    <div class="flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-200">
                        <input type="color" name="color" id="edit-color" class="h-10 w-16 rounded-lg border border-slate-300 cursor-pointer p-1 bg-white shadow-sm">
                        <span class="text-xs text-slate-400 italic">Pilih palet warna identitas kategori.</span>
                    </div>
                </div>
            </div>
            <div class="flex gap-3 mt-8">
                <button type="button" onclick="closeModal('editModal')" class="flex-1 py-3 border border-slate-200 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold transition shadow-lg shadow-emerald-900/20">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
{{-- Custom Delete Modal --}}
<div id="deleteModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300" onclick="closeDeleteModal()"></div>
    
    <div class="relative z-10 w-full max-w-md bg-white rounded-2xl p-8 text-center shadow-2xl border border-slate-100 transform transition-all duration-300 scale-100">
        <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6 text-red-500">
            <i class="fas fa-tags text-3xl"></i>
        </div>
        
        <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-2">Hapus Kategori?</h2>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-10 leading-relaxed">
            Kategori ini akan dihapus secara permanen. <br>Lanjutkan penghapusan?
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
@endsection

@push('scripts')
<script>
function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

function openEdit(id, name, desc, color) {
    document.getElementById('editForm').action = '/admin/categories/' + id;
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-desc').value = desc;
    document.getElementById('edit-color').value = color;
    openModal('editModal');
}

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

// Close modals on backdrop click
document.querySelectorAll('[id$="Modal"]').forEach(el => {
    el.addEventListener('click', function(e) {
        if(e.target === this) closeModal(this.id);
    });
});
</script>
@endpush
