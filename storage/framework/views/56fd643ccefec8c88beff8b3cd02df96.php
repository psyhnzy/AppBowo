<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title ?? 'Admin — BOWO'); ?></title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <style>
        @media print {
            aside, header, #sidebar-backdrop, .no-print { display: none !important; }
            body { background: white !important; }
            main { padding: 0 !important; width: 100% !important; }
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex flex-col md:flex-row antialiased">

    <!-- Mobile Topbar Header (Hanya di layar kecil) -->
    <header class="md:hidden bg-slate-900 text-white px-4 py-3.5 flex items-center justify-between sticky top-0 z-30 shadow-md no-print">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-2">
            <img src="<?php echo e(asset('assets/images/bowo.png')); ?>" alt="BOWO Logo" class="h-7 w-auto">
            <span class="text-xl font-black text-emerald-500">Admin</span>
        </a>
        <button type="button" onclick="toggleSidebar()" class="p-2 rounded-lg bg-slate-800 text-slate-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500" aria-label="Buka Menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </header>

    <!-- Backdrop Overlay untuk Mobile -->
    <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-40 hidden md:hidden transition-opacity"></div>

    <!-- Sidebar Admin (Drawer di mobile, static di desktop) -->
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-72 md:w-64 bg-slate-900 text-slate-200 flex flex-col p-6 space-y-6 no-print transform -translate-x-full md:translate-x-0 md:static md:inset-auto transition-transform duration-300 ease-in-out shrink-0 min-h-screen shadow-xl md:shadow-none">
        <div class="flex items-center justify-between">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-3">
                <img src="<?php echo e(asset('assets/images/bowo.png')); ?>" alt="BOWO Logo" class="h-9 w-auto">
                <span class="text-2xl font-black text-emerald-500">Admin</span>
            </a>
            <!-- Tombol Tutup Sidebar di Mobile -->
            <button type="button" onclick="toggleSidebar()" class="md:hidden p-1.5 text-slate-400 hover:text-white rounded-lg focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <nav class="flex-1 space-y-2 text-sm font-medium">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-3 py-2.5 px-4 rounded-xl transition <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white font-bold shadow-md shadow-emerald-900/50' : 'hover:bg-slate-800 text-slate-300'); ?>">
                <span>📋</span>
                <span>Verifikasi Setoran</span>
            </a>
            <a href="<?php echo e(route('admin.wastes')); ?>" class="flex items-center gap-3 py-2.5 px-4 rounded-xl transition <?php echo e(request()->routeIs('admin.wastes*') ? 'bg-emerald-600 text-white font-bold shadow-md shadow-emerald-900/50' : 'hover:bg-slate-800 text-slate-300'); ?>">
                <span>♻️</span>
                <span>Jenis & Harga Sampah</span>
            </a>
            <a href="<?php echo e(route('admin.reports')); ?>" class="flex items-center gap-3 py-2.5 px-4 rounded-xl transition <?php echo e(request()->routeIs('admin.reports') ? 'bg-emerald-600 text-white font-bold shadow-md shadow-emerald-900/50' : 'hover:bg-slate-800 text-slate-300'); ?>">
                <span>📊</span>
                <span>Laporan Sistem</span>
            </a>
            <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-3 py-2.5 px-4 text-red-400 hover:bg-slate-800 rounded-xl transition">
                <span>🚪</span>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="hidden">
                <?php echo csrf_field(); ?>
            </form>
        </nav>

        <div class="text-xs text-slate-500 pt-4 border-t border-slate-800">
            Masuk sebagai: <b class="text-slate-300 block truncate"><?php echo e(auth()->user()->name ?? 'Administrator'); ?></b>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 p-4 sm:p-6 lg:p-8 min-w-0 overflow-y-auto">
        <!-- Flash Messages -->
        <?php if(session('success')): ?>
            <div class="no-print bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-3 rounded-xl text-sm mb-6 flex items-center justify-between shadow-sm">
                <span><?php echo e(session('success')); ?></span>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-800 font-bold ml-2 text-lg leading-none">&times;</button>
            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="no-print bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-xl text-sm mb-6 flex items-center justify-between shadow-sm">
                <span><?php echo e(session('error')); ?></span>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-800 font-bold ml-2 text-lg leading-none">&times;</button>
            </div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="no-print bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-xl text-sm mb-6 shadow-sm">
                <ul class="list-disc pl-5 space-y-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($err); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Script Drawer Toggle -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const isHidden = sidebar.classList.contains('-translate-x-full');
            
            if (isHidden) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\BOWO_Laravel\resources\views/layouts/admin.blade.php ENDPATH**/ ?>