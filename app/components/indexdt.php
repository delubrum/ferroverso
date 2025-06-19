
    <?php if(isset($new)) { ?>

    <div class="flex justify-end mt-4">
        <button 
            class="items-center gap-2 bg-black text-white hover:opacity-80 transition-all duration-300 mr-4 px-4 py-2 rounded-xl font-semibold text-sm shadow-md flex"
            hx-get='<?php echo $new ?>'
            hx-target="#myModal"
            hx-indicator="#loading"
            @click='showModal = true'
        >
            <i class="ri-add-line"></i> Crear
        </button>
    </div>

    <?php } ?>

<div class="mx-2 sm:mx-6 mt-2 sm:mt-6 px-2 sm:px- py-2 sm:py-4 bg-white rounded-lg shadow-xl">

    <div class="overflow-x-auto w-full">
    <table class="w-full display table-striped text-xs sm:text-sm" id="list">
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