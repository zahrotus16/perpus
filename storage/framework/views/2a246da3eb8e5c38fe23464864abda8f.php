<?php $__env->startSection('title', isset($book) ? 'Edit Buku' : 'Tambah Buku'); ?>

<?php $__env->startSection('content'); ?>
<div class="relative min-h-screen p-6 lg:p-10 flex items-center justify-center">
    
    <div class="relative z-20 w-full max-w-5xl fade-in">
        
        
        <div class="bg-[#cfd8dc] rounded-[20px] p-8 lg:p-12 shadow-2xl overflow-hidden">
            
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-slate-800 uppercase tracking-wider"><?php echo e(isset($book) ? 'Edit Buku' : 'Tambah Buku'); ?></h1>
                <div class="h-1 w-full bg-slate-400/30 mt-2"></div>
            </div>

            <form action="<?php echo e(isset($book) ? route('admin.books.update', $book) : route('admin.books.store')); ?>" 
                  method="POST" enctype="multipart/form-data" class="space-y-8">
                <?php echo csrf_field(); ?>
                <?php if(isset($book)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                    
                    
                    <div class="space-y-4">
                        <h2 class="text-lg font-bold text-slate-800 tracking-tight border-b border-slate-400/30 pb-2">Cover Buku</h2>
                        
                        <div class="relative group">
                            <label class="cursor-pointer block">
                                <div id="cover-dropzone" 
                                     class="aspect-[4/5] bg-[#90a4ae] rounded-2xl border-4 border-dashed border-slate-400/50 flex flex-col items-center justify-center text-center p-6 transition-all hover:bg-[#78909c] hover:border-white/50">
                                    
                                    <?php if(isset($book) && $book->cover): ?>
                                        <img src="<?php echo e(asset('storage/'.$book->cover)); ?>" id="preview-img" class="w-full h-full object-cover rounded-xl">
                                        <div id="upload-placeholder" class="hidden">
                                            <i class="fas fa-cloud-upload-alt text-4xl text-white/50 mb-3"></i>
                                            <p class="text-white text-sm font-bold opacity-70">Drag files to upload</p>
                                        </div>
                                    <?php else: ?>
                                        <img src="" id="preview-img" class="w-full h-full object-cover rounded-xl hidden">
                                        <div id="upload-placeholder" class="flex flex-col items-center">
                                            <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center mb-4 shadow-inner">
                                                <i class="fas fa-image text-slate-400 text-3xl"></i>
                                            </div>
                                            <p class="text-slate-800 text-sm font-bold opacity-70 italic">Drag files to upload</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <input type="file" name="cover" class="hidden" onchange="previewImage(this)">
                            </label>
                        </div>
                    </div>

                    
                    <div class="space-y-4">
                        <h2 class="text-lg font-bold text-slate-800 tracking-tight border-b border-slate-400/30 pb-2">Detail Buku</h2>
                        
                        <div class="space-y-4">
                            
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1 ml-1">Judul Buku</label>
                                <input type="text" name="title" value="<?php echo e(old('title', $book->title ?? '')); ?>" required
                                       class="w-full bg-[#ecf0f1] border-none rounded-lg py-2.5 px-4 text-slate-800 font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#00b4ff] transition-all shadow-inner">
                            </div>

                            
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1 ml-1">Penulis</label>
                                <input type="text" name="author" value="<?php echo e(old('author', $book->author ?? '')); ?>" required
                                       class="w-full bg-[#ecf0f1] border-none rounded-lg py-2.5 px-4 text-slate-800 font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#00b4ff] transition-all shadow-inner">
                            </div>

                            
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1 ml-1">Penerbit</label>
                                <input type="text" name="publisher" value="<?php echo e(old('publisher', $book->publisher ?? '')); ?>" required
                                       class="w-full bg-[#ecf0f1] border-none rounded-lg py-2.5 px-4 text-slate-800 font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#00b4ff] transition-all shadow-inner">
                            </div>

                            
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1 ml-1">Tahun Terbit</label>
                                <input type="number" name="year" value="<?php echo e(old('year', $book->year ?? date('Y'))); ?>" required
                                       class="w-full bg-[#ecf0f1] border-none rounded-lg py-2.5 px-4 text-slate-800 font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#00b4ff] transition-all shadow-inner">
                            </div>

                            
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1 ml-1">Stok</label>
                                <input type="number" name="stock" value="<?php echo e(old('stock', $book->stock ?? 0)); ?>" required
                                       class="w-full bg-[#ecf0f1] border-none rounded-lg py-2.5 px-4 text-slate-800 font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#00b4ff] transition-all shadow-inner">
                            </div>

                            
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1 ml-1">Status</label>
                                <select name="status" class="w-full bg-[#ecf0f1] border-none rounded-lg py-2.5 px-4 text-slate-800 font-medium focus:ring-2 focus:ring-[#00b4ff] transition-all shadow-inner">
                                    <option value="available" <?php echo e((old('status', $book->status ?? 'available') == 'available') ? 'selected' : ''); ?>>Tersedia</option>
                                    <option value="unavailable" <?php echo e((old('status', $book->status ?? '') == 'unavailable') ? 'selected' : ''); ?>>Tidak Tersedia</option>
                                </select>
                            </div>

                            
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1 ml-1">ISBN</label>
                                <input type="text" name="isbn" value="<?php echo e(old('isbn', $book->isbn ?? '')); ?>" placeholder="Contoh: 978-602-..."
                                       class="w-full bg-[#ecf0f1] border-none rounded-lg py-2.5 px-4 text-slate-800 font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#00b4ff] transition-all shadow-inner">
                            </div>

                            
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1 ml-1">Jumlah Halaman</label>
                                <input type="number" name="pages" value="<?php echo e(old('pages', $book->pages ?? '')); ?>"
                                       class="w-full bg-[#ecf0f1] border-none rounded-lg py-2.5 px-4 text-slate-800 font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#00b4ff] transition-all shadow-inner">
                            </div>

                            
                            <div class="lg:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1 ml-1">Digital File (PDF) - Opsional</label>
                                <input type="file" name="pdf_file" accept=".pdf"
                                       class="w-full bg-[#ecf0f1] border-none rounded-lg py-2 px-4 text-slate-500 text-xs font-medium file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all">
                                <?php if(isset($book) && $book->pdf_file): ?>
                                    <p class="text-[10px] text-emerald-600 font-bold mt-1 ml-1 italic">File sudah tersedia: <a href="<?php echo e(asset('storage/'.$book->pdf_file)); ?>" target="_blank" class="underline">Lihat PDF</a></p>
                                <?php endif; ?>
                            </div>

                            
                            <div class="lg:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1 ml-1">Deskripsi / Sinopsis</label>
                                <textarea name="description" rows="4" 
                                          class="w-full bg-[#ecf0f1] border-none rounded-lg py-3 px-4 text-slate-800 font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#00b4ff] transition-all shadow-inner resize-none"><?php echo e(old('description', $book->description ?? '')); ?></textarea>
                            </div>

                            
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1 ml-1">Lokasi</label>
                                <input type="text" name="shelf_location" value="<?php echo e(old('shelf_location', $book->shelf_location ?? '')); ?>" placeholder="Contoh: Rak A1"
                                       class="w-full bg-[#ecf0f1] border-none rounded-lg py-2.5 px-4 text-slate-800 font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#00b4ff] transition-all shadow-inner">
                            </div>

                            
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1 ml-1">Kategori</label>
                                <select name="category_id" required class="w-full bg-[#ecf0f1] border-none rounded-lg py-2.5 px-4 text-slate-800 font-medium focus:ring-2 focus:ring-[#00b4ff] transition-all shadow-inner">
                                    <option value="">Pilih Kategori</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php echo e((old('category_id', $book->category_id ?? '') == $category->id) ? 'selected' : ''); ?>>
                                            <?php echo e($category->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="flex flex-col sm:flex-row justify-center gap-6 pt-8 border-t border-slate-400/30">
                    <a href="<?php echo e(route('admin.books.index')); ?>" 
                       class="bg-[#d32f2f] hover:bg-[#b71c1c] text-white px-16 py-3 rounded-full font-bold text-center shadow-lg transition-all active:scale-95">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-[#2e7d32] hover:bg-[#1b5e20] text-white px-16 py-3 rounded-full font-bold text-center shadow-lg transition-all active:scale-95">
                        Simpan Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('preview-img').classList.remove('hidden');
                document.getElementById('upload-placeholder').classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<style>
    .fade-in {
        animation: fadeIn 0.8s ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\perpustakaan-digital\resources\views/admin/books/create.blade.php ENDPATH**/ ?>