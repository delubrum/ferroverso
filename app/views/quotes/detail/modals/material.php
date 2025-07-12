<div class="w-[95%] sm:w-[25%] bg-white p-4 rounded-lg shadow-lg relative z-50">
    <!-- Close Button (X) in Top-Right Corner -->
    <button 
      class="absolute top-0 right-0 m-3 text-gray-900 hover:text-gray-700"
      @click="showModal = !showModal; document.getElementById('myModal').innerHTML = '';"
    >
        <i class="ri-close-line text-2xl"></i>
    </button>
    <h1 class="text-black-700"><i class="ri-add-line text-2xl"></i> <span class="text-2xl font-semibold"> Nuevo Material <span></h1>
    <form >
    </form>
</div>

<script>
  document.querySelectorAll('.tomselect').forEach(el => {
    new TomSelect(el);
  });
</script>
