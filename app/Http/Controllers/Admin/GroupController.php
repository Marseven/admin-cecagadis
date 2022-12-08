<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BasicController;
use App\Mail\DemandeAnswerMessage;
use App\Mail\DemandeMessage;
use App\Models\Demande;
use App\Models\Entreprise;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GroupController extends BasicController
{
    //
    public function index()
    {
        return view(
            'admin.entreprises.list'
        );
    }

    //
    public function add()
    {
        $managers = User::where('security_role_id', 2)->get();
        return view(
            'admin.entreprises.add',
            [
                'managers' => $managers
            ]
        );
    }

    //
    public function  ajaxEntreprises(Request $request)
    {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Entreprise::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Entreprise::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->orWhere('entreprises.email', 'like', '%' . $searchValue . '%')->orWhere('entreprises.phone', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = Entreprise::orderBy($columnName, $columnSortOrder)
            ->where('entreprises.name', 'like', '%' . $searchValue . '%')
            ->orWhere('entreprises.email', 'like', '%' . $searchValue . '%')
            ->orWhere('entreprises.phone', 'like', '%' . $searchValue . '%')
            ->select('entreprises.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {

            $record->load(['manager']);

            $id = $record->id;

            $name = $record->name;
            $email = $record->email;
            $phone = $record->phone;
            $adress = $record->adress;
            $manager = $record->manager != null ? $record->manager->lastname . ' ' . $record->manager->firstname : 'Personne';

            $status = BasicController::status($record->status);
            $status = '<span class="status-btn ' . $status['type'] . '-btn">' . $status['message'] . '</span>';

            $actions = '<button style="margin:10px;" class="m-10 text-primary text-xl modal_view_action" data-bs-toggle="modal"
            data-id="' . $record->id . '"
            data-bs-target="#cardModalView' . $record->id . '">
            <i class="lni lni-eye"></i>
          </button>';


            $actions .= '<button style="margin:10px;" class="m-10 text-warning text-xl modal_edit_action" data-bs-toggle="modal"
            data-id="' . $record->id . '"
            data-bs-target="#cardModal' . $record->id . '">
            <i class="lni lni-pencil"></i>
          </button>
          <button style="margin:10px;" class="m-10 text-danger text-xl modal_delete_action" data-bs-toggle="modal"
            data-id="' . $record->id . '"
            data-bs-target="#cardModalCenter' . $record->id . '">
            <i class="lni lni-trash-can"></i>
          </button>';




            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "phone" => $phone,
                "adress" => $adress,
                "manager" => $manager,
                "status" => $status,
                "actions" => $actions,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        Log::info('Afficher la liste de paiements à ' . Auth::user()->name);

        return response()->json($response);
    }

    //
    public function  getEntreprise(Request $request)
    {
        $entreprise = Entreprise::find($request->id);

        $title = "";
        $body = "";

        if ($request->action == "view") {
            $entreprise->load(['user', 'manager']);
            $status = BasicController::status($entreprise->status);

            $manager = $entreprise->manager != null ? $entreprise->manager->lastname . ' ' . $entreprise->manager->firstname : 'Personne';

            //dd($entreprise);

            $title = "Entreprise N° " . $entreprise->id;
            $body = '<div class="row">
                <div class="col-12 mb-5">
                    <h6 class="mb-0">Nom </h6>
                    <p class="mb-0">' . $entreprise->name . '</p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Email
                    </h6>
                    <p class="mb-0">' . $entreprise->email . '</p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Téléphone
                    </h6>
                    <p class="mb-0">' . $entreprise->phone . '</p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Adresse </h6>
                    <p class="mb-0">' . $entreprise->adress . ' XAF</p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Gérant </h6>
                    <p class="mb-0">' . $manager . '</p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Statut</h6>
                    <p class="mb-0"><span class="status-btn ' . $status['type'] . '-btn">' . $status['message'] . '</span></p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Date de Création</h6>
                    <p class="mb-0">' . $entreprise->created_at . '</p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Créateur
                    </h6>
                    <p class="mb-0">' . $entreprise->user->lastname . '</p>
                </div>
            </div>';

            //dd($body);
        } elseif ($request->action == "edit") {

            $entreprise->load(['manager']);
            $manager = $entreprise->manager != null ? $entreprise->manager->lastname . ' ' . $entreprise->manager->firstname : 'Personne';

            $body = '<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelOne">Mettre à jour l\'entreprise</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <i class="lni lni-close"></i>
                </button>
            </div>

            <form action="' .  url('admin/entreprise/' . $request->id . '') . '" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">

                    <div class="input-style-3">
                                    <input name="name" type="text" placeholder="Nom de l\'entreprise" value="' . $entreprise->name . '" />
                                    <span class="icon"><i class="lni lni-linkedin"></i></span>
                                </div>
                                <!-- end input -->
                                <!-- end input -->
                                <div class="input-style-3">
                                    <input name="email" type="text" placeholder="Email" value="' . $entreprise->email . '"  />
                                    <span class="icon"><i class="lni lni-envelope"></i></span>
                                </div>
                                <!-- end input -->
                                <!-- end input -->
                                <div class="input-style-3">
                                    <input name="phone" type="tel" placeholder="Téléphone" value="' . $entreprise->phone . '" />
                                    <span class="icon"><i class="lni lni-phone"></i></span>
                                </div>
                                <!-- end input -->
                                <!-- end input -->
                                <div class="input-style-3">
                                    <input name="adress" type="text" placeholder="Adresse" value="' . $entreprise->adress . '" />
                                    <span class="icon"><i class="lni lni-map-marker"></i></span>
                                </div>
                                <!-- end input -->

                                <!-- end input -->
                                <div class="select-style-2">
                                    <div class="select-position">
                                        <select name="manager">
                                            <option value="' . $entreprise->manager_id . '">' . $manager . '</option>
                                            ';

            $managers = User::where('security_role_id', '<=', 2)->get();
            foreach ($managers as $manager)
                $body .= '<option value="' . $manager->id . '">
                                                    ' . $manager->lastname . ' ' . $manager->firstname . '</option>';

            $body .= '</select>
                                    </div>
                                </div>
                                <!-- end input -->

                                <div class="select-style-2">
                                    <div class="select-position">
                                        <select name="status">
                                        <option value="' . STATUT_ENABLE . '">Actif</option>
                                         <option value="' . STATUT_DISABLE . '">Inactif</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- end input -->
                </div>
                <div class="modal-footer">
                    <button style="background-color: #2b9753 !important;" type="submit" class="btn btn-success">Enregistrer</button>
                </div>
            </form>';
        } else {

            $body = '
            <form method="POST" action="' . url('admin/entreprise/' . $request->id . '') . '">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <input type="hidden" name="delete" value="true">
                <button style="background-color: #d50100 !important;" class="btn btn-danger" type="submit">Supprimer</button>
            </form>';
        }

        $response = array(
            "title" => $title,
            "body" => $body,
        );

        return response()->json($response);
    }

    public function create(Request $request)
    {

        $entreprise = new Entreprise();
        $entreprise->name = $request->name;
        $entreprise->email = $request->email;
        $entreprise->adress = $request->adress;
        $entreprise->phone = $request->phone;
        $entreprise->status = STATUT_ENABLE;
        $entreprise->manager_id = $request->manager;
        $entreprise->user_id = auth()->user()->id;

        if ($entreprise->save()) {
            return redirect('admin/list-entreprises')->with('success', "L'entreprise a bien été créée !");
        } else {
            return back()->with('error', "Une erreur s'est produite.");
        }
    }

    public function update(Request $request, Entreprise $entreprise)
    {

        if (isset($_POST['delete'])) {
            if ($entreprise->delete()) {
                return redirect('admin/list-entreprises')->with('success', "L'entreprise a bien été supprimée !");
            } else {
                return back()->with('error', "Une erreur s'est produite.");
            }
        } else {
            $entreprise->name = $request->name;
            $entreprise->email = $request->email;
            $entreprise->adress = $request->adress;
            $entreprise->phone = $request->phone;
            $entreprise->status = $request->status;
            $entreprise->manager_id = $request->manager;
            if ($entreprise->save()) {
                return redirect('admin/list-entreprises')->with('success', "L'entreprise a bien été mis à jour !");
            } else {
                return back()->with('error', "Une erreur s'est produite.");
            }
        }
    }

    public function partenaire(Demande $demande)
    {
        $demande->status = STATUT_APPROVE;

        if ($demande->save()) {
            $school = School::find($demande->school_id);
            $entreprise = Entreprise::find($demande->entreprise_id);
            $manager = User::find($school->manager_id);
            $data['exp'] = $entreprise->name;
            $data['exp_email'] = $entreprise->email;
            $data['exp_phone'] = $entreprise->phone;
            $data['dest'] = $school->name;
            $data['dest_manager'] =  $manager->firstname;
            Mail::to($manager->email)->queue(new DemandeAnswerMessage($data));
            return back()->with('success', "La demande acceptée !");
        } else {
            return back()->with('error', "Une erreur s'est produite.");
        }
    }

    public function demande(School $school)
    {
        $demande = new Demande();
        $demande->type_d = 'EtoS';
        $demande->school_id = $school->id;
        $demande->entreprise_id = Auth::user()->entreprise_id;

        $entreprise = Entreprise::find(Auth::user()->entreprise_id);

        $demande->status = STATUT_RECEIVE;

        if ($demande->save()) {
            $manager = User::find($entreprise->manager_id);
            $data['exp'] = $entreprise->name;
            $data['exp_email'] = $entreprise->email;
            $data['exp_phone'] = $entreprise->phone;
            $data['dest'] = $school->name;
            $data['dest_manager'] =  $manager->firstname;
            Mail::to($manager->email)->queue(new DemandeMessage($data));
            return back()->with('success', "La demande de Partenariat envoyée !");
        } else {
            return back()->with('error', "Une erreur s'est produite.");
        }
    }
}
