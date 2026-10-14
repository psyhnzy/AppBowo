<?php $__env->startSection('content'); ?>

    
    <div class="relative bg-gradient-to-br from-slate-800 via-slate-700 to-emerald-800 rounded-2xl sm:rounded-3xl p-5 sm:p-8 mb-6 sm:mb-8 overflow-hidden shadow-lg">
        
        <div class="absolute -top-6 -right-6 w-36 h-36 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-8 -left-4 w-48 h-48 bg-emerald-600/10 rounded-full"></div>

        <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="bg-white/10 backdrop-blur-sm p-2 sm:p-2.5 rounded-xl shadow-inner shrink-0">
                    <img src="<?php echo e(asset('assets/images/bowo.png')); ?>" alt="BOWO Logo" class="h-9 sm:h-11 w-auto">
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-2xl sm:text-3xl font-black text-white tracking-wide">BOWO</span>
                        <span class="inline-block bg-emerald-500/30 text-emerald-300 text-xs font-bold px-2 py-0.5 rounded-full">Admin</span>
                    </div>
                    <p class="text-slate-300 text-xs sm:text-sm mt-0.5">Bank of Waste Online — Panel Administrasi</p>
                </div>
            </div>
            
            <div class="text-left sm:text-right">
                <h2 class="text-lg sm:text-xl font-black text-white">Selamat Datang 👋</h2>
                <p class="text-slate-300 text-xs sm:text-sm mt-0.5"><?php echo e(auth()->user()->name ?? 'Administrator'); ?></p>
                <span class="inline-block mt-2 bg-amber-500/20 text-amber-300 text-xs font-bold px-3 py-1 rounded-full">
                    <?php echo e(count($pending)); ?> Setoran Menunggu
                </span>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5 mb-6 sm:mb-8">
        <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md hover:border-blue-100 transition-all">
            <div class="text-2xl mb-2">👥</div>
            <div class="text-slate-500 text-xs font-medium">Total Nasabah</div>
            <div class="text-2xl sm:text-3xl font-black text-slate-800 mt-1"><?php echo e(number_format($stats['users'])); ?></div>
        </div>
        <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md hover:border-amber-100 transition-all">
            <div class="text-2xl mb-2">⏳</div>
            <div class="text-slate-500 text-xs font-medium">Menunggu Verifikasi</div>
            <div class="text-2xl sm:text-3xl font-black text-amber-500 mt-1"><?php echo e(number_format($stats['pending'])); ?></div>
        </div>
        <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md hover:border-emerald-100 transition-all">
            <div class="text-2xl mb-2">♻️</div>
            <div class="text-slate-500 text-xs font-medium">Sampah Terverifikasi</div>
            <div class="text-2xl sm:text-3xl font-black text-emerald-600 mt-1">
                <?php echo e(number_format($stats['weight'], 1)); ?> <span class="text-base font-semibold">kg</span>
            </div>
        </div>
        <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md hover:border-teal-100 transition-all">
            <div class="text-2xl mb-2">💵</div>
            <div class="text-slate-500 text-xs font-medium">Total Nilai Disetor</div>
            <div class="text-lg sm:text-xl font-black text-emerald-600 mt-1 leading-tight">
                Rp <?php echo e(number_format($stats['value'], 0, ',', '.')); ?>

            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <span class="text-lg">📋</span>
                <h3 class="font-bold text-base sm:text-lg text-slate-800">Setoran Menunggu Verifikasi</h3>
            </div>
            <?php if(count($pending) > 0): ?>
                <span class="bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1 rounded-full">
                    <?php echo e(count($pending)); ?> baru
                </span>
            <?php endif; ?>
        </div>

        <div class="overflow-x-auto -mx-5 sm:mx-0 px-5 sm:px-0">
            <table class="w-full text-left text-xs sm:text-sm min-w-[650px]">
                <thead class="bg-slate-50 border-b border-slate-100 text-slate-500">
                    <tr>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Nasabah</th>
                        <th class="p-3">Jenis Sampah</th>
                        <th class="p-3">Berat</th>
                        <th class="p-3">Total Nilai</th>
                        <th class="p-3">Poin</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $pending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="p-3 text-slate-500 whitespace-nowrap">
                                <?php echo e(is_string($p->deposit_date) ? $p->deposit_date : $p->deposit_date?->format('d M Y')); ?>

                            </td>
                            <td class="p-3 whitespace-nowrap">
                                <div class="font-bold text-slate-800"><?php echo e($p->user->name ?? 'Nasabah'); ?></div>
                                <div class="text-xs text-slate-400"><?php echo e($p->user->phone ?? '-'); ?></div>
                            </td>
                            <td class="p-3 font-medium text-slate-800 whitespace-nowrap"><?php echo e($p->wasteType->name ?? '-'); ?></td>
                            <td class="p-3 font-semibold whitespace-nowrap"><?php echo e($p->weight); ?> kg</td>
                            <td class="p-3 font-bold text-emerald-600 whitespace-nowrap">Rp <?php echo e(number_format($p->total_value, 0, ',', '.')); ?></td>
                            <td class="p-3 font-bold text-amber-500 whitespace-nowrap"><?php echo e($p->points); ?> Pts</td>
                            <td class="p-3 whitespace-nowrap">
                                <form action="<?php echo e(route('admin.verify', $p->id)); ?>" method="POST" class="flex items-center justify-center gap-2">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="deposit_id" value="<?php echo e($p->id); ?>">
                                    <button type="submit" name="action" value="verifikasi"
                                        onclick="return confirm('Verifikasi setoran ini?')"
                                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition shadow-sm">
                                        ✅ Setujui
                                    </button>
                                    <button type="submit" name="action" value="ditolak"
                                        onclick="return confirm('Tolak setoran ini?')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition shadow-sm">
                                        ❌ Tolak
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="p-10 text-center text-slate-400">
                                <div class="text-4xl mb-3">🎉</div>
                                <p class="font-semibold text-slate-500">Semua setoran telah diverifikasi!</p>
                                <p class="text-xs mt-1">Tidak ada pengajuan yang menunggu.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', ['title' => 'Dashboard Admin — BOWO'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\BOWO_Laravel\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>