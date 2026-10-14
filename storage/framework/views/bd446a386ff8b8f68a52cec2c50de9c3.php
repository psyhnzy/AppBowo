<?php $__env->startSection('content'); ?>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800">Riwayat Mutasi Saldo</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Catatan pemasukan saldo dari hasil penimbangan sampah Anda.</p>
        </div>
    </div>

    
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-2xl shrink-0">💰</div>
            <div>
                <div class="text-slate-500 text-xs font-medium">Saldo Saat Ini</div>
                <div class="text-xl sm:text-2xl font-black text-emerald-600 mt-0.5">
                    Rp <?php echo e(number_format($user->balance, 0, ',', '.')); ?>

                </div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-2xl shrink-0">⭐</div>
            <div>
                <div class="text-slate-500 text-xs font-medium">Total Poin Kontribusi</div>
                <div class="text-xl sm:text-2xl font-black text-amber-500 mt-0.5">
                    <?php echo e(number_format($user->points)); ?> Pts
                </div>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6">
        <h3 class="font-bold text-base sm:text-lg text-slate-800 mb-4">Riwayat Transaksi</h3>
        <div class="overflow-x-auto -mx-5 sm:mx-0 px-5 sm:px-0">
            <table class="w-full text-left text-xs sm:text-sm min-w-[500px]">
                <thead class="bg-slate-50 border-b border-slate-100 text-slate-500">
                    <tr>
                        <th class="p-3">Tanggal Transaksi</th>
                        <th class="p-3">Keterangan</th>
                        <th class="p-3 text-center">Tipe</th>
                        <th class="p-3 text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="p-3 text-slate-500 whitespace-nowrap">
                                <?php echo e($tx->created_at ? \Carbon\Carbon::parse($tx->created_at)->format('d M Y, H:i') : '-'); ?>

                            </td>
                            <td class="p-3 font-medium text-slate-800"><?php echo e($tx->description); ?></td>
                            <td class="p-3 text-center whitespace-nowrap">
                                <?php if($tx->type === 'setoran_masuk'): ?>
                                    <span class="inline-block bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded-full font-bold">Kredit (Masuk)</span>
                                <?php else: ?>
                                    <span class="inline-block bg-slate-100 text-slate-800 text-xs px-2.5 py-1 rounded-full font-bold"><?php echo e(ucfirst($tx->type)); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="p-3 font-black text-emerald-600 text-right whitespace-nowrap">+Rp <?php echo e(number_format($tx->amount, 0, ',', '.')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-400">
                                <div class="text-3xl mb-2">📭</div>
                                Belum ada catatan mutasi saldo.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', ['title' => 'Riwayat & Mutasi Saldo — BOWO'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\BOWO_Laravel\resources\views/user/riwayat.blade.php ENDPATH**/ ?>