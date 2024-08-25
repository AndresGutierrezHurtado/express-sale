<div class="drawer lg:drawer-open">
    <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col items-center justify-center pr-5 py-5">
        <!-- Main -->
        <?php require_once($content); ?>        
    </div>
    <div class="h-[100dvh] overflow-visible w-full max-w-[70px] md:max-w-[280px]">
        <ul class="menu min-h-full w-full bg-white py-5 p-1 md:px-3 flex flex-col justify-between text-lg">
            <div>
                <a href="/" class="w-full tooltip tooltip-right" data-tip="Ir a inicio">
                    <figure class="w-full max-w-[150px] aspect-square mx-auto">
                        <img src="/public/images/logo.png" alt="Logo express sale"
                        class="object-contain h-full w-full">
                    </figure>
                </a>
            </div>
            <div class="flex-grow flex flex-col gap-2 items-center justify-center">
                <li class="w-full">
                    <a href="/" class="tooltip tooltip-right text-left flex gap-2 items-center justify-center md:justify-start" data-tip="Ir a inicio">
                        <i class="fa-solid fa-house"></i>
                        <p class="hidden md:block">Inicio</p>
                    </a>
                </li>
                <li class="w-full">
                    <a class="tooltip tooltip-right text-left flex gap-2 items-center justify-center md:justify-start <?= $current_page == "stats" ? "bg-gradient-to-r from-violet-600/80 from-10% to-white to-90% font-semibold" : "" ?>" data-tip="Ver estadísticas de la cuenta">
                        <i class="fa-solid fa-user-gear"></i>
                        <p class="hidden md:block">Panel de <?= $user['rol_nombre'] ?></p>
                    </a>
                </li>
                <?php if($user['rol_id'] == 2): ?>
                    <li class="w-full">
                        <a class="tooltip tooltip-right text-left flex gap-2 items-center justify-center md:justify-start" data-tip="Ver los productos del vendedor">
                            <i class="fa-solid fa-boxes-stacked"></i>
                            <p class="hidden md:block">Productos</p>
                        </a>
                    </li>
                <?php endif; ?>
            </div>
            <div>
                <li>
                    <a class="tooltip tooltip-right text-left flex gap-2 items-center justify-center md:justify-start" data-tip="Crear un nuevo producto">
                        <i class="fa-solid fa-arrow-up-from-bracket"></i>
                        <p class="hidden md:block">Subir producto</p>
                    </a>
                </li>
                <?php if($user['rol_id'] == 2): ?>
                    <li>
                        <a href="javascript:history.back()" class="flex ga-2 items-center justify-center md:justify-start">
                            <i class="fa-solid fa-arrow-left"></i>
                            <p class="hidden md:block">Volver</p>
                        </a>
                    </li>
                <?php endif; ?>
            </div>
        </ul>
    </div>
</div>
