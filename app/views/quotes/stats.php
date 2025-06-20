<div class="pt-4">
  <div class="w-full px-4">
    <div class="grid grid-cols-1 sm:grid-cols-6 gap-6">

      <!-- Total Assets -->
      <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between">
        <div>
          <div class="text-xl font-bold text-gray-900"><?= $total ?></div>
          <div class="text-sm text-gray-500">Total Cotizaciones</div>
        </div>
        <div class="text-black-500 text-3xl">
          <i class="ri-database-2-line"></i>
        </div>
      </div>

      <!-- Active Assets -->
      <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between">
        <div>
          <div class="text-xl font-bold text-gray-900"><?= $projects ?></div>
          <div class="text-sm text-gray-500">Total Obras</div>
        </div>
        <div class="text-black-500 text-3xl">
          <i class="ri-shapes-line"></i>
        </div>
      </div>

      <!-- Total Value -->
      <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between">
        <div>
          <div class="text-xl font-bold text-gray-900">$<?= $amount ?> K</div>
          <div class="text-sm text-gray-500">Valor Total</div>
        </div>
        <div class="text-black-500 text-3xl">
          <i class="ri-money-dollar-circle-line"></i>
        </div>
      </div>

      <!-- Total Value -->
      <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between">
        <div>
          <div class="text-xl font-bold text-gray-900"><?= $pendientes ?></div>
          <div class="text-sm text-gray-500">Pendientes</div>
        </div>
        <div class="text-black-500 text-3xl">
          <i class="ri-donut-chart-line"></i>
        </div>
      </div>

      <!-- Expiring Soon -->
      <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between">
        <div>
          <div class="text-xl font-bold text-gray-900"><?= $aprobadas ?></div>
          <div class="text-sm text-gray-500">Aprobadas</div>
        </div>
        <div class="text-black-500 text-3xl">
          <i class="ri-checkbox-circle-line"></i>
        </div>
      </div>

      <!-- Avg Age -->
      <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between">
        <div>
          <div class="text-xl font-bold text-gray-900"><?= $rechazadas ?></div>
          <div class="text-sm text-gray-500">Rechazadas</div>
        </div>
        <div class="text-black-500 text-3xl">
          <i class="ri-close-circle-line"></i>
        </div>
      </div>

    </div>
  </div>
</div>