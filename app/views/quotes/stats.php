<div class="pt-4">
  <div class="w-full px-4">
    <div class="grid grid-cols-1 sm:grid-cols-6 gap-3">

      <!-- Total Assets -->
      <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between border-l-4 border-gray-700">
        <div>
          <div class="text-xl font-bold text-gray-900"><?= $total ?></div>
          <div class="text-sm text-gray-500">Cotizaciones</div>
        </div>
        <div class="text-black-500 bg-gray-100 rounded-full py-2 px-3 text-xl">
          <i class="ri-database-2-line"></i>
        </div>
      </div>

      <!-- Active Assets -->
      <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between border-l-4 border-gray-700">
        <div>
          <div class="text-xl font-bold text-gray-900"><?= $projects ?></div>
          <div class="text-sm text-gray-500">Obras</div>
        </div>
        <div class="text-black-500 bg-gray-100 rounded-full py-2 px-3 text-xl">
          <i class="ri-shapes-line"></i>
        </div>
      </div>

      <!-- Total Value -->
      <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between border-l-4 border-gray-700">
        <div>
          <div class="text-xl font-bold text-gray-900">$<?= $amount ?></div>
          <div class="text-sm text-gray-500">Valor (K)</div>
        </div>
        <div class="text-black-500 bg-gray-100 rounded-full py-2 px-3 text-xl">
          <i class="ri-money-dollar-circle-line"></i>
        </div>
      </div>

      <!-- Total Value -->
      <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between border-l-4 border-gray-700">
        <div>
          <div class="text-xl font-bold text-gray-900"><?= $costeo ?></div>
          <div class="text-sm text-gray-500">Costeo</div>
        </div>
        <div class="text-black-500 bg-gray-100 rounded-full py-2 px-3 text-xl">
          <i class="ri-price-tag-3-line"></i>
        </div>
      </div>

      <!-- Expiring Soon -->
      <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between border-l-4 border-gray-700">
        <div>
          <div class="text-xl font-bold text-gray-900"><?= $seguimiento ?></div>
          <div class="text-sm text-gray-500">Seguimiento</div>
        </div>
        <div class="text-black-500 bg-gray-100 rounded-full py-2 px-3 text-xl">
          <i class="ri-arrow-up-down-line"></i>
        </div>
      </div>

      <!-- Avg Age -->
      <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between border-l-4 border-gray-700">
        <div>
          <div class="text-xl font-bold text-gray-900"><?= $ganadas ?></div>
          <div class="text-sm text-gray-500">Ganadas</div>
        </div>
        <div class="text-black-500 bg-gray-100 rounded-full py-2 px-3 text-xl">
          <i class="ri-checkbox-circle-line"></i>
        </div>
      </div>

    </div>
  </div>
</div>