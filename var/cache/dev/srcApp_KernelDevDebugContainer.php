<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerXb67jym\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerXb67jym/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerXb67jym.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerXb67jym\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerXb67jym\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'Xb67jym',
    'container.build_id' => '04cd2db1',
    'container.build_time' => 1554380031,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerXb67jym');
