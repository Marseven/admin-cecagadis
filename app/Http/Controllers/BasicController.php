<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

define('STATUT_RECEIVE', 0);     // Largeur max de l'image en pixels
define('STATUT_PENDING', 1);
define('STATUT_APPROVE', 2);     // Largeur max de l'image en pixels
define('STATUT_PAID', 3);
define('STATUT_DO', 4);

define('STATUT_ENABLE', 5);
define('STATUT_DISABLE', 6);

define('STATUT_SIMULATOR', 11);
define('STATUT_FAILED', 12);
define('STATUT_REFUSED', 13);
define('STATUT_CANCEL', 14);
define('STATUT_REFUND', 15);
define('STATUT_REGULAR', 16);

define('STATUT_SEND', 17);

class BasicController extends Controller
{
    //
    public function str_random($length)
    {
        $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
    }

    static function delais($date_create)
    {
        $firstDate  = new \DateTime(date('Y-m-d'));
        $secondDate = new \DateTime($date_create);
        $result = $firstDate->diff($secondDate);

        return $result->days;
    }

    static function delais_end($date_end)
    {
        $firstDate  = new \DateTime(date('Y-m-d'));
        $secondDate = new \DateTime($date_end);
        $result = $firstDate->diff($secondDate);

        if ($result->days > 5) {
            return false;
        } else {
            return true;
        }
    }

    static function delais_month($date_create)
    {
        $firstDate  = new \DateTime(date('Y-m-d'));
        $secondDate = new \DateTime($date_create);
        $result = $firstDate->diff($secondDate);
        return $result->m;
    }

    static function delais_hour($date_create)
    {
        $firstDate  = new \DateTime(date('Y-m-d H:s:i'));
        $secondDate = new \DateTime($date_create);
        $result = $firstDate->diff($secondDate);
        return $result->h;
    }

    static function age($date_create)
    {
        $firstDate  = new \DateTime(date('Y-m-d'));
        $secondDate = new \DateTime($date_create);
        $result = $firstDate->diff($secondDate);

        return $result->y;
    }

    static function formatPhone($num)
    {
        if (preg_match("#^0[6-7][0-7]([-. ]?[0-9]{2}){3}$#", $num)) {
            $meta_carac = array("-", ".", " ");
            $num = str_replace($meta_carac, "", $num);
            return $num;
        }

        return false;
    }

    static function status($status)
    {
        switch ($status) {
            case STATUT_RECEIVE:
                $message['type'] = "primary";
                $message['message'] = "Reçue";
                return $message;
                break;
            case STATUT_PENDING:
                $message['type'] = "warning";
                $message['message'] = "En cours";
                return $message;
                break;
            case STATUT_APPROVE:
                $message['type'] = "success";
                $message['message'] = "Approuvée";
                return $message;
                break;
            case STATUT_REFUSED:
                $message['type'] = "danger";
                $message['message'] = "Refusée";
                return $message;
                break;
            case STATUT_CANCEL:
                $message['type'] = "danger";
                $message['message'] = "Annulée";
                return $message;
                break;
            case STATUT_PAID:
                $message['type'] = "secondary";
                $message['message'] = "Payée";
                return $message;
                break;
            case STATUT_DO:
                $message['type'] = "success";
                $message['message'] = "Traitée";
                return $message;
                break;
            case STATUT_ENABLE:
                $message['type'] = "success";
                $message['message'] = "Actif";
                return $message;
                break;
            case STATUT_DISABLE:
                $message['type'] = "danger";
                $message['message'] = "Désactivé";
                return $message;
                break;
            case STATUT_SIMULATOR:
                $message['type'] = "info";
                $message['message'] = "Simulation";
                return $message;
                break;
            case STATUT_FAILED:
                $message['type'] = "danger";
                $message['message'] = "Échouée";
                return $message;
                break;
            case STATUT_REFUND:
                $message['type'] = "danger";
                $message['message'] = "Remboursée";
                return $message;
                break;
            case STATUT_REGULAR:
                $message['type'] = "warning";
                $message['message'] = "À Régularisé";
                return $message;
                break;
        }
    }

