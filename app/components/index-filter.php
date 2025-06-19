
    <?php if(isset($new)) { ?>

    <div class="flex justify-end mt-4">
        <button 
            class="items-center gap-2 bg-black text-white hover:opacity-80 transition-all duration-300 mr-4 px-4 py-2 rounded-xl font-semibold text-sm shadow-md flex"
            hx-get='<?php echo $new ?>'
            hx-target="#myModal"
            hx-indicator="#loading"
            @click='showModal = true'
        >
            <i class="ri-add-line"></i> Registrar
        </button>
    </div>

    <?php } ?>

<div class="pt-4">
  <div class="w-full px-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">

      <!-- Total Assets -->
      <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between">
        <div>
          <div class="text-2xl font-bold text-gray-900" id="totalAssets">0</div>
          <div class="text-sm text-gray-500">Total Assets</div>
        </div>
        <div class="text-black-500 text-3xl">
          <i class="ri-database-2-line"></i>
        </div>
      </div>

      <!-- Active Assets -->
      <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between">
        <div>
          <div class="text-2xl font-bold text-gray-900" id="activeAssets">0</div>
          <div class="text-sm text-gray-500">Active Assets</div>
        </div>
        <div class="text-black-500 text-3xl">
          <i class="ri-checkbox-circle-line"></i>
        </div>
      </div>

      <!-- Total Value -->
      <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between">
        <div>
          <div class="text-2xl font-bold text-gray-900" id="totalValue">$0</div>
          <div class="text-sm text-gray-500">Total Value</div>
        </div>
        <div class="text-black-500 text-3xl">
          <i class="ri-money-dollar-circle-line"></i>
        </div>
      </div>

      <!-- Expiring Soon -->
      <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between">
        <div>
          <div class="text-2xl font-bold text-gray-900" id="expiringSoon">0</div>
          <div class="text-sm text-gray-500">Expiring Soon</div>
        </div>
        <div class="text-black-500 text-3xl">
          <i class="ri-alert-line"></i>
        </div>
      </div>

      <!-- Avg Age -->
      <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between">
        <div>
          <div class="text-2xl font-bold text-gray-900" id="avgAge">0</div>
          <div class="text-sm text-gray-500">Avg Age (years)</div>
        </div>
        <div class="text-black-500 text-3xl">
          <i class="ri-calendar-line"></i>
        </div>
      </div>

    </div>
  </div>
</div>

<div class="mx-2 sm:mx-6 mt-2 sm:mt-6 px-2 sm:px- py-2 sm:py-4 bg-white rounded-lg shadow-xl">



    <div class="overflow-x-auto w-full px-4">
    <table class="w-full display table-striped sm:text-sm" id="list">
        <thead>
            <tr>
                <?php foreach($fields as $f) { ?>
                <th <?php echo ($f == 'action') ? "style='text-align:right'" : "" ?>> <?php echo  ucwords(preg_replace('/(?<=\w)([A-Z])/', ' $1', $f)); ?> </th>
                <?php } ?>
            </tr>
        </thead>
    </table> 
    </div>

</div>

<script>
var table = $('#list').DataTable({
    layout: {
        topStart: {
            buttons: ['copy', 'excel', 'pdf', 'print']
        }
    },
    order: [0,'asc'],
    lengthChange : true,
    <?php if(isset($paginate)) { ?>
    paginate: true,
    pageLength: 20,
    <?php } else { ?>
    paginate: false,
    <?php } ?>
    scrollX : true,
    autoWidth : false,
    <?php if(isset($serverside)) { ?>
    serverSide : true,
    processing: true,
    <?php } ?>
    ajax: {
        url: "<?php echo $url ?>",
        type: "POST",
        dataSrc: function (json) {
            // Check if the data array is not empty or null
            if (json != '') {
                return json;
            } else {
                return []; // Return an empty array to prevent rendering
            }
        },
    },
    columns : [
        <?php foreach($fields as $f) {
        echo "{data: '$f'},";
        } ?>
    ],
    columnDefs : [
        { "width": "100px", "targets": [<?php echo count($fields)-1 ?>] },
        { "className": "text-right", "targets": [<?php echo count($fields)-1 ?>] },

    ],
    <?php if(isset($_REQUEST['id'])) { ?>
    search: {
        "search": '<?php echo $_REQUEST['id'] ?>'
    },
    <?php } ?>
    drawCallback: function(settings) {
        htmx.process(document.getElementById('list'));
    }
});

$(table.table().container()).on('keyup', 'tfoot input', function () {
    table
        .column($(this).data('index'))
        .search(this.value)
        .draw();
});
</script>