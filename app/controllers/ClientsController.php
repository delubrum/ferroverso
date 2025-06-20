<?php
require_once 'app/models/model.php';

class ClientsController{
    private $model;
    public function __CONSTRUCT(){
        $this->model = new Model();
    }

    public function Index()
    {
        $user = $this->model->auth(2);
        
        $tabulator = true;
        $jspreadsheet = true;
        $title = "Configuración / Clientes";
        $button = 'Nuevo Cliente';
        $content = 'app/components/table.php';

        $columns = '[
            { "title": "ID", "field": "id", headerHozAlign: "center", headerFilter:"input"},
            { "title": "Fecha", "field": "created_at", headerHozAlign: "center", headerFilter: customDateRangeFilter, headerFilterFunc: customDateFilterFunc, headerFilterLiveFilter: false },
            { "title": "Compañia", "field": "company", headerHozAlign: "center", headerFilter:"input", },
            { "title": "Ciudad", "field": "city", headerHozAlign: "center", headerFilter:"input", },
            { "title": "Contactos", "field": "contacts", formatter: "html", hozAlign: "center", headerHozAlign: "center", headerFilter:"input", },
            { "title": "Acción", "field": "action",  formatter: "html", hozAlign: "center", headerHozAlign: "center", width: 100, }
        ]';
        require_once 'app/views/index.php';
    }

    public function Data()
    {
        $user = $this->model->auth(2);

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
        $total = $this->model->get('count(id) as total','clients', $where)->total;

        // Obtener registros con paginación
        $rows = $this->model->list('*', 'clients', "$where ORDER BY $orderBy LIMIT $offset, $size");

        $data = [];

        foreach ($rows as $r) {
            $contacts = '<table class="min-w-full divide-y divide-gray-200 border border-gray-300">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-2 text-left text-xs text-gray-500 tracking-wider border border-gray-300">Nombre</th>
                    <th class="px-2 text-left text-xs text-gray-500 tracking-wider border border-gray-300">Email</th>
                    <th class="px-2 text-left text-xs text-gray-500 tracking-wider border border-gray-300">Teléfono</th>
                    <th class="px-2 text-left text-xs text-gray-500 tracking-wider border border-gray-300">Área</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">';
            foreach (json_decode($r->contacts) as $c) {
                $contacts .= '<tr>
                    <td class="px-2 text-xs whitespace-nowrap border border-gray-300">' . htmlspecialchars($c[0]) . '</td>
                    <td class="px-2 text-xs whitespace-nowrap border border-gray-300">' . htmlspecialchars($c[1]) . '</td>
                    <td class="px-2 text-xs whitespace-nowrap border border-gray-300">' . htmlspecialchars($c[2]) . '</td>
                    <td class="px-2 text-xs whitespace-nowrap border border-gray-300">' . htmlspecialchars($c[3]) . '</td>
                </tr>';
            }
            $contacts .= '</tbody></table>';
            $action = "<a hx-get='?c=Clients&a=New&id=$r->id' hx-target='#myModal' @click='showModal = true' class='text-gray-900 hover:text-gray-700 cursor-pointer mx-3'><i class='ri-edit-2-line text-lg'></i></a>";
            if (in_array($r->id, [1])) {
                $b1 = '';
            }
            $data[] = [
                'id' => $r->id,
                'created_at' => $r->created_at,
                'company' => $r->company,
                'city' => $r->city,
                'contacts' => $contacts,
                'action' => $action
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
        $user = $this->model->auth(2);
    
        if (!empty($_REQUEST['id'])) {
        $filters = "and id = " . $_REQUEST['id'];
        $id = $this->model->get('*','clients', $filters);
        }
        require_once 'app/views/clients/new.php';
    }

    public function Save()
    {
        $user = $this->model->auth(2);
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
        if (!empty($_POST['id'])) {
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
        
        $table = 'clients';

        $item = new stdClass();
        foreach($_POST as $k => $val) {
            if (!empty($val)) {
                if($k != 'id') {
                    $item->{$k} = $val;
                }
            }
        }
        if (empty($_POST['id'])) {
            $id = $this->model->save($table,$item);
            if ($id !== false) {
                $message = '{"type": "success", "message": "Cliente Guardado", "close" : "closeNewModal"}';
                $hxTriggerData = json_encode([
                    "listChanged" => true,
                    "showMessage" => $message
                ]);
                header('HX-Trigger: ' . $hxTriggerData);
                http_response_code(204);
            }
        } else {
            $id = $this->model->update($table,$item,$_POST['id']);
            if ($id !== false) {
                $message = '{"type": "success", "message": "Cliente Actualizado", "close" : "closeNewModal"}';
                $hxTriggerData = json_encode([
                    "tableChanged" => true,
                    "showMessage" => $message
                ]);
                header('HX-Trigger: ' . $hxTriggerData);
                http_response_code(204);
            }
        }
    }

}