    static function month($month)
    {
        switch ($month) {
            case 1:
                $message = "Jan";
                return $message;
                break;
            case 2:
                $message = "Fev";
                return $message;
                break;
            case 3:
                $message = "Mar";
                return $message;
                break;
            case 4:
                $message = "Avr";
                return $message;
                break;
            case 5:
                $message = "Mai";
                return $message;
                break;
            case 6:
                $message = "Jui";
                return $message;
                break;
            case 7:
                $message = "Juil";
                return $message;
                break;
            case 8:
                $message = "Aou";
                return $message;
                break;
            case 9:
                $message = "Sept";
                return $message;
                break;
            case 10:
                $message = "Oct";
                return $message;
                break;
            case 11:
                $message = "Nov";
                return $message;
                break;
            case 12:
                $message = "Dec";
                return $message;
                break;
        }
    }

    static function request_status()
    {
        $option = '<option value="' . STATUT_RECEIVE . '">Reçu</option>';
        $option .= '<option value="' . STATUT_PENDING . '">En cours de traitement</option>';
        $option .= '<option value="' . STATUT_DO . '">Traité</option>';
        $option .= '<option value="' . STATUT_REFUSED . '">Refusé</option>';
        $option .= '<option value="' . STATUT_REGULAR . '">À Régularisé</option>';
        $option .= '<option value="' . STATUT_REFUND . '">Remboursée</option>';
        $option .= '<option value="' . STATUT_CANCEL . '">Annulé</option>';

        return $option;
    }

    static function enable_status()
    {
        print '<option value="' . STATUT_ENABLE . '">Actif</option>';
        print '<option value="' . STATUT_DISABLE . '">Inactif</option>';
    }

    static function he_can($controller, $action)
    {
        $user = Auth::user();
        $rolepermissions = DB::table('security_role_permission')
            ->join('security_permissions', 'security_permissions.id', '=', 'security_role_permission.security_permission_id')
            ->select('security_role_permission.*', 'security_permissions.*')
            ->where('security_role_permission.security_role_id', $user->security_role_id)
            ->get();

        foreach ($rolepermissions as $permission) {

            if ($permission->name == $controller) {

                switch ($action) {
                    case 'look':
                        if ($permission->look != "on") {

                            return redirect('logout')->with('error', "Vous n'avez pas le droit de faire cette action.");
                        }
                        break;
                    case 'creat':
                        if ($permission->creat != "on") {

                            return redirect('logout')->with('error', "Vous n'avez pas le droit de faire cette action.");
                        }
                        break;
                    case 'updat':
                        if ($permission->updat != "on") {

                            return redirect('logout')->with('error', "Vous n'avez pas le droit de faire cette action.");
                        }
                        break;
                    case 'del':
                        if ($permission->del != "on") {

                            return redirect('logout')->with('error', "Vous n'avez pas le droit de faire cette action.");
                        }
                        break;
                }
            }
        }
    }

