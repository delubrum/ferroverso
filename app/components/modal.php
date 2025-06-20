<div class="mt-2 fixed inset-0 z-40 flex justify-center items-start"
  x-show="showModal" 
>
  <div class="fixed inset-0 bg-black opacity-70"></div>
  <div id="myModal" class="w-full flex justify-center animate__animated animate__bounceInDown"></div>
</div>

<div
  class="mt-2 fixed inset-0 z-50 flex justify-center items-start"
  x-show="nestedModal" 
>
  <div @click.stop class="fixed inset-0 bg-black opacity-70"></div>
  <div @click.stop id="nestedModal" class="w-full flex justify-center animate__animated animate__bounceInDown"></div>
</div>