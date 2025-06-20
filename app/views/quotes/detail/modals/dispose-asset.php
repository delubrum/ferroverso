<form
    hx-encoding='multipart/form-data'
    hx-post='?c=Assets&a=SaveEvent'
    hx-indicator="#loading">

    <div class="modal-header flex justify-between items-center py-3 px-6 border-b border-gray-200">
        <h2 class="m-0 text-xl font-semibold text-gray-900">Return Asset</h2>
        <button @click="$dispatch('close-modal-from-inner')" class="text-gray-500 text-2xl font-bold cursor-pointer hover:text-gray-700 leading-none focus:outline-none transition-colors duration-200">&times;</button>
    </div>

    <div class="modal-body py-6 px-6 max-h-[calc(90vh-160px)] overflow-y-auto">
        <input type="hidden" name="asset_id" value="<?= isset($id) ? $id->asset_id : '' ?>">
        <input type="hidden" name="type" value="dispose">

        <label for="returnDataWipe" class="block mb-1 font-medium text-gray-700 text-sm">Secure Data Wipe:</label>
        <select id="returnDataWipe" name="wipe" class="w-full px-3 py-2.5 mb-3 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" required>
            <option value="obsolete">Obsolete</option>
            <option value="irreparable">Irreparable</option>
            <option value="expired">Expired</option>
            <option value="sold">Sold</option>
            <option value="donated">Donated</option>
            <option value="stolen">Stolen</option>
            <option value="lost">Lost</option>
        </select>

        <div class="mb-5">
            <label for="assignmentObs" class="block text-sm font-medium text-gray-700 mb-2">Observations:</label>
            <textarea id="assignmentObs" rows="2" name="notes" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm text-base text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-y min-h-[80px] transition-all duration-200" placeholder="Observations"></textarea>
        </div>

        <div class="mb-5">
            <label for="minute" class="block text-sm font-medium text-gray-700 mb-2">Minute:</label>
            <input type="file" name="files[]" id="minute" required>
        </div>
    </div>

    <div class="flex justify-end gap-2 mt-4 pt-2.5 border-t border-gray-200">
        <button @click="$dispatch('close-modal-from-inner')" class="px-4 py-2 rounded-md text-sm font-medium cursor-pointer transition-all duration-200 ease-in-out shadow-sm hover:shadow-md hover:-translate-y-0.5 bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300">Cancel</button>
        <button type="submit" class="px-3 py-1.5 rounded-md text-sm font-medium cursor-pointer transition-all duration-200 ease-in-out flex items-center justify-center space-x-1.5 shadow-sm hover:shadow-md hover:-translate-y-0.5 bg-gray-800 text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-opacity-50" id="saveReturnBtn">Save</button>
    </div>
</form>