<div class="w-[95%] sm:w-[95%] rounded-lg shadow-lg relative z-50 bg-gray-50 text-gray-800 text-sm leading-relaxed" hx-boost="true">
    <!-- Close Button (X) in Top-Right Corner -->
    <button @click="showModal = !showModal" class="absolute top-0 right-0 m-3 text-gray-900 hover:text-gray-700">
        <i class="ri-close-line text-2xl"></i>
    </button>
<div class="" >
    <div class="p-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 pb-2 border-b border-gray-200">
            <h1 class="text-xl font-extrabold text-gray-800 mb-2 sm:mb-0">
                <?php echo "<b>ID:<b> " . $id->code . " | " . $id->company . " - " . $id->project ?>
            </h1>


            <?php if ($id->status != 'ganada' && $id->status != 'perdida' && $id->status != 'modificada'): ?>
            <div x-data="{ open: false }" class="relative mr-10">
            <button @click="open = !open"
                class="text-sm px-4 py-2 bg-gray-800 text-white rounded-md shadow hover:bg-gray-700 focus:outline-none">
                <i class="ri-menu-line"></i> Opciones
            </button>

            <div x-show="open" @click.outside="open = false"
                class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-md shadow-lg z-50">
                <ul class="py-1 text-sm text-gray-700">
                    <?php if ($id->status != 'ganada' && $id->status != 'perdida' && $id->status != 'modificada'): ?>
                    <!-- <li>
                        <a href="#"
                            hx-get="?c=Quotes&a=New&id=<?= $id->id ?>"
                            hx-target="#myModal"
                            hx-indicator="#loading"
                            @click="showModal = true; open = false"
                            class="block px-4 py-2 hover:bg-gray-100 flex items-center gap-2">
                            <i class="ri-edit-line"></i> Editar
                        </a>
                    </li> -->
                    <?php endif; ?>
                    <?php if ($id->status === 'costeo'): ?>
                    <li>
                        <a href="#"
                            hx-get="?c=Quotes&a=New&status=seguimiento&id=<?= $id->id ?>"
                            hx-target="#myModal"
                            hx-indicator="#loading"
                            @click="showModal = true; open = false"
                            class="block px-4 py-2 hover:bg-gray-100 flex items-center gap-2">
                            <i class="ri-edit-line"></i> Costear
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if ($id->status === 'seguimiento'): ?>
                    <li>
                        <a href="#"
                            hx-get="?c=Quotes&a=New&status=modificada&id=<?= $id->id ?>"
                            hx-target="#myModal"
                            hx-indicator="#loading"
                            @click="showModal = true; open = false"
                            class="block px-4 py-2 hover:bg-gray-100 flex items-center gap-2">
                            <i class="ri-arrow-left-right-line"></i> Modificar
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            hx-get="?c=Quotes&a=New&status=ganada&id=<?= $id->id ?>"
                            hx-target="#myModal"
                            hx-indicator="#loading"
                            @click="showModal = true; open = false"
                            class="block px-4 py-2 hover:bg-gray-100 flex items-center gap-2">
                            <i class="ri-check-double-line"></i> Ganada
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            hx-get="?c=Quotes&a=New&status=perdida&id=<?= $id->id ?>"
                            hx-target="#myModal"
                            hx-indicator="#loading"
                            @click="showModal = true; open = false"
                            class="block px-4 py-2 hover:bg-gray-100 flex items-center gap-2">
                            <i class="ri-close-line"></i> Perdida
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            </div>
            <?php endif; ?>
        </div>      

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow-md overflow-hidden lg:col-span-1">
                <div class="w-full h-40 bg-gray-100 flex items-center justify-center border-b border-gray-200">
                    <img class="ml-4" src='app/assets/img/intro.png' width='80' height='80'>
                </div>
                <div class="p-4">
                    <div class="flex justify-center mb-4">
                        <div class="inline-block px-4 py-1.5 rounded-full text-sm font-bold shadow-md border-2">
                            <?php echo ucwords($id->status) ?>
                        </div>
                    </div>
                    <div class="mb-4 pb-2.5 border-b border-dashed border-gray-200 last:border-b-0 last:mb-0 last:pb-0">
                        <h3 class="text-sm font-semibold text-gray-700 flex items-center space-x-1.5 mb-2"><i class="ri-information-line text-xl"></i> <span>Información Básica</span></h3>
                        <div class="flex text-xs mb-1">
                            <div class="w-24 text-gray-600">Cliente:</div>
                            <div class="font-medium text-gray-900"><?= ucwords($id->company) ?></div>
                        </div>
                        <div class="flex text-xs mb-1">
                            <div class="w-24 text-gray-600">Obra:</div>
                            <div class="font-medium text-gray-900"><?= ucwords($id->project) ?></div>
                        </div>
                    </div>

                    <div class="mb-4 pb-2.5 border-b border-dashed border-gray-200 last:border-b-0 last:mb-0 last:pb-0">
                        <h3 class="text-sm font-semibold text-gray-700 flex items-center space-x-1.5 mb-2"><i class="ri-money-dollar-circle-line text-xl"></i> <span>Valor</span></h3>
                        
                        <div class="flex text-xs mb-1">
                            <div class="w-24 text-gray-600">Total: </div>
                            <div class="font-medium text-gray-900">$<?= number_format($id->aui + $id->amount,0) ?></div>
                        </div>

                        <div class="flex text-xs mb-1">
                            <div class="w-24 text-gray-600">AIU: </div>
                            <div class="font-medium text-gray-900">$<?= number_format($id->aui,0) ?></div>
                        </div>
                    </div>

                    <div class="mb-4 pb-2.5 border-b border-dashed border-gray-200 last:border-b-0 last:mb-0 last:pb-0">
                        <h3 class="text-sm font-semibold text-gray-700 flex items-center space-x-1.5 mb-2"><i class="ri-shield-user-line text-xl"></i> <span>Asesor</span></h3>
                        <div class="flex text-xs mb-1">
                            <div class="font-medium text-gray-900"><?= $id->username ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden lg:col-span-3">
