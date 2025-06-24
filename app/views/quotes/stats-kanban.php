<div class="pt-4">
  <div class="w-full px-4">
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">

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
          <div class="text-xl font-bold text-gray-900">$<?= $seguimiento_amount ?> K</div>
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
          <div class="text-xl font-bold text-gray-900">$<?= $ganadas_amount ?> K</div>
          <div class="text-xl font-bold text-gray-900"><?= $ganadas ?></div>
          <div class="text-sm text-gray-500">Ganadas</div>
        </div>
        <div class="text-black-500 bg-gray-100 rounded-full py-2 px-3 text-xl">
          <i class="ri-checkbox-circle-line"></i>
        </div>
      </div>

            <!-- Avg Age -->
      <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between border-l-4 border-gray-700">
        <div>
          <div class="text-xl font-bold text-gray-900">$<?= $perdidas_amount ?> K</div>
          <div class="text-xl font-bold text-gray-900"><?= $perdidas ?></div>
          <div class="text-sm text-gray-500">Perdidas</div>
        </div>
        <div class="text-black-500 bg-gray-100 rounded-full py-2 px-3 text-xl">
          <i class="ri-close-circle-line"></i>
        </div>
      </div>

    </div>
  </div>
</div>