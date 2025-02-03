<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Beacon')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

        <!-- Styles -->
        <?php echo \Livewire\Livewire::styles(); ?>

    </head>
    <body class="font-sans antialiased">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.banner','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('banner'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <div class="min-h-screen bg-gray-100">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('navigation-menu')->html();
<<<<<<< HEAD
} elseif ($_instance->childHasBeenRendered('YBFDseD')) {
    $componentId = $_instance->getRenderedChildComponentId('YBFDseD');
    $componentTag = $_instance->getRenderedChildComponentTagName('YBFDseD');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('YBFDseD');
} else {
    $response = \Livewire\Livewire::mount('navigation-menu');
    $html = $response->html();
    $_instance->logRenderedChild('YBFDseD', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
=======
<<<<<<<< HEAD:storage/framework/views/2ee6ffbf795f85efb7b3075853b50d526c9c0717.php
} elseif ($_instance->childHasBeenRendered('69yHM9m')) {
    $componentId = $_instance->getRenderedChildComponentId('69yHM9m');
    $componentTag = $_instance->getRenderedChildComponentTagName('69yHM9m');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('69yHM9m');
} else {
    $response = \Livewire\Livewire::mount('navigation-menu');
    $html = $response->html();
    $_instance->logRenderedChild('69yHM9m', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
========
} elseif ($_instance->childHasBeenRendered('wCqcyJ4')) {
    $componentId = $_instance->getRenderedChildComponentId('wCqcyJ4');
    $componentTag = $_instance->getRenderedChildComponentTagName('wCqcyJ4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('wCqcyJ4');
} else {
    $response = \Livewire\Livewire::mount('navigation-menu');
    $html = $response->html();
    $_instance->logRenderedChild('wCqcyJ4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
>>>>>>>> 9f59704b61ecc3c1d2b0d4bfb22dc084059bdbef:storage/framework/views/5e688875402e181031ab5af7f0bff1d6a55aa19c.php
>>>>>>> 9f59704b61ecc3c1d2b0d4bfb22dc084059bdbef
}
echo $html;
?>

            <!-- Page Heading -->
            <?php if(isset($header)): ?>
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <?php echo e($header); ?>

                    </div>
                </header>
            <?php endif; ?>

            <!-- Page Content -->
            <main>
                <?php echo e($slot); ?>

            </main>
        </div>

        <?php echo $__env->yieldPushContent('modals'); ?>

        <?php echo \Livewire\Livewire::scripts(); ?>

    </body>
</html>
<?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\resources\views/layouts/app.blade.php ENDPATH**/ ?>