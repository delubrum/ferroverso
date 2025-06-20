<style>
.tabulator .tabulator-header .tabulator-col {
  background-color: black;
  color: white;
}
.tabulator .tabulator-header .tabulator-col input {
  color: black;
}

.flatpickr-input[readonly] {
    height: 24px;
}

.tabulator .tabulator-footer .tabulator-page.active {
  color: black;
}
</style>

<div class="flex justify-between items-center mx-4 mt-4">
    <!-- Botones a la izquierda -->
    <div class="flex space-x-2">
        <!-- Botón de vista Lista -->
        <a 
            class="flex items-center gap-2 bg-black text-white hover:opacity-80 transition-all duration-300 px-4 py-2 rounded-lg font-semibold text-sm shadow-md"
            href="?c=Quotes&a=Index&m=Cotizaciones"
        >
            <i class="ri-list-check"></i>
        </a>
    </div>

    <!-- Botón de Registrar a la derecha -->
    <button 
        class="flex items-center gap-2 bg-black text-white hover:opacity-80 transition-all duration-300 px-4 py-2 rounded-lg font-semibold text-sm shadow-md"
        hx-get='?c=<?= $_REQUEST['c'] ?>&a=New'
        hx-target="#myModal"
        hx-indicator="#loading"
        @click='showModal = true'
    >
        <i class="ri-add-line"></i> <?= $button ?>
    </button>
</div>

<div id="stats"
    hx-get="?c=Quotes&a=Stats"
    hx-trigger="load"
    hx-target="this">
>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 m-4">
<div>
    <h2 class="text-lg font-bold mb-2">Pendientes</h2>
    <div id="pendientes" class="bg-white p-2 rounded shadow min-h-[400px] text-xs"></div>
</div>
<div>
    <h2 class="text-lg font-bold mb-2">Aprobadas</h2>
    <div id="aprobadas" class="bg-white p-2 rounded shadow min-h-[400px] text-xs"></div>
</div>
<div>
    <h2 class="text-lg font-bold mb-2">Rechazadas</h2>
    <div id="rechazadas" class="bg-white p-2 rounded shadow min-h-[400px] text-xs"></div>
</div>
</div>

  <script>
    fetch("?c=Quotes&a=KanbanData")
      .then(res => res.json())
      .then(data => {
        const columns = [
          { title: "Proyecto", field: "project" },
          { title: "Responsable", field: "user_id" }
        ];

        new Tabulator("#pendientes", {
            data: data.filter(d => d.status === "Pendiente"),
            height: '200px',
            layout: "fitColumns",
            columns
        });

        new Tabulator("#aprobadas", {
            height: '200px',
            data: data.filter(d => d.status === "Aprobada"),
            layout: "fitColumns",
            columns
        });

        new Tabulator("#rechazadas", {
            height: '200px',
            data: data.filter(d => d.status === "Rechazada"),
            layout: "fitColumns",
            columns
        });
      });
  </script>