<div class="w-full max-w-2xl mx-auto my-4">
    <div class="relative flex justify-between items-center text-xs bg-white p-2">
        <!-- Línea horizontal de fondo -->

        <!-- Paso 1 -->
        <div class="flex items-center gap-2 bg-white px-2 z-10 w-1/3">
            <div class="w-10 h-10 flex items-center justify-center bg-purple-600 rounded-full shadow-md border-2 border-white hover:scale-105 transition-transform">
                <i class="ri-file-search-line text-white text-lg"></i>
            </div>
            <div class="leading-snug">
                <p class="font-semibold text-gray-800 text-sm">Costeo</p>
                <p class="text-gray-500 text-xs"><?= date("Y-m-d", strtotime($id->created_at)) ?></p>
            </div>
        </div>

        <?php if ($id->status != 'costeo') : ?>
        <!-- Paso 2 -->
        <div class="flex items-center gap-2 bg-white px-2 z-10 w-1/3">
            <div class="w-10 h-10 flex items-center justify-center bg-pink-600 rounded-full shadow-md border-2 border-white hover:scale-105 transition-transform">
                <i class="ri-road-map-line text-white text-lg"></i>
            </div>
            <div class="leading-snug">
                <p class="font-semibold text-gray-800 text-sm">Seguimiento</p>
                <p class="text-gray-500 text-xs"><?= date("Y-m-d", strtotime($id->quote_at)) ?></p>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($id->status != 'costeo' && $id->status != 'seguimiento') : ?>
        <!-- Paso 3 -->
        <div class="flex items-center gap-2 bg-white px-2 z-10 w-1/3">
            <div class="w-10 h-10 flex items-center justify-center bg-<?= ($id->status == 'ganada') ? 'green' : 'red' ?>-600 rounded-full shadow-md border-2 border-white hover:scale-105 transition-transform">
                <i class="<?= ($id->status == 'ganada') ? 'ri-checkbox-circle-line' : 'ri-close-circle-line' ?> text-white text-lg"></i>
            </div>
            <div class="leading-snug">
                <p class="font-semibold text-gray-800 text-sm"><?= ucwords($id->status) ?></p>
                <p class="text-gray-500 text-xs"><?= date("Y-m-d", strtotime($id->status_at)) ?></p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>


            
                <div class="flex border-b border-gray-200 bg-white px-3 flex-wrap">

                    <div class="tab active text-gray-800 border-gray-800 border-b-2 px-3 py-2.5 cursor-pointer font-medium text-gray-500 transition-colors duration-200 hover:text-gray-800 whitespace-nowrap"
                        hx-get="?c=Quotes&a=DetailTab&tab=comments&id=<?= $id->id ?>"
                        hx-target="#tabContentContainer">Comentarios
                    </div>

                    <!-- <div class="tab px-3 py-2.5 cursor-pointer font-medium text-gray-500 transition-colors duration-200 hover:text-gray-800 whitespace-nowrap"
                        hx-get="?c=Quotes&a=DetailTab&tab=materials&id=<?= $id->id ?>"
                        hx-target="#tabContentContainer">Materiales
                    </div>

                    <div class="tab px-3 py-2.5 cursor-pointer font-medium text-gray-500 transition-colors duration-200 hover:text-gray-800 whitespace-nowrap"
                        hx-get="?c=Quotes&a=DetailTab&tab=documents&id=<?= $id->id ?>"
                        hx-target="#tabContentContainer">Documentos
                    </div> -->
                </div>

                <div id="tabContentContainer" class="p-4"
                    hx-get="?c=Quotes&a=DetailTab&tab=comments&id=<?= $id->id ?>"
                    hx-trigger="load"
                    hx-target="this">
                </div>
            </div>
        </div>
    </div>

    <script>
        // Script para manejar las pestañas
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                // Elimina las clases de "activo" de todas las pestañas
                document.querySelectorAll('.tab').forEach(t => {
                    t.classList.remove('active');
                    t.classList.remove('text-gray-800');
                    t.classList.remove('border-gray-800');
                    t.classList.remove('border-b-2'); // Asegúrate de remover el borde también
                });
                // Añade las clases de "activo" a la pestaña
                tab.classList.add('active');
                tab.classList.add('text-gray-800');
                tab.classList.add('border-gray-800');
                tab.classList.add('border-b-2'); // Añade el borde inferior a la pestaña activa
            });
        });

        // Inicializa la primera pestaña como activa al cargar la página
        document.addEventListener('DOMContentLoaded', () => {
            const firstTab = document.querySelector('.tab');
            if (firstTab) {
                firstTab.classList.add('active');
                firstTab.classList.add('text-gray-800');
                firstTab.classList.add('border-gray-800');
                firstTab.classList.add('border-b-2');
            }
        });
        </script>

</body>
</html>