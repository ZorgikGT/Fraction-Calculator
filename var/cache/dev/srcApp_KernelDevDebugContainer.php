<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerY2viRYD\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerY2viRYD/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerY2viRYD.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerY2viRYD\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerY2viRYD\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'Y2viRYD',
    'container.build_id' => '1cfcf3bd',
    'container.build_time' => 1554218039,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerY2viRYD');
