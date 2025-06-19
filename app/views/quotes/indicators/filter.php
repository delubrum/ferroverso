<form id="monthYearForm" method="post" autocomplete="off" action="?c=Quotes&a=Indicators&in=<?php echo $in ?>" class="flex justify-center">
    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 gap-6 items-center">
        <div class="flex flex-col items-center">
            <label for="selectYear" class="font-semibold text-gray-700 mb-2">Año:</label>
            <select name="year" id="selectYear" class="form-select form-select-sm p-2 border rounded-md" onchange="this.form.submit()">
                <?php
                    $currentYear = date('Y');
                $selectedYear = $_REQUEST['year'] ?? $currentYear;
                for ($y = $currentYear - 5; $y <= $currentYear + 1; $y++) {
                    $selected = ($y == $selectedYear) ? 'selected' : '';
                    echo "<option value='$y' $selected>$y</option>";
                }
                ?>
            </select>
        </div>
    </div>
</form>

<script>
    // Si decides re-incluir el selector de mes, puedes activar el envío al cambiarlo también:
    /*
    const selectMonth = document.getElementById('selectMonth');
    if (selectMonth) {
        selectMonth.addEventListener('change', function() {
            this.form.submit();
        });
    }
    */

    const selectYear = document.getElementById('selectYear');
    if (selectYear) {
        selectYear.addEventListener('change', function() {
            this.form.submit();
        });
    }
</script>