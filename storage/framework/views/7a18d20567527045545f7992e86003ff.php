<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title ?? 'BOWO — Bank of Waste Online'); ?></title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- Custom CSS (Font & Scrollbar) -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="<?php echo e($bodyClass ?? 'bg-slate-50 text-slate-800'); ?>">
    <?php echo $__env->yieldContent('body'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\BOWO_Laravel\resources\views/layouts/app.blade.php ENDPATH**/ ?>