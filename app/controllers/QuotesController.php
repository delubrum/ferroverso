<?php
require_once 'app/models/model.php';

class QuotesController
{
    private $model;

    public function __CONSTRUCT()
    {
        $this->model = new Model();
    }

    public function Index()
    {
        $user = $this->model->auth(4);
        
        $tabulator = true;
        $title = "Cotizaciones / Registro";
        $button = 'Nueva Cotización';
        $content = 'app/components/list.php';

        // { "title": "Acción", "field": "action",  formatter: "html", hozAlign: "center", headerHozAlign: "center", width: 100, }
        $columns = '[
            { "title": "ID", "field": "id", headerHozAlign: "center", headerFilter:"input" },
            { "title": "Fecha", "field": "created_at", headerHozAlign: "center", headerFilter: customDateRangeFilter, headerFilterFunc: customDateFilterFunc, headerFilterLiveFilter: false, },
            { "title": "Asesor", "field": "user_id", headerHozAlign: "center", headerFilter:"input" },
            { "title": "Cliente", "field": "client_id", headerHozAlign: "center", headerFilter:"input" },
            { "title": "Obra", "field": "project", headerHozAlign: "center", headerFilter:"input" },
            { "title": "Valor", "field": "amount", headerHozAlign: "center", headerFilter:"input", hozAlign:"right", },
            { "title": "AUI", "field": "aui", headerHozAlign: "center", headerFilter:"input", hozAlign:"right", },
            { "title": "Valor Total", "field": "total", headerHozAlign: "center", headerFilter:"input", hozAlign:"right", },
            { "title": "Estado", "field": "status", headerHozAlign: "center", headerFilter:"list", hozAlign:"center", headerFilterParams:{ values: {"Pendiente": "Pendiente", "Aprobada": "Aprobada", "Rechazada": "Rechazada"}, clearable:true}, },
        ]';
        require_once 'app/views/index.php';
    }

    public function Kanban()
    {
        $user = $this->model->auth(4);
        
        $tabulator = true;
        $title = "Cotizaciones / Registro";
        $button = 'Nueva Cotización';
        $content = 'app/components/kanban.php';
        require_once 'app/views/index.php';
    }

    public function Data()
    {
        $user = $this->model->auth(4);

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
        $total = $this->model->get('count(id) as total','quotes', $where)->total;

        // Obtener registros con paginación
        $rows = $this->model->list('*', 'quotes', "$where ORDER BY $orderBy LIMIT $offset, $size");

        $data = [];

        foreach ($rows as $r) {
            $data[] = [
                'id' => $r->id,
                'created_at' => $r->created_at,
                'client_id' => $r->client_id,
                'user_id' => $r->user_id,
                'project' => $r->project,
                'amount' => '$' . number_format($r->amount, 0),
                'aui' => '$' . number_format($r->aui, 0),
                'total' => '$' . number_format($r->amount + $r->aui, 0),
                'status' => $r->status,
                // 'action' => "<a hx-get='?c=Quotes&a=New&id=$r->id' hx-target='#myModal' @click='showModal = true' class='text-gray-900 hover:text-gray-700 cursor-pointer'><i class='ri-edit-2-line'></i></a>"
            ];
        }

        echo json_encode([
            "data" => $data,
            "last_page" => ceil($total / $size),
            "last_row" => $total
        ]);
    }

    public function KanbanData()
    {
        echo json_encode($this->model->list('*','quotes'));
    }


    public function New()
    {
        $user = $this->model->auth(4);

        if (!empty($_REQUEST['id'])) {
            $filters = "and id = " . $_REQUEST['id'];
            $id = $this->model->get('*', 'quotes', $filters);
        }
        require_once 'app/views/quotes/new.php';
    }

    public function Stats()
    {
        $user = $this->model->auth(4); // Autenticación o permisos

        $where = ""; // Para que los AND se acumulen bien

        // Verificar si vienen filtros tipo filter[status]=Aprobada
        if (isset($_GET['filter']) && is_array($_GET['filter'])) {
            foreach ($_GET['filter'] as $field => $value) {
                $field = addslashes($field);
                $value = addslashes($value);

                // Filtro por rango de fechas
                if ($field === 'created_at' && strpos($value, ' to ') !== false) {
                    list($from, $to) = explode(' to ', $value);
                    $where .= " AND DATE(created_at) BETWEEN '$from' AND '$to'";
                } else {
                    $where .= " AND `$field` LIKE '%$value%'";
                }
            }
        }

        // Ejemplo de KPIs
        $total = $this->model->get('COUNT(id) as total', 'quotes', $where)->total;
        $projects = $this->model->get('count(DISTINCT(project)) as total', 'quotes', $where)->total;
        $amount = number_format($this->model->get('sum(amount+aui) as total', 'quotes', $where)->total/ 1000,0);
        $aprobadas = $this->model->get('COUNT(id) as total', 'quotes', "$where AND status = 'Aprobada'")->total;
        $pendientes = $this->model->get('COUNT(id) as total', 'quotes', "$where AND status = 'Pendiente'")->total;
        $rechazadas = $this->model->get('COUNT(id) as total', 'quotes', "$where AND status = 'Rechazada'")->total;

        // Renderizar vista parcial
        require_once 'app/views/quotes/stats.php';
    }


    public function Detail()
    {
        $user = $this->model->auth(4);

        if (!empty($_REQUEST['id'])) {
            $filters = "and id = " . $_REQUEST['id'];
            $id = $this->model->get('*', 'quotes', $filters);
        }
        require_once 'app/views/quotes/detail.php';
    }

    public function DetailTab()
    {
        $user = $this->model->auth(4);
        $tab = $_REQUEST['tab'];
        $filters = "and id = " . $_REQUEST['id'];
        $id = $this->model->get('*', 'quotes', $filters);
        require_once "app/views/quotes/detail/tabs/$tab.php";
    }

        public function DetailModal()
    {
        $user = $this->model->auth(4);
        $modal = $_REQUEST['modal'];
        $filters = "and id = " . $_REQUEST['id'];
        $id = $this->model->get('*', 'quotes', $filters);
        require_once "app/views/quotes/detail/modals/$modal.php";
    }

    public function Save()
    {
        $user = $this->model->auth(4);

        header('Content-Type: application/json');

        $project = $_POST['project'];
        if ($this->model->get('id', 'quotes', "and project = '$project'")) {
            $hxTriggerData = json_encode([
                "showMessage" => '{"type": "error", "message": "Ya existe un proyecto con el nombre que intentas usar", "close" : ""}'
            ]);
            header('HX-Trigger: ' . $hxTriggerData);
            http_response_code(409);
            exit;
        }

        $item = new stdClass();
        $table = 'quotes';

        foreach($_POST as $k => $val) {
            if (!empty($val)) {
            if($k != 'id') {
                $item->{$k} = $val;
            }
            }
        }

        $item->user_id = $_SESSION["id-APP"];

        $id = empty($_POST['id'])
            ? $this->model->save($table, $item)
            : $this->model->update($table, $item, $_POST['id']);

        if ($id !== false) {
            $message = empty($_POST['id'])
                ? '{"type": "success", "message": "Cotización Guardada", "close" : "closeNewModal"}'
                : '{"type": "success", "message": "Cotización Actualizada", "close" : "closeNewModal"}';

            $hxTriggerData = json_encode([
                "listChanged" => true,
                "showMessage" => $message
            ]);
            header('HX-Trigger: ' . $hxTriggerData);
            http_response_code(204);
        }
    }

    public function Indicators()
    {
        $user = $this->model->auth(4);

        $in = isset($_REQUEST['in']) ? $_REQUEST['in'] : 1;
        $year = !empty($_REQUEST['year']) ? $_REQUEST['year'] : date('Y');
        $date = $year . "-01-01";

        $quotes = $this->model->list(
            "UPPER(status) as status, DATE_FORMAT(created_at, '%b') as month, COUNT(*) as total",
            "quotes",
            "and YEAR(created_at) = '$date' GROUP BY created_at, status ORDER BY MONTH(created_at)",
            ""
        );

        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $quotes_by_month = [];

        foreach ($months as $month) {
            $quotes_by_month[$month] = [
                'total'     => 0,
                'ganados'   => 0,
                'perdidos'  => 0,
                'pendientes'=> 0
            ];
        }

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
    }
}
