<?php $__env->startSection('content'); ?>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
        <!-- Form Tambah / Edit Jenis Sampah -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-slate-100 h-fit">
            <div class="flex justify-between items-center mb-4">
                <h3 id="form_title" class="font-bold text-base sm:text-lg text-slate-800">Form Jenis Sampah</h3>
                <button type="button" id="btn_reset" onclick="resetForm()" class="hidden text-xs font-semibold text-slate-400 hover:text-slate-600">
                    Batal Edit
                </button>
            </div>

            <form method="POST" action="<?php echo e(route('admin.wastes.store')); ?>" class="space-y-4 text-xs sm:text-sm">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" id="edit_id" value="<?php echo e(old('id')); ?>">
                <div>
                    <label class="block font-medium text-slate-700">Nama Sampah</label>
                    <input type="text" name="name" id="edit_name" value="<?php echo e(old('name')); ?>" required placeholder="Contoh: Botol Plastik PET" class="mt-1 w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block font-medium text-slate-700">Kategori</label>
                    <input type="text" name="category" id="edit_category" value="<?php echo e(old('category')); ?>" required placeholder="Plastik, Kertas, Metal..." class="mt-1 w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block font-medium text-slate-700">Harga Per Kg (Rp)</label>
                    <input type="number" step="100" min="0" name="price_per_kg" id="edit_price" value="<?php echo e(old('price_per_kg')); ?>" required placeholder="Contoh: 5000" class="mt-1 w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block font-medium text-slate-700">Deskripsi</label>
                    <textarea name="description" id="edit_description" rows="2" placeholder="Keterangan kondisi sampah" class="mt-1 w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500"><?php echo e(old('description')); ?></textarea>
                </div>
                <button type="submit" id="btn_submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 sm:py-3 rounded-xl transition shadow-sm">
                    Simpan Data
                </button>
            </form>
        </div>

        <!-- Tabel Daftar Jenis Sampah -->
        <div class="lg:col-span-2 bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-slate-100">
            <h3 class="font-bold text-base sm:text-lg mb-4 text-slate-800">Daftar Jenis & Harga Sampah</h3>
            <div class="overflow-x-auto -mx-5 sm:mx-0 px-5 sm:px-0">
                <table class="w-full text-left text-xs sm:text-sm min-w-[450px]">
                    <thead class="bg-slate-50 border-b border-slate-100 text-slate-500">
                        <tr>
                            <th class="p-3">Nama</th>
                            <th class="p-3">Kategori</th>
                            <th class="p-3">Harga/Kg</th>
                            <th class="p-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php $__empty_1 = true; $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="p-3 font-semibold text-slate-800 whitespace-nowrap"><?php echo e($t->name); ?></td>
                                <td class="p-3 whitespace-nowrap">
                                    <span class="bg-slate-100 text-slate-700 px-2 py-0.5 rounded-lg text-xs"><?php echo e($t->category); ?></span>
                                </td>
                                <td class="p-3 font-bold text-emerald-600 whitespace-nowrap">Rp <?php echo e(number_format($t->price_per_kg, 0, ',', '.')); ?></td>
                                <td class="p-3 text-right space-x-2 whitespace-nowrap">
                                    <button type="button" onclick='fillForm(<?php echo json_encode($t, 15, 512) ?>)' class="text-emerald-600 hover:underline font-semibold text-xs">
                                        Edit
                                    </button>
                                    <a href="<?php echo e(route('admin.wastes.delete', $t->id)); ?>" onclick="return confirm('Hapus jenis sampah ini?')" class="text-red-500 hover:underline font-semibold text-xs">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="p-6 text-center text-slate-400">Belum ada jenis sampah ditambahkan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function fillForm(data) {
    document.getElementById('edit_id').value = data.id;
    document.getElementById('edit_name').value = data.name;
    document.getElementById('edit_category').value = data.category;
    document.getElementById('edit_price').value = data.price_per_kg;
    document.getElementById('edit_description').value = data.description || '';
    document.getElementById('form_title').innerText = 'Edit Jenis Sampah';
    document.getElementById('btn_submit').innerText = 'Perbarui Data';
    document.getElementById('btn_reset').classList.remove('hidden');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetForm() {
    document.getElementById('edit_id').value = '';
    document.getElementById('edit_name').value = '';
    document.getElementById('edit_category').value = '';
    document.getElementById('edit_price').value = '';
    document.getElementById('edit_description').value = '';
    document.getElementById('form_title').innerText = 'Form Jenis Sampah';
    document.getElementById('btn_submit').innerText = 'Simpan Data';
    document.getElementById('btn_reset').classList.add('hidden');
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', ['title' => 'Kelola Jenis Sampah — Admin BOWO'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\BOWO_Laravel\resources\views/admin/waste-types.blade.php ENDPATH**/ ?>