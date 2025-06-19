<?php
require_once 'app/models/model.php';

class QuotesController{
  private $model;
  public function __CONSTRUCT(){
    $this->model = new Model();
  }

  public function Index(){
    require_once "lib/check.php";
    if (in_array(2, $permissions)) {
      $title = "Cotizaciones / Registro";
      $fields = array("id","fecha","cliente","obra","valor","aui","valor_total");
      $url = '?c=Quotes&a=Data';
      $new = '?c=Quotes&a=New';
      $content = 'app/components/index-filter.php';
      $datatables = true;
      $jspreadsheet = false;
      require_once 'app/views/index.php';
    } else {
      $this->model->redirect();
    }
  }

  public function Data(){
    header('Content-Type: application/json');
    require_once "lib/check.php";
    if (in_array(2, $permissions)) {
      $result[] = array();
      $i=0;
      foreach($this->model->list('*','quotes') as $r) {
        $result[$i]['id'] = $r->id;
        $result[$i]['fecha'] = $r->created_at;
        $result[$i]['cliente'] = $r->client_id;
        $result[$i]['obra'] = $r->product_id;
        $result[$i]['valor'] = $r->amount;
        $result[$i]['aui'] = $r->aui;
        $result[$i]['valor_total'] = $r->total_amount;
        $edit = "<a hx-get='?c=Quotes&a=New&id=$r->id' hx-target='#myModal' @click='showModal = true' class='block text-teal-900 hover:text-teal-700 cursor-pointer float-right mx-3'><i class='ri-edit-2-line '></i></a>";
        $result[$i]['acción'] = "$edit";
        $i++;
      }
      echo json_encode($result);
    } else {
      $this->model->redirect();
    }
  }

  public function New(){
    require_once "lib/check.php";
    if (in_array(2, $permissions)) {
      if (!empty($_REQUEST['id'])) {
        $filters = "and id = " . $_REQUEST['id'];
        $id = $this->model->get('*','clients', $filters);
      }
      require_once 'app/views/quotes/new.php';
    } else {
      $this->model->redirect();
    }
  }

  public function Save(){
    require_once "lib/check.php";
    if (in_array(4, $permissions)) {
      header('Content-Type: application/json');
      $company = $_POST['company'];
      if (empty($_POST['id']) and $this->model->get('id','clients',"and company = '$company'")) {
        $hxTriggerData = json_encode([
          "showMessage" => '{"type": "error", "message": "El cliente ya existe", "close" : ""}'
        ]);
        header('HX-Trigger: ' . $hxTriggerData);
        http_response_code(409);
        exit;
      }
      if ($_POST['id']) {
        $id = $_POST['id'];
        if ($this->model->get('id','clients',"and company = '$company' and id <> $id")) {
        $hxTriggerData = json_encode([
          "showMessage" => '{"type": "error", "message": "Ya existe un cliente con el nombre que intentas actualizar", "close" : ""}'
        ]);
        header('HX-Trigger: ' . $hxTriggerData);
        http_response_code(409);
        exit;
      }
      }
      $item = new stdClass();
      $table = 'clients';
      $item->company = $_REQUEST['company'];
      $item->city = $_REQUEST['city'];
      $item->drums = $_REQUEST['drums'];
      $item->contacts = $_REQUEST['contacts'];
      $item->price1 = $_REQUEST['price1'];
      $item->price2 = $_REQUEST['price2'];
      $item->price3 = $_REQUEST['price3'];
      $item->price4 = $_REQUEST['price4'];
      $item->products = json_encode($_REQUEST['products']);
      empty($_POST['id'])
      ? $id = $this->model->save($table,$item)
      : $id = $this->model->update($table,$item,$_POST['id']);
      if ($id !== false) {
        (empty($_POST['id'])) 
          ? $message = '{"type": "success", "message": "Cliente guardado", "close" : "closeModal"}'
          : $message = '{"type": "success", "message": "Cliente actualizado", "close" : "closeModal"}';
        $hxTriggerData = json_encode([
          "listChanged" => true,
          "showMessage" => $message
        ]);
        header('HX-Trigger: ' . $hxTriggerData);
        http_response_code(204);
      }
    } else {
      $this->model->redirect();
    }
  }

  public function Indicators() {
    require_once "lib/check.php";
    if (in_array(2, $permissions)) {
      $in = isset($_REQUEST['in']) ? $_REQUEST['in'] : 1;
      (!empty($_REQUEST['year'])) ? $year = $_REQUEST['year'] : $year = date('Y');
      $date = $year . "-01-01";
      $quotes = $this->model->list(
          "UPPER(status) as status, DATE_FORMAT(created_at, '%b') as month, COUNT(*) as total",
          "quotes",
          "and YEAR(created_at) = '$date' GROUP BY created_at, status ORDER BY MONTH(created_at)",
          ""
      );

      // Inicializa estructura
      $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
      $quotes_by_month = [];
      foreach ($months as $month) {
          $quotes_by_month[$month] = [
              'total' => 0,
              'ganados' => 0,
              'perdidos' => 0,
              'pendientes' => 0
          ];
      }

      // Clasifica y suma por estado
      foreach ($quotes as $q) {
          $month = $q->month;
          $estado = $q->status;
          $cantidad = (int)$q->total;

          $quotes_by_month[$month]['total'] += $cantidad;

          if ($estado === 'APROBADA') {
              $quotes_by_month[$month]['ganados'] += $cantidad;
          } elseif (in_array($estado, ['RECHAZADA', 'REVALUADA'])) {
              $quotes_by_month[$month]['perdidos'] += $cantidad;
          } else {
              $quotes_by_month[$month]['pendientes'] += $cantidad;
          }
      }
      require_once 'app/views/quotes/indicators/indicators.php';
    } else {
        $this->model->redirect();
    }
    }
}