<?php
require_once 'app/models/model.php';
class UsersController {
    private $model;
    public function __CONSTRUCT(){
        $this->model = new Model();
    }

    public function Index()
    {
        $user = $this->model->auth(1);
        
        $tabulator = true;
        $title = "Configuración / Usuarios";
        $button = 'Nuevo Usuario';
        $content = 'app/components/table.php';

        $columns = '[
            { "title": "ID", "field": "id", headerHozAlign: "center", headerFilter:"input"},
            { "title": "Fecha", "field": "created_at", headerHozAlign: "center", headerFilter: customDateRangeFilter, headerFilterFunc: customDateFilterFunc, headerFilterLiveFilter: false },
            { "title": "Nombre", "field": "username", headerHozAlign: "center", headerFilter:"input", },
            { "title": "Email", "field": "email", headerHozAlign: "center", headerFilter:"input", },
            { "title": "Estado", "field": "status", headerHozAlign: "center", headerFilter:"list", hozAlign:"center", headerFilterParams:{ values: {"1": "Activo", "0": "Inactivo"}, clearable:true}, width: "150" },
            { "title": "Acción", "field": "action",  formatter: "html", hozAlign: "center", headerHozAlign: "center", width: 100, }
        ]';
        require_once 'app/views/index.php';
    }

    public function Data()
    {
        $user = $this->model->auth(1);

        header('Content-Type: application/json');

        // Parámetros de paginación
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $size = isset($_GET['size']) ? (int)$_GET['size'] : 15;
        $offset = ($page - 1) * $size;

        $where = "";
        if (isset($_GET['filter']) && is_array($_GET['filter'])) {
            foreach ($_GET['filter'] as $f) {
                if (!isset($f['field'], $f['value'])) continue;

                $field = addslashes($f['field']);
                $value = addslashes($f['value']);

                // Filtro de fecha con rango
                if ($field == 'created_at' && strpos($value, ' to ') !== false) {
                    list($from, $to) = explode(' to ', $value);
                    $where .= " AND DATE(created_at) BETWEEN '$from' AND '$to'";
                } else {
                    $where .= " AND $field LIKE '%$value%'";
                }
            }
        }
        
        // Ordenamiento
        $orderBy = "id DESC"; // valor por defecto
        if (isset($_GET['sort'][0]['field']) && isset($_GET['sort'][0]['dir'])) {
            $sortField = addslashes($_GET['sort'][0]['field']);
            $sortDir = strtoupper($_GET['sort'][0]['dir']) === 'ASC' ? 'ASC' : 'DESC';
            
            // Campo especial: "date" → "created_at"
            if ($sortField === 'date') $sortField = 'created_at';

            $orderBy = "$sortField $sortDir";
        }

        // Total de registros
        $total = $this->model->get('count(id) as total','users', $where)->total;

        // Obtener registros con paginación
        $rows = $this->model->list('*', 'users', "$where ORDER BY $orderBy LIMIT $offset, $size");

        $data = [];

        foreach ($rows as $r) {
            $status = ($r->status === 1) ? 'Activo' : 'Inactivo';
            $b1 = ($r->status != 1)
            ? "<a hx-get='?c=Users&a=Status&id=$r->id&status=1' hx-swap = 'outerHTML' class='mx-3 text-gray-900 hover:text-gray-700 cursor-pointer'><i class='ri-toggle-line text-lg'></i></a>" 
            : "<a hx-get='?c=Users&a=Status&id=$r->id&status=0' hx-swap = 'outerHTML' class='mx-3 text-gray-900 hover:text-gray-700 cursor-pointer '><i class='ri-toggle-fill text-lg'></i></a>";
            $b2 = "<a hx-get='?c=Users&a=Profile&id=$r->id' hx-target='#myModal' @click='showModal = true' class='text-gray-900 hover:text-gray-700 cursor-pointer mx-3'><i class='ri-edit-2-line text-lg'></i></a>";
            if (in_array($r->id, [1])) {
                $b1 = '';
            }
            $data[] = [
                'id' => $r->id,
                'created_at' => $r->created_at,
                'username' => $r->username,
                'email' => $r->email,
                'status' => $status,
                'action' => "$b1$b2"
            ];
        }

        echo json_encode([
            "data" => $data,
            "last_page" => ceil($total / $size),
            "last_row" => $total
        ]);
    }

    public function New()
    {
        $user = $this->model->auth(4);
        require_once 'app/views/users/new.php';
    }

    public function Profile()
    {
        $user = $this->model->auth(1);

        if (isset($_REQUEST["id"])){
        $filters = "and id = " . $_REQUEST['id'];
        $id = $this->model->get('*','users',$filters);
        $userPermissions = json_decode($id->permissions, true);
        require_once 'app/views/users/profile.php';
        } else if (!in_array(1, json_decode($user->permissions, true)

        ) and ($_REQUEST["id"] == $user->id) ){
            $id = $user;
            require_once 'app/views/users/profile.php';
            }
    }

    public function Status()
    {
        $user = $this->model->auth(1);

        $item = new stdClass();
        $item->status = $_REQUEST['status'];
        $id = $this->model->update('users',$item, $_REQUEST['id']);

        if ($id !== false) {
            $hxTriggerData = json_encode([
                "tableChanged" => true,
            ]);
            header('HX-Trigger: ' . $hxTriggerData);
            http_response_code(204);
        }
    }

    public function Save()
    {
        $user = $this->model->auth(1);

        header('Content-Type: application/json');
        $response = [];
        $item = new stdClass();
        $item->username = $_REQUEST['name'];
        $item->email = $_REQUEST['email'];
        $item->lang = 'en';
        $item->password = $_REQUEST['newpass'];
        $item->permissions = '[]';
        $item->type = $_REQUEST['type'];
        $cpass = $_REQUEST['cpass'];
        $cpass = $_REQUEST['cpass'];
        if ($cpass != '' and $cpass != $item->password) {
            $hxTriggerData = json_encode([
                "showMessage" => '{"type": "error", "message": "Las contraseñas no coinciden", "close" : ""}'
            ]);
            header('HX-Trigger: ' . $hxTriggerData);
            http_response_code(204);
            exit;
        }

        if (strlen($item->password) < 4) {
            $hxTriggerData = json_encode([
                "showMessage" => '{"type": "error", "message": "La contraseña debe tener almenos 4 caracteres", "close" : ""}'
            ]);
            header('HX-Trigger: ' . $hxTriggerData);
            http_response_code(204);
            exit;
        }

        if ($this->model->get('email','users',"and email = '$item->email'")) {
            $hxTriggerData = json_encode([
                "showMessage" => '{"type": "error", "message": "El email ya existe", "close" : ""}'
            ]);
            header('HX-Trigger: ' . $hxTriggerData);
            http_response_code(204);
            exit;
        }

        $item->password = password_hash($item->password, PASSWORD_DEFAULT);
        $id = $this->model->save('users', $item);
        if ($id !== false) {
            $message = '{"type": "success", "message": "Usuario Guardado", "close" : "closeNewModal"}';
            $hxTriggerData = json_encode([
                "listChanged" => true,
                "showMessage" => $message
            ]);
            header('HX-Trigger: ' . $hxTriggerData);
            http_response_code(204);
        }   
    }

    public function UpdatePermission()
    {
        $user = $this->model->auth(1);

        $userId = $_REQUEST['userId'];
        $pId = $_REQUEST['pId'];
        $action = $_REQUEST['action'];
        $name = $_REQUEST['name'];
        $filters = "and id = $userId";
        $permissions = json_decode($this->model->get('permissions','users',$filters)->permissions);
        if ($action == 0) {
            $newArr = array_filter(json_decode($user->permissions, true), function($value) use ($pId) {
                return $value != $pId;
            });
        } else {
            $newArr = array_merge(json_decode($user->permissions, true), [intval($pId)]);
        }
        $item = new stdClass();
        sort($newArr);
        $item->permissions = json_encode(array_values($newArr));
        $id = $this->model->update('users',$item,$userId);
        $color = (in_array($pId,$newArr)) ? 'bg-gray-900 hover:bg-gray-700' : 'bg-gray-500 hover:bg-gray-600';
        $action = (in_array($pId,$newArr)) ? '0' : '1';
        echo "<button 
        hx-put='?c=Users&a=UpdatePermission&userId=$userId&pId=$pId&action=$action&name=$name'
        hx-swap = 'outerHTML'
        hx-trigger='click'
        class='text-white text-sm py-2 px-4 m-1 rounded-md $color transition'>
            <div hx-get='?c=Home&a=Sidebar' hx-target='#sidebarMenu' hx-trigger='load' hx-swap='innetHtml'>
            $name
            </div>
        </button>";
    }

    public function Update()
    {
        $user = $this->model->auth(1);

        $item = new stdClass();
        
        foreach($_POST as $k => $val) {
            if (!empty($val)) {
                if($k != 'id') {
                    $item->{$k} = $val;
                }
            }
        }
        $id = $this->model->update('users',$item,$_REQUEST['id']);
        if ($id !== false) {
            $message = '{"type": "success", "message": "Dato Actualizado", "close" : ""}';
            $hxTriggerData = json_encode([
                "tableChanged" => true,
                "showMessage" => $message
            ]);
            header('HX-Trigger: ' . $hxTriggerData);
            http_response_code(204);
        }
    }

    public function UpdatePassword() 
    {
        $user = $this->model->auth(1);

        $item = new stdClass();
        $item->password = $_REQUEST['newpass'];
        $cpass = $_REQUEST['cpass'];
        if ($cpass != '' and $cpass != $item->password) {
            $hxTriggerData = json_encode([
                "showMessage" => '{"type": "error", "message": "Las contraseñas no coinciden", "close" : ""}'
            ]);
            header('HX-Trigger: ' . $hxTriggerData);
            http_response_code(204);
            exit;
        }
        if (strlen($item->password) < 4) {
            $hxTriggerData = json_encode([
                "showMessage" => '{"type": "error", "message": "La contraseña debe tener almenos 4 caracteres", "close" : ""}'
            ]);
            header('HX-Trigger: ' . $hxTriggerData);
            http_response_code(204);
            exit;
        }
        $item->password = password_hash($item->password, PASSWORD_DEFAULT);
        $id = $this->model->update('users',$item,$_REQUEST['id']);
        if ($id !== false) {
            $message = '{"type": "success", "message": "Contraseña Actualizada", "close" : ""}';
            $hxTriggerData = json_encode([
                "listChanged" => true,
                "showMessage" => $message
            ]);
            header('HX-Trigger: ' . $hxTriggerData);
            http_response_code(204);
        }
    }

}