<form
    hx-post='?c=Assets&a=SaveAutomation'
    hx-indicator="#loading">

    <div class="modal-header flex justify-between items-center py-3 px-6 border-b border-gray-200">
        <h2 class="m-0 text-xl font-semibold text-gray-900">Add Automation</h2>
        <button @click="$dispatch('close-modal-from-inner')" class="text-gray-500 text-2xl font-bold cursor-pointer hover:text-gray-700 leading-none focus:outline-none transition-colors duration-200">&times;</button>
    </div>

    <div class="modal-body py-6 px-6 max-h-[calc(90vh-160px)] overflow-y-auto">

            <input type="hidden" name="asset_id" value="<?= isset($id) ? $id->asset_id : '' ?>">

            <label for="maintenanceDate" class="block mb-1 font-medium text-gray-700 text-sm">Last Done:</label>
            <input type="date" id="maintenanceDate" name="last" class="w-full px-3 py-2.5 mb-3 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" required>
            
            <label for="maintenanceStatus" class="block mb-1 font-medium text-gray-700 text-sm">Frequency:</label>
            <select id="maintenanceStatus" name="frequency" class="w-full px-3 py-2.5 mb-3 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500">
                <option value=''></option>
                <option value='Weekly'>Weekly</option>
                <option value='Monthly'>Monthly</option>
                <option value='Quarterly'>Quarterly</option>
                <option value='Semiannual'>Semiannual</option>
                <option value='Annual'>Annual</option>
                <option value='Annualx2'>Annualx2</option>
                <option value='Annualx3'>Annualx3</option>
                <option value='Annualx5'>Annualx5</option>
            </select>

            <label for="maintenanceResponsible" class="block mb-1 font-medium text-gray-700 text-sm">Activity:</label>
            <input type="text" id="maintenanceResponsible" name="activity" class="w-full px-3 py-2.5 mb-3 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" required>
        
        </div>
        <div class="flex justify-end gap-2 mt-4 pt-2.5 border-t border-gray-200">
            <button @click="$dispatch('close-modal-from-inner')" class="px-4 py-2 rounded-md text-sm font-medium cursor-pointer transition-all duration-200 ease-in-out shadow-sm hover:shadow-md hover:-translate-y-0.5 bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300">Cancel</button>
            <button type="submit" class="px-3 py-1.5 rounded-md text-sm font-medium cursor-pointer transition-all duration-200 ease-in-out flex items-center justify-center space-x-1.5 shadow-sm hover:shadow-md hover:-translate-y-0.5 bg-gray-800 text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-opacity-50" id="saveReturnBtn">Save</button>
        </div>
    </div>
</div>
