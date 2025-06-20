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
        <!-- Botón de vista Kanban -->
        <a 
            class="flex items-center gap-2 bg-black text-white hover:opacity-80 transition-all duration-300 px-4 py-2 rounded-lg font-semibold text-sm shadow-md"
            href="?c=Quotes&a=Kanban&m=Cotizaciones"
        >
            <i class="ri-layout-masonry-line"></i>
        </a>

        <!-- Botón de exportar Excel -->
        <button 
            class="flex items-center gap-2 bg-black text-white hover:opacity-80 transition-all duration-300 px-4 py-2 rounded-lg font-semibold text-sm shadow-md"
            id="download-csv"
        >
            <i class="ri-file-excel-2-line"></i>
        </button>
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

<div id="stats"></div>

<div class="m-4 p-6 bg-white rounded-lg shadow-xl border-hidden text-xs" id="list"></div>

<script>
var table = new Tabulator("#list", {
    pagination:true, //enable pagination
    paginationMode:"remote",
    paginationSize:15,
    paginationSizeSelector:[10, 15, 20, 50, 100, 1000],
    paginationCounter:"rows",
    movableColumns:true,
    filterMode:"remote",
    sortMode:"remote",
    layout:"fitDataStretch",
    ajaxURL: "?c=<?= $_REQUEST['c'] ?>&a=Data",
    placeholder:"No Data Set",
    columns: <?= $columns ?>,
});

table.on("dataFiltered", function(filters, rows){
    // Enviar filtros con HTMX
    let params = new URLSearchParams();

    filters.forEach(filter => {
        params.append(`filter[${filter.field}]`, filter.value);
    });

    // Actualiza la sección de fichas
    htmx.ajax('GET', `?c=<?= $_REQUEST['c'] ?>&a=Stats&${params.toString()}`, {
        target: "#stats",
        swap: "innerHTML"
    });
});

table.on("rowClick", function(e, row){
    let id = row.getData().id;

    // Simula el comportamiento del botón
    htmx.ajax('GET', `?c=<?= $_REQUEST['c'] ?>&a=Detail&id=${id}`, {
    target: '#myModal',
    swap: 'innerHTML',
    headers: { 'HX-Request': 'true' } // opcional, por si usas detección server-side
    });

    let component = document.getElementById('myModal');

    Alpine.evaluate(component, 'showModal = true');
});


document.getElementById("download-csv").addEventListener("click", function(){
    let lastColumn = table.getColumns().slice(-1)[0];
    lastColumn.hide(); // ocultar última columna

    table.download("csv", "data.csv");

    lastColumn.show(); // volver a mostrarla
});

function customDateRangeFilter(cell, onRendered, success, cancel, editorParams) {
  const container = document.createElement("input");
  container.setAttribute("type", "text");

  flatpickr(container, {
    mode: "range",
    dateFormat: "Y-m-d",
    locale: "es",
    onClose: function(selectedDates, dateStr) {
      success(dateStr); // Envía el valor al backend
    }
  });

  return container;
}

function customDateFilterFunc(headerValue, rowValue, rowData, filterParams) {
  return true; // El filtrado real lo hará el servidor
}
</script>