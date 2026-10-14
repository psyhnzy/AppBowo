<?php $__env->startSection('content'); ?>
    <div class="max-w-2xl mx-auto bg-white p-5 sm:p-8 rounded-2xl shadow-sm border border-slate-100">
        <h2 class="text-xl sm:text-2xl font-bold mb-6 text-slate-800">Form Setoran Sampah</h2>

        <form method="POST" action="<?php echo e(route('user.setor.store')); ?>" class="space-y-4 text-sm sm:text-base">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-slate-700">Pilih Jenis Sampah</label>
                <select name="waste_type_id" id="waste_type_id" onchange="calculateValue()" required class="mt-1 w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 text-sm">
                    <option value="" data-price="0">-- Pilih Jenis Sampah --</option>
                    <?php $__currentLoopData = $waste_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($w->id); ?>" data-price="<?php echo e($w->price_per_kg); ?>" <?php echo e(old('waste_type_id') == $w->id ? 'selected' : ''); ?>>
                            <?php echo e($w->name); ?> (Rp <?php echo e(number_format($w->price_per_kg, 0, ',', '.')); ?>/kg)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-slate-700">Berat (Kg)</label>
                <input type="number" step="0.01" min="0.01" name="weight" id="weight" value="<?php echo e(old('weight')); ?>" oninput="calculateValue()" required placeholder="Contoh: 2.5" class="mt-1 w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 text-sm">
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-slate-700">Tanggal Penyerahan</label>
                <input type="date" name="deposit_date" value="<?php echo e(old('deposit_date', date('Y-m-d'))); ?>" required class="mt-1 w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 text-sm">
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-slate-700">Catatan Tambahan</label>
                <textarea name="notes" rows="2" placeholder="Kondisi sampah atau keterangan lainnya (opsional)" class="mt-1 w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 text-sm"><?php echo e(old('notes')); ?></textarea>
            </div>

            <!-- Estimasi Nilai & Poin -->
            <div class="p-4 bg-emerald-50/80 rounded-xl border border-emerald-100 text-xs sm:text-sm">
                <div class="text-slate-600">Estimasi Nilai Setoran: <span id="est_val" class="font-bold text-emerald-700 text-sm sm:text-base">Rp 0</span></div>
                <div class="text-slate-600 mt-1">Estimasi Poin Diperoleh: <span id="est_pts" class="font-bold text-amber-600 text-sm sm:text-base">0 Pts</span></div>
            </div>

            <!-- Tombol Responsif (Stack di mobile, berdampingan di desktop) -->
            <div class="flex flex-col-reverse sm:flex-row gap-3 sm:gap-4 pt-3 sm:pt-4">
                <a href="<?php echo e(route('user.dashboard')); ?>" class="w-full sm:w-1/2 text-center py-2.5 sm:py-3 border border-slate-200 rounded-xl font-semibold text-slate-600 hover:bg-slate-50 transition text-sm">
                    Kembali
                </a>
                <button type="submit" class="w-full sm:w-1/2 bg-emerald-600 text-white font-bold py-2.5 sm:py-3 rounded-xl hover:bg-emerald-700 transition shadow-sm text-sm">
                    Kirim Setoran
                </button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function calculateValue() {
    const select = document.getElementById('waste_type_id');
    const price = parseFloat(select.options[select.selectedIndex]?.getAttribute('data-price')) || 0;
    const weight = parseFloat(document.getElementById('weight').value) || 0;
    
    const total = price * weight;
    const points = Math.ceil(weight * 10);

    document.getElementById('est_val').innerText = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('est_pts').innerText = points + ' Pts';
}
document.addEventListener('DOMContentLoaded', calculateValue);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.user', ['title' => 'Setor Sampah — BOWO'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\BOWO_Laravel\resources\views/user/setor.blade.php ENDPATH**/ ?>