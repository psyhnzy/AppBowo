<?php $__env->startSection('body'); ?>
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-6 sm:p-8 border border-emerald-100 my-6 sm:my-8">
        <div class="text-center mb-6">
            <a href="<?php echo e(route('home')); ?>" class="inline-block">
                <img src="<?php echo e(asset('assets/images/bowo.png')); ?>" alt="BOWO Logo" class="h-12 sm:h-14 w-auto mx-auto mb-2 object-contain">
                <h1 class="text-xl sm:text-2xl font-extrabold text-emerald-600">Daftar Nasabah BOWO</h1>
            </a>
            <p class="text-slate-500 text-xs mt-1">Bergabunglah menjaga lingkungan bersama kami</p>
        </div>

        <?php if(session('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2.5 rounded-xl mb-4 text-xs sm:text-sm">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2.5 rounded-xl mb-4 text-xs sm:text-sm">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>
        <?php if(session('success')): ?>
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-2.5 rounded-xl mb-4 text-xs sm:text-sm">
                <?php echo e(session('success')); ?> <a href="<?php echo e(route('login')); ?>" class="underline font-bold">Login di sini</a>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('register.process')); ?>" class="space-y-3.5 text-xs sm:text-sm">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block font-medium text-slate-700">Nama Lengkap</label>
                <input type="text" name="name" value="<?php echo e(old('name')); ?>" required placeholder="Nama lengkap Anda" class="mt-1 w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 text-sm">
            </div>
            <div>
                <label class="block font-medium text-slate-700">Username</label>
                <input type="text" name="username" value="<?php echo e(old('username')); ?>" required placeholder="Username unik" class="mt-1 w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 text-sm">
            </div>
            <div>
                <label class="block font-medium text-slate-700">Email</label>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" required placeholder="email@contoh.com" class="mt-1 w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 text-sm">
            </div>
            <div>
                <label class="block font-medium text-slate-700">Nomor Telepon / WA</label>
                <input type="text" name="phone" value="<?php echo e(old('phone')); ?>" required placeholder="08xxxxxxxxxx" class="mt-1 w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 text-sm">
            </div>
            <div>
                <label class="block font-medium text-slate-700">Alamat Lengkap</label>
                <textarea name="address" required rows="2" placeholder="Alamat domisili lengkap" class="mt-1 w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 text-sm"><?php echo e(old('address')); ?></textarea>
            </div>
            <div>
                <label class="block font-medium text-slate-700">Password</label>
                <input type="password" name="password" required placeholder="Minimal 6 karakter" class="mt-1 w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 text-sm">
            </div>
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 sm:py-3 rounded-xl transition mt-2 shadow-sm text-sm">
                Daftar Akun
            </button>
        </form>

        <p class="mt-4 text-center text-xs text-slate-600">
            Sudah punya akun? <a href="<?php echo e(route('login')); ?>" class="text-emerald-600 font-bold hover:underline">Login Sekarang</a>
        </p>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['title' => 'Daftar Akun — BOWO', 'bodyClass' => 'bg-emerald-50 min-h-screen flex items-center justify-center p-4 sm:p-6'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\BOWO_Laravel\resources\views/auth/register.blade.php ENDPATH**/ ?>