    /**
     * Update Laravel Env file Key's Value
     * @param string $key
     * @param string $value
     */
    public static function envUpdate($key, $value)
    {
        $path = base_path('.env');

        if (is_bool(env($key))) {
            $old = env($key) ? 'true' : 'false';
            $value = $value  ? 'true' : 'false';
        }

        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                "$key=" . $old,
                "$key=" . $value,
                file_get_contents($path)
            ));
        }
    }

    public function add_visite($user)
    {
        // On prépare les données à insérer
        $ip   = $_SERVER['REMOTE_ADDR']; // L'adresse IP du visiteur
        $date = date('Y-m-d');           // La date d'aujourd'hui, sous la forme AAAA-MM-JJ

        if ($user) {
            $user = $user->id;
            $visit = DB::insert(" INSERT INTO visites (ip , date_visite, user, pages_vues) VALUES (:ip , :date,  :user, 1)
        ON DUPLICATE KEY UPDATE pages_vues = pages_vues + 1", [':ip'   => $ip, ':date' => $date, ':user' => $user]);
        } else {
            $visit = DB::insert(" INSERT INTO visites (ip , date_visite, pages_vues) VALUES (:ip , :date , 1)
        ON DUPLICATE KEY UPDATE pages_vues = pages_vues + 1", [':ip'   => $ip, ':date' => $date]);
        }

        // Mise à jour de la base de données
        return $visit;
    }

    public function nbre_visite()
    {
        // On prépare les données à insérer
        $ip   = $_SERVER['REMOTE_ADDR']; // L'adresse IP du visiteur
        $date = date('Y-m-d');           // La date d'aujourd'hui, sous la forme AAAA-MM-JJ

        // Mise à jour de la base de données
        $visites = DB::select('select * from visites');

        return sizeof($visites);
    }

    protected  $model;

    /**
     * GenericController constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getListView($view_params = null)
    {

        $view_data = ['model' => $this->model];

        if ($view_params != null) {
            while ($key = key($view_params)) {
                $view_data[$key] = $view_params[$key];
                next($view_params);
            }
        }

        return view($this->model->getViewList(), $view_data);
    }

    public function _showForm(Request $request, $parent_id = null, $_id = null)
    {
        if ($_id == null)  $_id = $parent_id;
        $model_class = get_class($this->model);
        if ($_id != null) {
            $this->model = $model_class::find($_id);
        }
        $titles = array_values($this->model->getFields());
        $columns = array_keys($this->model->getFields());

        return view($this->model->getViewForm(), ['titles' => $titles, 'columns' => $columns, 'model' => $this->model]);
    }

    public function _create($request)
    {
        $primaryKey = $this->model->getPrimaryKey();
        $model_class = get_class($this->model);
        $methode_v = $this->model->getValidateMethode();
        $v = $model_class::$methode_v($request);


        if (!$v->passes()) {
            return redirect()->back()->withErrors($v)->withInput();
        }

        $fields = $this->model->getFields();
        $belongsTos = $this->model->getBelongsTo();
        $belongsToManys = $this->model->getBelongsToMany();
        $otherModels = $this->model->getOtherModels();

        while ($field = key($fields)) {
            if (!in_array($field, array_keys($belongsTos)) && !in_array($field, array_keys($belongsToManys)) && !in_array($field, $this->model->getHiddens()) && !in_array($field, $this->model->getFieldsHiddens())) {
                if (in_array($field, $this->model->getFiles()) || in_array($field, $this->model->getImages())) {
                    if ($request->hasFile($field)) {
                        $imagefile = $request->file($field);
                        $ext = $imagefile->getClientOriginalExtension();
                        $file = uniqid() . '.' . $ext;
                        $imagefile->move($this->model->getUploadsFolder(), $file);
                        $this->model->$field = $this->model->getUploadsFolder() . $file;
                    } elseif ($this->model->$primaryKey != null && $request->has('old_' . $field)) {
                        $this->model->$field = null;
                    }
                } elseif (in_array($field, $this->model->getPasswords())) {
                    if ($request->get($field) != '' && $request->has($field)) $this->model->$field = Hash::make($request->get($field));
                } elseif (in_array($field, array_keys($this->model->getSelectsMultiple()))) {
                    $str = '';
                    if ($request->has($field)) {
                        foreach ($request->get($field) as $data) {
                            $str .= '~' . $data;
                        }
                        $this->model->$field = $str;
                    }
                } elseif (in_array($field, $this->model->getDates())) {
                    if ($request->has($field) && !empty($request->get($field))) {
                        $this->model->$field =  date('Y-m-d', strtotime(str_replace('/', '-', $request->get($field))));
                    }
                } elseif (in_array($field, $this->model->getDatetimes())) {
                    if ($request->has($field) && !empty($request->get($field))) {
                        $this->model->$field =  date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->get($field))));
                    }
                } else {
                    if ($request->has($field))
                        $this->model->$field = $request->get($field);
                    else
                        $this->model->$field = null;
                }
            }
            next($fields);
        }

        foreach ($belongsTos as $belongsTo => $references) {
            if (!in_array($belongsTo, $this->model->getFieldsHiddens()) && in_array($belongsTo, array_keys($fields))) {
                $fkKey = $references[1];
                $this->model->$fkKey = $request->get($fkKey);
            }
        }


        if ($this->model->save()) {

            foreach ($belongsToManys as $belongsToMany => $references) {
                if (!in_array($belongsToMany, $this->model->getFieldsHiddens()) && in_array($belongsToMany, array_keys($fields))) {
                    $fkRelationShip = $references[1];
                    $this->model->$fkRelationShip()->detach();
                    if (!empty($request->get($fkRelationShip))) {
                        foreach ($request->get($fkRelationShip) as $value) {
                            $this->model->$fkRelationShip()->attach($value);
                        }
                    }
                }
            }

            if ($request->has('redirectTo')) {
                return redirect($request->get('redirectTo'))->with('success', 'Operation performed successfully');
            }
            if (!empty($this->model->getFormRedirect())) {
                return redirect($this->model->getFormRedirect())->with('success', 'Operation performed successfully');
            }
            return redirect()->back()->with('success', 'Operation performed successfully');
        } else return redirect()->back()->with('error', "Error during operation")->withInput();
    }

    public function _delete(Request $request, $parent_id = null, $_id = null)
    {
        if ($_id == null) $_id = $parent_id;
        $model_class = get_class($this->model);
        $data = $model_class::find($_id);
        if ($data != null)
            $data->delete();
        return 1;
    }

    public function _setNull(Request $request)
    {
        $model_class = get_class($this->model);
        $data = $model_class::find($request->get('data_id'));
        $column =  $request->get('data_column');
        if ($data != null) {
            $data->$column = null;
            $data->save();
        }
        return 1;
    }

    public function _edit(Request $request, $parent_id = null, $_id = null)
    {
        if ($_id == null)  $_id = $parent_id;
        $primaryKey = $this->model->getPrimaryKey();
        $object = DB::table($this->model->getTable())->where($primaryKey, '=', $_id)->first();
        return response()->json([
            'model' => $object
        ], 200);
    }

    public function _dataList(Request $request, $wheres = null, $orderBys = null, $whereIns = null)
    {
        $model_class = get_class($this->model);
        $fields = $this->model->getFields();

        $list = $model_class::select('*');
        if ($wheres != null) {
            foreach ($wheres as $where) {
                $list = $list->where($where[0], $where[1], $where[2]);
            }
        }

        if ($whereIns != null) {
            foreach ($whereIns as $whereIn) {
                $list = $list->whereIn($whereIn[0], $whereIn[1]);
            }
        }

        $totalRecords = $list->count();

        $search_array = $request->get('search');
        if (!empty($search_array) && !empty($search_array['value'])) {
            $search = $search_array['value'];
            $list = $list->where(function ($query) use ($search, $fields) {
                $first_column = true;
                foreach ($fields as $column => $value) {
                    if (
                        !in_array($column, array_keys($this->model->getBelongsTo()))
                        && !in_array($column, array_keys($this->model->getBelongsToMany()))
                        && !in_array($column, $this->model->getUnexceptFiledsSearch())
                    ) {
                        if ($first_column) {
                            $query->where($column, 'like', '%' . $search . '%');
                            $first_column = false;
                        } else {
                            $query->orWhere($column, 'like', '%' . $search . '%');
                        }
                    }
                }
            });
        }

        if (!empty($request->get('start'))) {
            $list = $list->skip($request->get('start'));
        }

        if (!empty($request->get('length'))) {
            $list = $list->take($request->get('length'));
        }

        foreach ($this->model->getOrderBys() as $column => $order) {
            $list = $list->orderBy($column, $order);
        }

        if ($orderBys != null) {
            foreach ($orderBys as $orderBy) {
                $list = $list->orderBy($orderBy[0], $orderBy[1]);
            }
        }

        $list = $list->get();

        $data = [];
        foreach ($list as $item) {
            $line = [];
            foreach ($fields as $column => $value) {
                if (!in_array($column, $this->model->getColumnsHiddens())) {
                    if (array_key_exists($column, $this->model->getCustomColumns())) {
                        $customFunc = $this->model->getCustomColumns()[$column];
                        $line[] = $item->$customFunc();
                    } elseif (in_array($column, $this->model->getNumbers())) {
                        if ($item->$column != null) {
                            $line[] = '<div style="width: 100%; text-align: right">' . number_format($item->$column, 0, '', ' ') . '</div>';
                        } else {
                            $line[] = '';
                        }
                    } elseif (in_array($column, $this->model->getDates())) {
                        $line[] = $item->$column != null ? date('d-m-Y', strtotime($item->$column)) : '';
                    } elseif (in_array($column, $this->model->getDatetimes())) {
                        $line[] = $item->$column != null ? date('d-m-Y H:i', strtotime($item->$column)) : '';
                    } elseif (in_array($column, $this->model->getColors())) {
                        $line[] = '<span style="background-color: ' . $item->$column . '; padding: 2px 20px; "></span>';
                    } elseif (in_array($column, $this->model->getImages())) {
                        if (!empty($item->$column))
                            $line[] = '<a href="' . url($item->$column) . '" target="_blank"><img src="' . url($item->$column) . '" style="width: 50px;" alt=""></a>';
                        else $line[] = '';
                    } elseif (in_array($column, $this->model->getFiles())) {
                        $line[] = ' <a href="' . url($item->$column) . '" target="_blank"><i class="fa fa-download"></i></a>';
                    } elseif (in_array($column, array_keys($this->model->getBelongsTo()))) {
                        $refrences = $this->model->getBelongsTo()[$column];
                        $label = $refrences[2];
                        if ($item->$column != null) {
                            $line[] = $item->$column->$label;
                        } else {
                            $line[] = $item->$column;
                        }
                    } else {
                        $val = $item->$column;
                        $line[] = $val . '';
                    }
                }
            }

            if (count($this->model->getActions()) != 0 || count($this->model->getCustomBouttons()) != 0) {
                $is_modal = empty($this->model->getViewForm());
                $current_path = $request->get('current_path');
                $primaryKey = $this->model->getPrimaryKey();

                $actionBtns = '';
                $actions = '';
                //$actions = '<button data-toggle="dropdown" class="btn btn-secondary btn-sm btn-block" type="button">Options <i class="icon ion-ios-arrow-down tx-11"></i></button><div class="dropdown-menu">';
                foreach ($this->model->getCustomBouttons() as $btn) {
                    $actions .= $item->$btn();
                }
                if (in_array('edit', $this->model->getActions())) {
                    $class_btn_edit = $is_modal ? 'btn-edit-record' : '';
                    $actions .= '<a href="' . url($current_path . '/edit/' . $item->$primaryKey) . '" class="dropdown-item ' . $class_btn_edit . ' text-primary">Edit</a>';
                }
                if (in_array('delete', $this->model->getActions())) {
                    $actions .= '<a href-redirect="' . $current_path . '" href="' . url($current_path . '/delete/' . $item->$primaryKey) . '" class="dropdown-item btn-remove-record text-danger">Delete</a>';
                }
                $actionBtns .= $actions;

                $line[] = $actionBtns;
            } else {
                $line[] = '';
            }

            $data[] = $line;
        }


        return response()->json([
            'data' => $data,
            'draw' => $request->get('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
        ]);
    }
}
