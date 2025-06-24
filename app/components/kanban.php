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
    hx-get="?c=Quotes&a=StatsKanban"
    hx-trigger="load"
    hx-target="this">
>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 m-4">
<div>
    <h2 class="text-lg font-bold mb-2">Costeo</h2>
    <div id="costeo" class="bg-white p-2 rounded shadow min-h-[400px] text-xs"></div>
</div>
<div>
    <h2 class="text-lg font-bold mb-2">Seguimiento</h2>
    <div id="seguimiento" class="bg-white p-2 rounded shadow min-h-[400px] text-xs"></div>
</div>
<div>
    <h2 class="text-lg font-bold mb-2">Ganadas</h2>
    <div id="ganadas" class="bg-white p-2 rounded shadow min-h-[400px] text-xs"></div>
</div>
<div>
    <h2 class="text-lg font-bold mb-2">Perdidas</h2>
    <div id="perdidas" class="bg-white p-2 rounded shadow min-h-[400px] text-xs"></div>
</div>
</div>

<script>
  fetch("?c=Quotes&a=KanbanData")
    .then(res => res.json())
    .then(data => {
      const columns = [
        { title: "Proyecto", field: "project", headerFilter: "input" },
        { title: "Responsable", field: "user_id", headerFilter: "input" }
      ];

      new Tabulator("#costeo", {
          data: data.filter(d => d.status === "costeo"),
          height: '200px',
          layout: "fitColumns",
          columns
      });

      new Tabulator("#seguimiento", {
          height: '200px',
          data: data.filter(d => d.status === "seguimiento"),
          layout: "fitColumns",
          columns
      });

      new Tabulator("#ganadas", {
          height: '200px',
          data: data.filter(d => d.status === "ganada"),
          layout: "fitColumns",
          columns
      });

      new Tabulator("#perdidas", {
          height: '200px',
          data: data.filter(d => d.status === "perdida"),
          layout: "fitColumns",
          columns
      });
    });
</script>
