<div id="addMaintenanceHistoryModal" class="modal fixed inset-0 z-[1000] flex items-center justify-center bg-black bg-opacity-50 p-4 hidden">
    <div class="bg-white p-5 rounded-lg shadow-2xl relative animate-fade-in w-full max-w-md max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4 pb-2.5 border-b border-gray-200">
            <h2 class="m-0 text-lg font-bold text-gray-900">Añadir Historial de Mantenimiento</h2>
            <span class="close-button text-gray-400 absolute top-3 right-4 text-xl font-bold cursor-pointer hover:text-gray-700">&times;</span>
        </div>
        <div class="modal-body">
            <label for="maintHistoryDate" class="block mb-1 font-medium text-gray-700 text-sm">Fecha:</label>
            <input type="date" id="maintHistoryDate" class="w-full px-3 py-2.5 mb-3 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" required>
            <label for="maintHistoryTitle" class="block mb-1 font-medium text-gray-700 text-sm">Título:</label>
            <input type="text" id="maintHistoryTitle" class="w-full px-3 py-2.5 mb-3 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" placeholder="Ej: Reemplazo de Disco Duro" required>
            <label for="maintHistoryResponsible" class="block mb-1 font-medium text-gray-700 text-sm">Responsable:</label>
            <input type="text" id="maintHistoryResponsible" class="w-full px-3 py-2.5 mb-3 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" placeholder="Ej: Soporte IT" required>
            <label for="maintHistoryCost" class="block mb-1 font-medium text-gray-700 text-sm">Costo:</label>
            <input type="text" id="maintHistoryCost" class="w-full px-3 py-2.5 mb-3 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500" placeholder="Ej: $120.00">
            <label for="maintHistoryObs" class="block mb-1 font-medium text-gray-700 text-sm">Observaciones:</label>
            <textarea id="maintHistoryObs" rows="2" class="w-full px-3 py-2.5 mb-3 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 resize-y min-h-[50px]" placeholder="Detalles del mantenimiento"></textarea>
        </div>
        <div class="flex justify-end gap-2 mt-4 pt-2.5 border-t border-gray-200">
            <button class="px-3 py-1.5 rounded-md text-sm font-medium cursor-pointer transition-all duration-200 ease-in-out flex items-center justify-center space-x-1.5 shadow-sm hover:shadow-md hover:-translate-y-0.5 bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 close-button-footer">Cancelar</button>
            <button class="px-3 py-1.5 rounded-md text-sm font-medium cursor-pointer transition-all duration-200 ease-in-out flex items-center justify-center space-x-1.5 shadow-sm hover:shadow-md hover:-translate-y-0.5 bg-gray-800 text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-opacity-50" id="saveMaintenanceHistoryBtn">Guardar Historial</button>
        </div>
    </div>
</div>
