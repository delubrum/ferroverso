<div @click.outside="showModal = false" class="w-[95%] sm:w-[90%] bg-white p-4 rounded-lg shadow-lg relative z-50">
    <!-- Close Button (X) in Top-Right Corner -->
    <button id="closeModal" @click="showModal = !showModal" class="absolute top-0 right-0 m-3 text-gray-900 hover:text-gray-700">
        <i class="ri-close-line text-2xl"></i>
    </button>
    <h1 class="mb-4 text-black-700"><i class="ri-add-line text-3xl"></i> <span class="text-2xl font-semibold"> <?php echo (isset($id)) ? 'Editar' : 'Nueva'; ?> Cotización <span></h1>
    <form  id="newForm" 
        class="overflow-y-auto max-h-[600px] p-4"
        hx-post='?c=Quotes&a=Save' 
        hx-swap="none"
        hx-vals='js:{contacts: JSON.stringify(contacts.getData())}'
        hx-indicator="#loading"
    >
      <?php echo isset($id) ? "<input type='hidden' name='id' value='$id->id'>" : '' ?>
      <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">

        <div>
          <label for="user" class="block text-gray-600 text-sm mb-1 select2">Cliente</label>
          <select id="user" name="user" class="w-full bg-white p-[9px] w-full p-1.5 border border-gray-300 rounded-md focus:ring focus:ring-teal-700 focus:outline-none" required>
            <option value='' disabled selected></option>
            <?php foreach ($this->model->list("*","clients"," and status = 1") as $r) { ?>     
              <option value='<?php echo $r->id?>'><?php echo $r->company?></option>
            <?php } ?>
          </select>
        </div>

        <div>
          <label for="user" class="block text-gray-600 text-sm mb-1 select2">Obra</label>
          <select id="user" name="user" class="w-full bg-white p-[9px] w-full p-1.5 border border-gray-300 rounded-md focus:ring focus:ring-teal-700 focus:outline-none" required>
            <option value='' disabled selected></option>
            <?php foreach ($this->model->list("*","clients"," and status = 1") as $r) { ?>     
              <option value='<?php echo $r->id?>'><?php echo $r->company?></option>
            <?php } ?>
          </select>
        </div>

        <div>
            <label for="city" class="block text-gray-600 text-sm mb-1">Valor AI</label>
            <input type="text" id="city" name="city" value="<?php echo isset($id) ? $id->city : '' ?>" class="w-full p-1.5 border border-gray-300 rounded-md focus:ring focus:ring-teal-700 focus:outline-none" required>
        </div>

        <div>
            <label for="city" class="block text-gray-600 text-sm mb-1">AUI</label>
            <input type="text" id="city" name="city" value="<?php echo isset($id) ? $id->city : '' ?>" class="w-full p-1.5 border border-gray-300 rounded-md focus:ring focus:ring-teal-700 focus:outline-none" required>
        </div>
      </div>

      <div class="mt-6 flex justify-end">
        <button type="submit" 
        class="text-xl float-left text-gray-900 px-4 py-2 font-bold hover:text-gray-700"
        >
          <i class="ri-save-line"></i> <?php echo (isset($id)) ? 'Actualizar' : 'Guardar'; ?>
        </button>
      </div>
    </form>
</div>