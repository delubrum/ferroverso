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
        $columns = '[
            { "title": "code", "field": "id", visible: false },
            { "title": "ID", "field": "code", headerHozAlign: "center", headerFilter:"input" },
            { "title": "Fecha", "field": "created_at", headerHozAlign: "center", headerFilter: customDateRangeFilter, headerFilterFunc: customDateFilterFunc, headerFilterLiveFilter: false, },
            { "title": "Asesor", "field": "username", headerHozAlign: "center", headerFilter:"input" },
            { "title": "Cliente", "field": "company", headerHozAlign: "center", headerFilter:"input" },
            { "title": "Obra", "field": "project", headerHozAlign: "center", headerFilter:"input" },
            { "title": "Valor", "field": "amount", headerHozAlign: "center", headerFilter:"input", hozAlign:"right", },
            { "title": "AUI", "field": "aui", headerHozAlign: "center", headerFilter:"input", hozAlign:"right", },
            { "title": "Valor Total", "field": "total", headerHozAlign: "center", headerFilter:"input", hozAlign:"right", },
            { "title": "Fecha Estado", "field": "status_at", headerHozAlign: "center", headerFilter: customDateRangeFilter, headerFilterFunc: customDateFilterFunc, headerFilterLiveFilter: false, },
            { "title": "Estado", "field": "status", headerHozAlign: "center", headerFilter:"list", hozAlign:"center", headerFilterParams:{ values: {"costeo": "Costeo", "seguimiento": "Seguimiento", "modificada": "Modificada", "ganada": "Ganada", "perdida": "Perdida"}, clearable:true}, },
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

        // Mapeo seguro de campos frontend => SQL
        $fieldMap = [
            'id' => 'q.id',
            'code' => 'q.code',
            'created_at' => 'q.created_at',
            'username' => 'u.username',
            'company' => 'c.company',
            'project' => 'q.project',
            'amount' => 'q.amount',
            'aui' => 'q.aui',
            'status_at' => 'q.status_at',
            'status' => 'q.status',
        ];

        $where = '';

        if (isset($_GET['filter']) && is_array($_GET['filter'])) {
            foreach ($_GET['filter'] as $f) {
                if (!isset($f['field'], $f['value'])) continue;

                $field = $f['field'];
                $value = addslashes($f['value']);

                if (!isset($fieldMap[$field])) continue;

                $dbField = $fieldMap[$field];

                if (($field === 'created_at' || $field === 'status_at') && strpos($value, ' to ') !== false) {
                    list($from, $to) = explode(' to ', $value);
                    $where .= " AND DATE($dbField) BETWEEN '$from' AND '$to'";
                } else {
                    $where .= " AND $dbField LIKE '%$value%'";
                }
            }
        }

        $orderBy = "q.id DESC";

        if (isset($_GET['sort'][0]['field']) && isset($_GET['sort'][0]['dir'])) {
            $sortField = $_GET['sort'][0]['field'];
            $sortDir = strtoupper($_GET['sort'][0]['dir']) === 'ASC' ? 'ASC' : 'DESC';

            if (isset($fieldMap[$sortField])) {
                $orderBy = $fieldMap[$sortField] . " $sortDir";
            }
        }

        // Select fields from map (sin duplicados)
        $selectFields = implode(', ', array_unique($fieldMap));

        // Total de registros (se necesita también el JOIN aquí)
        $total = $this->model->get('count(q.id) as total', 'quotes q', $where, 'LEFT JOIN clients c on q.client_id = c.id LEFT JOIN users u on q.user_id = u.id')->total;

        // Datos con paginación
        $rows = $this->model->list(
            $selectFields,
            'quotes q',
            "$where ORDER BY $orderBy LIMIT $offset, $size",
            'LEFT JOIN clients c on q.client_id = c.id LEFT JOIN users u on q.user_id = u.id'
        );

        $data = [];

        foreach ($rows as $r) {
            $data[] = [
                'id' => $r->id,
                'code' => $r->code,
                'created_at' => $r->created_at,
                'company' => $r->company,
                'username' => $r->username,
                'project' => $r->project,
                'amount' => '$' . number_format($r->amount, 0),
                'aui' => '$' . number_format($r->aui, 0),
                'total' => '$' . number_format($r->amount + $r->aui, 0),
                'status_at' => $r->status_at,
                'status' => ucwords($r->status),
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
        echo json_encode($this->model->list('q.*,u.username, c.company', 'quotes q','',"LEFT JOIN users u on q.user_id = u.id LEFT JOIN clients c on q.client_id = c.id"));
    }


    public function New()
    {
        $user = $this->model->auth(4);

        if (!empty($_REQUEST['id'])) {
            $filters = "and id = " . $_REQUEST['id'];
            $id = $this->model->get('*', 'quotes', $filters);
        }
        $status = (!empty($_REQUEST['status'])) ? $_REQUEST['status'] : false;
        require_once 'app/views/quotes/new.php';
    }

    public function Stats()
    {
        $user = $this->model->auth(4);

        // Mapeo de campos permitidos y sus aliases
        $fieldMap = [
            'id' => 'q.id',
            'created_at' => 'q.created_at',
            'company' => 'c.company',
            'username' => 'u.username',
            'project' => 'q.project',
            'status' => 'q.status',
            'amount' => 'q.amount',
            'aui' => 'q.aui',
        ];

        $where = "";

        // Filtros
        if (isset($_GET['filter']) && is_array($_GET['filter'])) {
            foreach ($_GET['filter'] as $field => $value) {
                if (!isset($fieldMap[$field])) continue;

                $dbField = $fieldMap[$field];
                $value = addslashes($value);

                if ($field === 'created_at' && strpos($value, ' to ') !== false) {
                    list($from, $to) = explode(' to ', $value);
                    $where .= " AND DATE($dbField) BETWEEN '$from' AND '$to'";
                } else {
                    $where .= " AND $dbField LIKE '%$value%'";
                }
            }
        }

        // Reutilizamos el JOIN de Data()
        $join = 'LEFT JOIN clients c ON q.client_id = c.id LEFT JOIN users u ON q.user_id = u.id';

        // Consultas
        $total = $this->model->get('COUNT(q.id) as total', 'quotes q', $where, $join)->total;
        $projects = $this->model->get('COUNT(DISTINCT(q.project)) as total', 'quotes q', $where, $join)->total;
        $amount = number_format($this->model->get('SUM(q.amount + q.aui) as total', 'quotes q', $where, $join)->total / 1000, 0);
        $costeo = $this->model->get('COUNT(q.id) as total', 'quotes q', "$where AND q.status = 'costeo'", $join)->total;
        $seguimiento = $this->model->get('COUNT(q.id) as total', 'quotes q', "$where AND q.status = 'seguimiento'", $join)->total;
        $ganadas = $this->model->get('COUNT(q.id) as total', 'quotes q', "$where AND q.status = 'ganada'", $join)->total;

        // Renderizar vista
        require_once 'app/views/quotes/stats.php';
    }

    public function StatsKanban()
    {
        $user = $this->model->auth(4);

        $costeo = $this->model->get('COUNT(q.id) as total', 'quotes q', "AND q.status = 'costeo'")->total;
        $seguimiento = $this->model->get('COUNT(q.id) as total', 'quotes q', "AND q.status = 'seguimiento'")->total;
        $seguimiento_amount = number_format($this->model->get('SUM(q.amount + q.aui) as total', 'quotes q',"AND q.status = 'seguimiento'")->total / 1000, 0);
        $ganadas = $this->model->get('COUNT(q.id) as total', 'quotes q', "AND q.status = 'ganada'")->total;
        $ganadas_amount = number_format($this->model->get('SUM(q.amount + q.aui) as total', 'quotes q',"AND q.status = 'ganada'")->total / 1000, 0);
        $perdidas = $this->model->get('COUNT(q.id) as total', 'quotes q', "AND q.status = 'perdida'")->total;
        $perdidas_amount = number_format($this->model->get('SUM(q.amount + q.aui) as total', 'quotes q',"AND q.status = 'perdida'")->total / 1000, 0);

        // Renderizar vista
        require_once 'app/views/quotes/stats-kanban.php';
    }

    public function Detail()
    {
        $user = $this->model->auth(4);

        if (!empty($_REQUEST['id'])) {
            $filters = "and q.id = " . $_REQUEST['id'];
            $id = $this->model->get('q.*,u.username, c.company', 'quotes q', $filters, "LEFT JOIN users u on q.user_id = u.id LEFT JOIN clients c on q.client_id = c.id");
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

        $table = 'quotes';
        
        $item = new stdClass();
        foreach($_POST as $k => $val) {
            if (!empty($val)) {
                if($k != 'id') {
                    $item->{$k} = $val;
                }
            }
        }

        $item->user_id = $_SESSION["id-APP"];

        if (empty($_POST['id'])) {
            $item->code = floor($this->model->get('code','quotes',' ORDER BY code DESC LIMIT 1')->code + 1);
            $id = $this->model->save($table, $item);
            $text = 'Creada';
        } else {
            if ($_POST['status'] == 'modificada') {
                $id = $_POST['id'];
                $item->amount = $this->model->get('amount','quotes'," and id = $id")->amount;
                $item->aui = $this->model->get('aui','quotes'," and id = $id")->aui;
            }
            if ($_POST['status'] == 'seguimiento') {
                $item->quote_at = date("Y-m-d H:i:s");
            }
            $item->status_at = date("Y-m-d H:i:s");
            $id = $this->model->update($table, $item, $_POST['id']);
            $text = 'Actualizada';
        }

        $comment = new stdClass();
        $comment->user_id = $_SESSION["id-APP"];
        $comment->quote_id = $id;
        $comment->notes = "<b>Cotización $text || " . ucwords($_POST['status']) . "<br>
        <b>Notas:</b> " . $_POST['notes'] . "<br>
        <b>Data:</b> " . json_encode($_POST);
        $this->model->save('quote_comments', $comment);

        if ($_POST['status'] == 'modificada') {
            $id = $_POST['id'];
            $item->client_id = $this->model->get('client_id','quotes'," and id = $id")->client_id;
            $item->project = $this->model->get('project','quotes'," and id = $id")->project;
            $item->status = 'seguimiento';
            $item->amount = $_POST['amount'];
            $item->aui = $_POST['aui'];
            $last = $this->model->get('code', 'quotes', " and id = $id");
            if ($last && isset($last->code)) {
                $code = $last->code;

                if (strpos($code, '.') == false) {
                    // Es entero, como 473 → empieza con .01
                    $newCode = $code . '.01';
                } else {
                    // Tiene punto decimal, como 473.01
                    $parts = explode('.', $code);
                    $base = $parts[0];
                    $decimal = str_pad((int)$parts[1] + 1, 2, '0', STR_PAD_LEFT); // Aumenta y mantiene 2 dígitos
                    $newCode = $base . '.' . $decimal;
                }

                $item->code = $newCode;
            }

            $id = $this->model->save($table, $item);
        }

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

    public function SaveComment()
    {
        $user = $this->model->auth(4);
        $table = 'quote_comments';
        $item = new stdClass();
        $item->quote_id = $_REQUEST['quote_id'];
        $item->notes = $_REQUEST['notes'];
        $item->user_id = $_SESSION["id-APP"];
        $id = $this->model->save($table, $item);
        if ($id !== false) {
            $message = '{"type": "success", "message": "Comentario Guardado", "close" : ""}';
            $hxTriggerData = json_encode([
                "showMessage" => $message
            ]);
            header('HX-Trigger: ' . $hxTriggerData);
            http_response_code(204);
        }
    }

    public function GetComments() 
    {
        $user = $this->model->auth(4);
        $id = $_REQUEST['id'] ?? null;
        $search = $_REQUEST['search'] ?? null;
        $page = (int) ($_REQUEST['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $columnNames = ['a.id', 'a.created_at', 'a.notes', 'u.username', 'a.quote_id'];
        $where = '';

        if ($search) {
            $searchValue = addslashes($search);
            $searchParts = [];
            foreach ($columnNames as $colName) {
                $searchParts[] = "$colName LIKE '%$searchValue%'";
            }
            $where .= " AND (" . implode(" OR ", $searchParts) . ")";
        }

        $array = $this->model->list(implode(", ",$columnNames), 'quote_comments a'," $where and quote_id = $id ORDER BY id DESC LIMIT $limit OFFSET $offset", 'LEFT JOIN users u ON a.user_id = u.id');
        $page++;
        include "app/views/quotes/detail/tabs/comment-list.php";
    }

    public function Indicators()
    {
        $user = $this->model->auth(4);

        $year = !empty($_REQUEST['year']) ? $_REQUEST['year'] : date('Y');

        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $quotes_by_month = [];

        // Inicializar array de resultados con todos los meses
        foreach ($months as $month) {
            $quotes_by_month[$month] = [
                'total' => 0,
                'total_value' => 0,

                'costeo' => 0,
                'costeo_value' => 0,

                'seguimiento' => 0,
                'seguimiento_value' => 0,

                'ganadas' => 0,
                'ganadas_value' => 0,

                'perdidas' => 0,
                'perdidas_value' => 0,

                'modificadas' => 0,
                'modificadas_value' => 0
            ];
        }

        // Total: por created_at
        $quotes = $this->model->list(
            "DATE_FORMAT(created_at, '%b') as month, 
            COUNT(*) as total, 
            SUM(COALESCE(amount,0) + COALESCE(aui,0)) as total_value",
            "quotes",
            "AND YEAR(created_at) = '$year' GROUP BY month",
            ""
        );
        foreach ($quotes as $q) {
            $quotes_by_month[$q->month]['total'] = (int) $q->total;
            $quotes_by_month[$q->month]['total_value'] = (float) $q->total_value;
        }

        // Costeo: por created_at
        $costeo = $this->model->list(
            "DATE_FORMAT(created_at, '%b') as month, 
            COUNT(*) as total, 
            SUM(COALESCE(amount,0) + COALESCE(aui,0)) as total_value",
            "quotes",
            "AND status = 'costeo' AND YEAR(created_at) = '$year' GROUP BY month",
            ""
        );
        foreach ($costeo as $q) {
            $quotes_by_month[$q->month]['costeo'] = (int) $q->total;
            $quotes_by_month[$q->month]['costeo_value'] = (float) $q->total_value;
        }

        // Seguimiento: por quote_at
        $seguimiento = $this->model->list(
            "DATE_FORMAT(quote_at, '%b') as month, 
            COUNT(*) as total, 
            SUM(COALESCE(amount,0) + COALESCE(aui,0)) as total_value",
            "quotes",
            "AND status = 'seguimiento' AND quote_at IS NOT NULL AND YEAR(quote_at) = '$year' GROUP BY month",
            ""
        );
        foreach ($seguimiento as $q) {
            $quotes_by_month[$q->month]['seguimiento'] = (int) $q->total;
            $quotes_by_month[$q->month]['seguimiento_value'] = (float) $q->total_value;
        }

        // Estados finales: ganadas, perdidas, modificadas por status_at
        $finales = $this->model->list(
            "DATE_FORMAT(status_at, '%b') as month,
            SUM(status = 'ganada') as ganadas,
            SUM(CASE WHEN status = 'ganada' THEN COALESCE(amount,0) + COALESCE(aui,0) ELSE 0 END) as ganadas_value,

            SUM(status = 'perdida') as perdidas,
            SUM(CASE WHEN status = 'perdida' THEN COALESCE(amount,0) + COALESCE(aui,0) ELSE 0 END) as perdidas_value,

            SUM(status = 'modificada') as modificadas,
            SUM(CASE WHEN status = 'modificada' THEN COALESCE(amount,0) + COALESCE(aui,0) ELSE 0 END) as modificadas_value",
            "quotes",
            "AND status IN ('ganada','perdida','modificada') AND YEAR(status_at) = '$year' GROUP BY month",
            ""
        );
        foreach ($finales as $q) {
            $quotes_by_month[$q->month]['ganadas'] = (int) $q->ganadas;
            $quotes_by_month[$q->month]['ganadas_value'] = (float) $q->ganadas_value;

            $quotes_by_month[$q->month]['perdidas'] = (int) $q->perdidas;
            $quotes_by_month[$q->month]['perdidas_value'] = (float) $q->perdidas_value;

            $quotes_by_month[$q->month]['modificadas'] = (int) $q->modificadas;
            $quotes_by_month[$q->month]['modificadas_value'] = (float) $q->modificadas_value;
        }

        require_once 'app/views/quotes/indicators/indicators.php';
    }

}
