<?php if (isset($component)) { $__componentOriginalb525200bfa976483b4eaa0b7685c6e24 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-widgets::components.widget','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-widgets::widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <div style="height:450px;overflow:hidden;background:#111827;position:relative;border-radius:0.75rem;"
         x-data="{ active: 0, init() { setInterval(() => { this.active = (this.active + 1) % 4; }, 4000); } }">

        <?php
        $slides = [
            ['img' => 'jujur.jpeg',  'text' => 'SANTUN'],
            ['img' => 'santun.jpeg', 'text' => 'JUJUR'],
            ['img' => 'taat.jpeg',   'text' => 'TAAT'],
            ['img' => 'sajuta.jpeg', 'text' => 'SAJUTA'],
        ];
        ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
        <div style="position:absolute;inset:0;background:#111827;"
             :class="active === <?php echo e($i); ?> ? 'slide-in' : 'slide-out'">
            <img src="<?php echo e(asset('img/' . $slide['img'])); ?>" alt="<?php echo e($slide['text']); ?>"
                 style="width:100%;height:100%;object-fit:cover;display:block;">
            <div style="position:absolute;inset:0;background:rgba(0,0,0,0.3);"></div>
            <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                <h2 style="color:white;font-size:clamp(2.5rem,8vw,5rem);font-weight:900;text-transform:uppercase;letter-spacing:0.2em;text-shadow:3px 5px 20px rgba(0,0,0,1);"><?php echo e($slide['text']); ?></h2>
            </div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

        <!-- Indicators -->
        <div style="position:absolute;bottom:1rem;left:0;right:0;display:flex;justify-content:center;gap:0.75rem;z-index:10;">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <button @click="active = <?php echo e($i); ?>"
                style="width:0.75rem;height:0.75rem;border-radius:50%;border:none;cursor:pointer;transition:all 0.3s;"
                :style="active === <?php echo e($i); ?> ? 'background:#f59e0b;transform:scale(1.25);' : 'background:rgba(255,255,255,0.5);'">
            </button>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>

    <style>
        .slide-in {
            opacity: 1;
            z-index: 2;
            transition: opacity 0.8s ease;
        }
        .slide-out {
            opacity: 0;
            z-index: 1;
            transition: opacity 0.8s ease;
        }
    </style>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $attributes = $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $component = $__componentOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php /**PATH D:\Projek-pkl\WebsideKesiswaanSurya\WebsideKesiswaanSurya\resources\views/filament/widgets/header-widget.blade.php ENDPATH**/ ?>