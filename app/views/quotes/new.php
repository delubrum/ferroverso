<div class="w-[95%] sm:w-[25%] bg-white p-4 rounded-lg shadow-lg relative z-50">
    <!-- Close Button (X) in Top-Right Corner -->
    <button id="closeNewModal" @click="showModal = !showModal" class="absolute top-0 right-0 m-3 text-gray-900 hover:text-gray-700">
        <i class="ri-close-line text-2xl"></i>
    </button>
    <h1 class="text-black-700"><i class="ri-add-line text-2xl"></i> <span class="text-2xl font-semibold"> <?php echo (isset($id)) ? 'Editar' : 'Nueva'; ?> Cotización <span></h1>
    <form  id="newForm" 
        class="overflow-y-auto max-h-[600px] p-4"
        hx-post='?c=Quotes&a=Save' 
        hx-swap="none"
        hx-indicator="#loading"
    >
      <?php echo isset($id) ? "<input type='hidden' name='id' value='$id->id'>" : '' ?>
      <input type='hidden' name='status' value='<?= $status ?>'>
      <div class="grid grid-cols-1">

        <? if ($status != 'seguimiento' && $status != 'ganada' && $status != 'perdida' && $status != 'modificada') : ?>

        <div>
          <label for="client_id" class="block text-gray-600 text-sm mt-4">Cliente</label>
          <select id="client_id" name="client_id" class="tomselect w-full bg-white p-[9px] w-full p-1.5 border border-gray-300 rounded-md focus:ring focus:ring-black focus:outline-none" required>
            <option value='' disabled selected></option>
            <?php foreach ($this->model->list("*","clients"," and status = 1") as $r) { ?>     
              <option value='<?php echo $r->id?>'><?php echo $r->company?></option>
            <?php } ?>
          </select>
        </div>

        <div>
          <label for="project" class="block text-gray-600 text-sm mt-4">Obra</label>
            <input type="text" id="project" name="project" value="<?php echo isset($id) ? $id->amount : '' ?>" class="w-full p-1.5 border border-gray-300 rounded-md focus:ring focus:ring-black focus:outline-none" required>
        </div>

        <? endif; ?>

        <? if ($status && $status != 'perdida') : ?>

        <div>
            <label for="amount" min="1" class="block text-gray-600 text-sm mt-4">Valor Antes de Impuestos</label>
            <input type="number" id="amount" name="amount" value="<?php echo isset($id) ? $id->amount : '' ?>" class="w-full p-1.5 border border-gray-300 rounded-md focus:ring focus:ring-black focus:outline-none" required>
        </div>

        <div>
            <label for="aui" min="1" class="block text-gray-600 text-sm mt-4">AIU</label>
            <input type="number" id="aui" name="aui" value="<?php echo isset($id) ? $id->aui : '' ?>" class="w-full p-1.5 border border-gray-300 rounded-md focus:ring focus:ring-black focus:outline-none" required>
        </div>

        <? endif; ?>

        <div>
            <label for="notes" class="block text-gray-600 text-sm mt-4">Notas</label>
            <textarea id="notes" name="notes" class="w-full p-1.5 border border-gray-300 rounded-md focus:ring focus:ring-black focus:outline-none"><?php echo isset($id) ? $id->notes : '' ?></textarea>
        </div>

      </div>

      <div class="mt-6 flex justify-end">
        <button type="submit" class="text-xl text-gray-900 font-bold hover:text-gray-700">
          <i class="ri-save-line"></i> <?php echo (isset($id)) ? 'Actualizar' : 'Guardar'; ?>
        </button>
      </div>
    </form>
</div>

<script>
  document.querySelectorAll('.tomselect').forEach(el => {
    new TomSelect(el);
  });
</script>
