<!DOCTYPE html>
<html lang="en">
  <head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Ferroverso</title>
    <link rel="icon" sizes="192x192" href="app/assets/img/logo.png" />
    <script src="https://unpkg.com/htmx.org@1.9.6" integrity="sha384-FhXw7b6AlE/jyjlZH5iHa/tTe9EpJ1Y55RjcgPbjeWMskSxZt1v9qkxLJWNJaGni" crossorigin="anonymous"></script>
		<script src="https://cdn.tailwindcss.com"></script>
		<link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
		<link href="app/assets/css/styles.css?v=1.0.0" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>
    <?php if(isset($jspreadsheet)) { ?>
      <link rel="stylesheet" href="https://bossanova.uk/jspreadsheet/v4/jexcel.css" type="text/css" />
      <script src="https://bossanova.uk/jspreadsheet/v4/jexcel.js"></script>
      <script src="https://jsuites.net/v4/jsuites.js"></script>
      <link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />
    <?php } ?>
    <?php if(isset($tabulator)) { ?>
      <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
      <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>
    <?php } ?>
    <style>
    .ts-control {
      border: none !important;
      box-shadow: none !important;
      padding: 0 !important;
    }
    </style>
	</head>
  <body x-data='{ showModal: false, nestedModal: false, sidebar: false, showFilters : false }'>
		<?php require_once "app/components/sidebar.php" ?>
		<!-- <main class="w-full bg-gray-100 min-h-screen transition-all main active custombg"> -->
    <main class="w-full bg-gray-100 min-h-screen transition-all main active">
			<?php require_once "app/components/navbar.php" ?>
			<div id="content" class="pt-2 sm:px-20">
        <div id="loading" class="htmx-indicator pointer-events-none absolute z-[80] h-full w-full top-0 left-0 align-middle bg-gray-50">
            <div class="h-full w-full flex flex-col justify-center place-items-center my-auto">
              <div class="w-24 h-24 bg-no-repeat bg-center bg-[url('app/assets/img/loader.gif')] bg-contain opacity-90"></div>
            </div>
        </div>
				<?php require_once $content ?>
			</div>
		</main>
		<?php require_once 'app/components/modal.php' ?>
		<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.1/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
      const notyf = new Notyf({
        duration: 3000,
        position: {
          x: 'right',
          y: 'top',
        }
      });

      htmx.on("showMessage", (e) => {
        if(JSON.parse(e.detail.value).close != ""){
          let trigger = JSON.parse(e.detail.value).close;
          document.getElementById(trigger).click();
        };
        notyf.success(JSON.parse(e.detail.value));
      });

      htmx.on('listChanged', function(event) {
        // table.setPage(table.getPage());
        table.replaceData().then(() => {
          htmx.process(document.querySelector('#list'));
        });
      });

      htmx.on('tableChanged', function(event) {
        table.setPage(table.getPage()).then(() => {
          htmx.process(document.querySelector('#list'));
        });
      });
    </script>
  </body>
</html>