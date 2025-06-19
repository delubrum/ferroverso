<?php
require_once 'app/models/model.php';

class ProductsController{
  private $model;
  public function __CONSTRUCT(){
    $this->model = new Model();
  }

  public function Index(){
    require_once "lib/check.php";
    if (in_array(3, $permissions)) {
      $title = "Configuración / Productos";
      $fields = array("id","nombre","cliente","acción");
      $url = '?c=Products&a=Data';
      $new = '?c=Products&a=New';
      $content = 'app/components/indexdt.php';
      $datatables = true;
      $jspreadsheet = false;
      require_once 'app/views/index.php';
    } else {
      $this->model->redirect();
    }
  }

  public function New(){
    require_once "lib/check.php";
    if (in_array(3, $permissions)) {
      if (!empty($_REQUEST['id'])) {
        $filters = "and id = " . $_REQUEST['id'];
        $id = $this->model->get('*','products', $filters);
      }
      require_once 'app/views/products/new.php';
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
      foreach($this->model->list('*','products') as $r) {
        $result[$i]['id'] = $r->id;
        $result[$i]['nombre'] = $r->name;
        $result[$i]['cliente'] = $r->client_id;
        $edit = "<a hx-get='?c=Products&a=New&id=$r->id' hx-target='#myModal' @click='showModal = true' class='block text-gray-900 hover:text-gray-700 cursor-pointer float-right mx-3'><i class='ri-edit-2-line '></i></a>";
        $result[$i]['acción'] = "$edit";
        $i++;
      }
      echo json_encode($result);
    } else {
      $this->model->redirect();
    }
  }


  public function Status(){
    require_once "lib/check.php";
    if (in_array(1, $permissions)) {
      $item = new stdClass();
      $item->status = $_REQUEST['status'];
      $id = $_REQUEST['id'];
      $this->model->update('products',$item,$id);
      echo ($_REQUEST['status'] == 1)
        ? "<a hx-get='?c=Products&a=Status&id=$id&status=0' hx-swap = 'outerHTML' class='block mx-3 text-gray-900 hover:text-gray-700 cursor-pointer float-right'><i class='ri-toggle-fill text-2xl'></i></a>"
        : "<a hx-get='?c=Products&a=Status&id=$id&status=1' hx-swap = 'outerHTML' class='block mx-3 text-gray-900 hover:text-gray-700 cursor-pointer float-right'><i class='ri-toggle-line text-2xl'></i></a>";
    } else {
      $this->model->redirect();
    }
  }

  public function Save(){
    require_once "lib/check.php";
    if (in_array(3, $permissions)) {
      header('Content-Type: application/json');
      $name = $_POST['name'];
      if ($this->model->get('id','products',"and name = '$name'")) {
        $hxTriggerData = json_encode([
          "showMessage" => '{"type": "error", "message": "El producto ya existe", "close" : ""}'
        ]);
        header('HX-Trigger: ' . $hxTriggerData);
        http_response_code(409);
        exit;
      }
      
      $item = new stdClass();
      $table = 'products';
      foreach($_POST as $k => $val) {
        if (!empty($val)) {
          if($k != 'id') {
            $item->{$k} = $val;
          }
        }
      }

      empty($_POST['id'])
      ? $id = $this->model->save($table,$item)
      : $id = $this->model->update($table,$item,$_POST['id']);
      if ($id !== false) {
        (empty($_POST['id'])) 
          ? $message = '{"type": "success", "message": "Producto guardado", "close" : "closeModal"}'
          : $message = '{"type": "success", "message": "Producto actualizado", "close" : "closeModal"}';
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

}