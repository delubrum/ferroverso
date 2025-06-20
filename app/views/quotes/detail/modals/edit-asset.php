<form class="flex flex-col max-h-[calc(90vh-160px)] overflow-y-auto"
    hx-post='?c=Assets&a=Save'
    hx-indicator="#loading">
    <div class="modal-header flex justify-between items-center pb-4 border-b border-gray-200">
    <h5 class="modal-title text-lg font-bold text-gray-900">New Asset Form</h5>
    <button type="button" class="text-gray-400 text-xl font-bold cursor-pointer hover:text-gray-700 leading-none" data-dismiss="modal" aria-label="Close">&times;</button>
    </div>

    <div class="modal-body py-6 grid grid-cols-2 gap-6">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id->asset_id : '' ?>">
    <div>
        <label for="hostname" class="block mb-1 font-medium text-gray-700 text-sm">* Hostname:</label>
        <input type="text" id="hostname" name="hostname" class="w-full px-3 py-2.5 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" value="<?php echo isset($id) ? $id->hostname : '' ?>" required>
    </div>

    <div>
        <label for="serial" class="block mb-1 font-medium text-gray-700 text-sm">* Serial:</label>
        <input type="text" id="serial" name="serial" class="w-full px-3 py-2.5 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" value="<?php echo isset($id) ? $id->serial : '' ?>" required>
    </div>

    <div>
        <label for="brand" class="block mb-1 font-medium text-gray-700 text-sm">* Brand:</label>
        <input type="text" id="brand" name="brand" class="w-full px-3 py-2.5 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" value="<?php echo isset($id) ? $id->brand : '' ?>" required>
    </div>

    <div>
        <label for="model" class="block mb-1 font-medium text-gray-700 text-sm">* Model:</label>
        <input type="text" id="model" name="model" class="w-full px-3 py-2.5 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" value="<?php echo isset($id) ? $id->model : '' ?>" required>
    </div>

    <div>
        <label for="type" class="block mb-1 font-medium text-gray-700 text-sm">* Type:</label>
        <select id="type" name="type" class="w-full px-3 py-2.5 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" required>
        <option value="Mobile Phone" <?php echo (isset($id) && $id->type == 'Mobile Phone') ? 'selected' : '' ?>>Mobile Phone</option>
        <option value="Printer" <?php echo (isset($id) && $id->type == 'Printer') ? 'selected' : '' ?>>Printer</option>
        <option value="Mini Box" <?php echo (isset($id) && $id->type == 'Mini Box') ? 'selected' : '' ?>>Mini Box</option>
        <option value="Mini Tower" <?php echo (isset($id) && $id->type == 'Mini Tower') ? 'selected' : '' ?>>Mini Tower</option>
        <option value="Gun" <?php echo (isset($id) && $id->type == 'Gun') ? 'selected' : '' ?>>Gun</option>
        <option value="Laptop" <?php echo (isset($id) && $id->type == 'Laptop') ? 'selected' : '' ?>>Laptop</option>
        <option value="Tablet" <?php echo (isset($id) && $id->type == 'Tablet') ? 'selected' : '' ?>>Tablet</option>
        <option value="Tower" <?php echo (isset($id) && $id->type == 'Tower') ? 'selected' : '' ?>>Tower</option>
        <option value="TV" <?php echo (isset($id) && $id->type == 'TV') ? 'selected' : '' ?>>TV</option>
        <option value="UPS" <?php echo (isset($id) && $id->type == 'UPS') ? 'selected' : '' ?>>UPS</option>
        </select>
    </div>

    <div>
        <label for="cpu" class="block mb-1 font-medium text-gray-700 text-sm">* CPU:</label>
        <input type="text" id="cpu" name="cpu" class="w-full px-3 py-2.5 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" value="<?php echo isset($id) ? $id->cpu : '' ?>" required>
    </div>

    <div>
        <label for="ram" class="block mb-1 font-medium text-gray-700 text-sm">* RAM:</label>
        <input type="text" id="ram" name="ram" class="w-full px-3 py-2.5 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" value="<?php echo isset($id) ? $id->ram : '' ?>" required>
    </div>

    <div>
        <label for="ssd" class="block mb-1 font-medium text-gray-700 text-sm">* SSD:</label>
        <input type="text" id="ssd" name="ssd" class="w-full px-3 py-2.5 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" value="<?php echo isset($id) ? $id->ssd : '' ?>" required>
    </div>

    <div>
        <label for="hdd" class="block mb-1 font-medium text-gray-700 text-sm">* HDD:</label>
        <input type="text" id="hdd" name="hdd" class="w-full px-3 py-2.5 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" value="<?php echo isset($id) ? $id->hdd : '' ?>" required>
    </div>

    <div>
        <label for="so" class="block mb-1 font-medium text-gray-700 text-sm">* SO:</label>
        <input type="text" id="so" name="so" class="w-full px-3 py-2.5 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" value="<?php echo isset($id) ? $id->so : '' ?>" required>
    </div>

    <div>
        <label for="sap" class="block mb-1 font-medium text-gray-700 text-sm">* SAP:</label>
        <input type="text" id="sap" name="sap" class="w-full px-3 py-2.5 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" value="<?php echo isset($id) ? $id->sap : '' ?>" required>
    </div>

    <div>
        <label for="price" class="block mb-1 font-medium text-gray-700 text-sm">* Price:</label>
        <input type="text" id="price" name="price" class="w-full px-3 py-2.5 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" value="<?php echo isset($id) ? $id->price : '' ?>" required>
    </div>

    <div>
        <label for="date" class="block mb-1 font-medium text-gray-700 text-sm">* Date:</label>
        <input type="date" id="date" name="date" class="w-full px-3 py-2.5 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" value="<?php echo isset($id) ? $id->date : '' ?>">
    </div>

    <div>
        <label for="invoice" class="block mb-1 font-medium text-gray-700 text-sm">* Invoice:</label>
        <input type="text" id="invoice" name="invoice" class="w-full px-3 py-2.5 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" value="<?php echo isset($id) ? $id->invoice : '' ?>" required>
    </div>

    <div>
        <label for="supplier" class="block mb-1 font-medium text-gray-700 text-sm">* Supplier:</label>
        <input type="text" id="supplier" name="supplier" class="w-full px-3 py-2.5 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" value="<?php echo isset($id) ? $id->supplier : '' ?>" required>
    </div>
    </div>

    <div class="flex justify-end gap-2 mt-4 pt-2.5 border-t border-gray-200">
        <button @click="$dispatch('close-modal-from-inner')" class="px-4 py-2 rounded-md text-sm font-medium cursor-pointer transition-all duration-200 ease-in-out shadow-sm hover:shadow-md hover:-translate-y-0.5 bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300">Cancel</button>
        <button type="submit" class="px-3 py-1.5 rounded-md text-sm font-medium cursor-pointer transition-all duration-200 ease-in-out flex items-center justify-center space-x-1.5 shadow-sm hover:shadow-md hover:-translate-y-0.5 bg-gray-800 text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-opacity-50" id="saveReturnBtn">Save</button>
    </div>
</form>
