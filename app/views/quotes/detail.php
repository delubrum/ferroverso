<div @click.outside="if (!nestedModal) showModal = !showModal" class="w-[95%] sm:w-[95%] rounded-lg shadow-lg relative z-50 bg-gray-50 text-gray-800 text-sm leading-relaxed" hx-boost="true">
    <!-- Close Button (X) in Top-Right Corner -->
    <button @click="showModal = !showModal" class="absolute top-0 right-0 m-3 text-gray-900 hover:text-gray-700">
        <i class="ri-close-line text-2xl"></i>
    </button>
<div class="" >
    <div class="p-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 pb-2 border-b border-gray-200">
            <h1 class="text-xl font-extrabold text-gray-800 mb-2 sm:mb-0">
                <?php echo "<b>ID:<b> " . $id->id . " | " . $id->client_id . " - " . $id->project ?>
            </h1>
            <div class="flex flex-wrap gap-3 mr-10 w-full sm:w-auto">
                <?php if ($id->status != 'Aprobada' or $id->status != 'Perdida'): ?>
                <button class="px-3 py-1.5 rounded-md text-sm font-medium cursor-pointer transition-all duration-200 ease-in-out flex items-center justify-center space-x-1.5 shadow-sm hover:shadow-md hover:-translate-y-0.5 bg-gray-800 text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-opacity-50"
                    hx-get="?c=Quotes&a=DetailModal&modal=edit&id=<?= $id->id ?>"
                    hx-target="#modal-content-wrapper"
                    hx-swap="innerHTML"
                    hx-indicator="#loading">
                    <i class="ri-edit-line text-xs"></i>
                    <span>Editar</span>
                </button>
                <button class="px-3 py-1.5 rounded-md text-sm font-medium cursor-pointer transition-all duration-200 ease-in-out flex items-center justify-center space-x-1.5 shadow-sm hover:shadow-md hover:-translate-y-0.5 bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                    hx-get="?c=Quotes&a=DetailModal&modal=dispose&id=<?= $id->id ?>"
                    hx-target="#modal-content-wrapper"
                    hx-swap="innerHTML">
                    <i class="ri-delete-bin-line text-xs"></i>
                    <span>Aprobar</span>
                </button>
                <?php endif; ?>
                <button class="px-3 py-1.5 rounded-md text-sm font-medium cursor-pointer transition-all duration-200 ease-in-out flex items-center justify-center space-x-1.5 shadow-sm hover:shadow-md hover:-translate-y-0.5 bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                    hx-get="?c=Quotes&a=DetailModal&modal=dispose&id=<?= $id->id ?>"
                    hx-target="#modal-content-wrapper"
                    hx-swap="innerHTML">
                    <i class="ri-delete-bin-line text-xs"></i>
                    <span>Modificar</span>
                </button>
            </div>
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
                            <div class="font-medium text-gray-900"><?= ucwords($id->client_id) ?></div>
                        </div>
                        <div class="flex text-xs mb-1">
                            <div class="w-24 text-gray-600">Obra:</div>
                            <div class="font-medium text-gray-900"><?= ucwords($id->project) ?></div>
                        </div>
                        <div class="flex text-xs mb-1">
                            <div class="w-24 text-gray-600">Creación:</div>
                            <div class="font-medium text-gray-900"><?= ucwords($id->created_at) ?></div>
                        </div>
                        <?php if ($id->status != 'Pendiente') { ?>
                        <div class="flex text-xs mb-1">
                            <div class="w-24 text-gray-600"><?= ucwords($id->status) ?>: </div>
                            <div class="font-medium text-gray-900"><?= ucwords($id->created_at) ?></div>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="mb-4 pb-2.5 border-b border-dashed border-gray-200 last:border-b-0 last:mb-0 last:pb-0">
                        <h3 class="text-sm font-semibold text-gray-700 flex items-center space-x-1.5 mb-2"><i class="ri-money-dollar-circle-line text-xl"></i> <span>Valor</span></h3>
                        
                        <div class="flex text-xs mb-1">
                            <div class="w-24 text-gray-600">Total: </div>
                            <div class="font-medium text-gray-900">$<?= number_format($id->aui + $id->amount,0) ?></div>
                        </div>

                        <div class="flex text-xs mb-1">
                            <div class="w-24 text-gray-600">AUI: </div>
                            <div class="font-medium text-gray-900">$<?= number_format($id->aui,0) ?></div>
                        </div>
                    </div>

                    <div class="mb-4 pb-2.5 border-b border-dashed border-gray-200 last:border-b-0 last:mb-0 last:pb-0">
                        <h3 class="text-sm font-semibold text-gray-700 flex items-center space-x-1.5 mb-2"><i class="ri-shield-user-line text-xl"></i> <span>Asesor</span></h3>
                        <div class="flex text-xs mb-1">
                            <div class="font-medium text-gray-900"><?= $id->user_id ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden lg:col-span-3">
                <div class="flex border-b border-gray-200 bg-white px-3 flex-wrap">

                    <div class="tab px-3 py-2.5 cursor-pointer font-medium text-gray-500 transition-colors duration-200 hover:text-gray-800 whitespace-nowrap"
                        hx-get="?c=Quotes&a=DetailTab&tab=materials&id=<?= $id->id ?>"
                        hx-target="#tabContentContainer">Materiales
                    </div>

                    <div class="tab px-3 py-2.5 cursor-pointer font-medium text-gray-500 transition-colors duration-200 hover:text-gray-800 whitespace-nowrap"
                        hx-get="?c=Quotes&a=DetailTab&tab=documents&id=<?= $id->id ?>"
                        hx-target="#tabContentContainer">Documentos
                    </div>

                    <div class="tab px-3 py-2.5 cursor-pointer font-medium text-gray-500 transition-colors duration-200 hover:text-gray-800 whitespace-nowrap"
                        hx-get="?c=Quotes&a=DetailTab&tab=comments&id=<?= $id->id ?>"
                        hx-target="#tabContentContainer">Comentarios
                    </div>
                </div>

                <div id="tabContentContainer" class="p-4"
                    hx-get="?c=Quotes&a=DetailTab&tab=materials&id=<?= $id->id ?>"
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

        document.addEventListener("DOMContentLoaded", function () {
            const tabs = document.querySelectorAll(".tab");
            const tabContentContainer = document.getElementById("tabContentContainer");

            // Leer el último tab de localStorage
            const lastTab = localStorage.getItem("lastSelectedTab");

            // Activar el tab guardado o el primero por defecto
            let tabToActivate = tabs[0]; // por defecto
            if (lastTab) {
                const savedTab = Array.from(tabs).find(t => t.dataset.tab === lastTab);
                if (savedTab) tabToActivate = savedTab;
            }

            // Simula el clic inicial para cargar el contenido
            if (tabToActivate) tabToActivate.click();

            // Guardar el tab cuando se hace clic
            tabs.forEach(tab => {
                tab.addEventListener("click", function () {
                    const selectedTab = tab.dataset.tab;
                    if (selectedTab) {
                        localStorage.setItem("lastSelectedTab", selectedTab);
                    }
                });
            });
        });
        </script>

</body>
</html>