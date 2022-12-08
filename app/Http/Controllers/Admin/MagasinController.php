<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BasicController;
use App\Mail\InternMessage;
use App\Models\Candidature;
use App\Models\Contract;
use App\Models\Entreprise;
use App\Models\Intern;
use App\Models\User;
use App\Notifications\NewIntern;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use PDF;

class MagasinController extends BasicController
{
    //
    public function index()
    {
        return view(
            'admin.interns.list'
        );
    }

    //
    public function add()
    {
        $entreprises = Entreprise::all();


        return view(
            'admin.interns.add',
            [
                'entreprises' => $entreprises,
            ]
        );
    }

    public function add_cand(Candidature $candidature)
    {
        $entreprises = Entreprise::all();
        $user = User::find($candidature->user_id);

        return view(
            'admin.interns.add',
            [
                'entreprises' => $entreprises,
                'user' => $user,
                'candidature' => $candidature
            ]
        );
    }

    //
    public function  ajaxInterns(Request $request)
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
        $totalRecords = Contract::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Contract::select('count(*) as allcount')->where('departement', 'like', '%' . $searchValue . '%')->orWhere('type_contract', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = Contract::orderBy($columnName, $columnSortOrder)
            ->where('contracts.departement', 'like', '%' . $searchValue . '%')
            ->orWhere('contracts.type_contract', 'like', '%' . $searchValue . '%')
            ->select('contracts.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {

            $record->load(['intern', 'entreprise']);

            $id = $record->id;

            $name = $record->intern->lastname . ' ' . $record->intern->lastname;
            $email = $record->intern->email;
            $phone = $record->intern->phone;
            $departement = $record->departement;
            $entreprise = $record->entreprise->name;

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
          </button>';
            if (Auth::user()->security_role_id <= 3) {
                $actions .= ' <button style="margin:10px;" class="m-10 text-danger text-xl modal_delete_action" data-bs-toggle="modal"
                    data-id="' . $record->id . '"
                    data-bs-target="#cardModalCenter' . $record->id . '">
                    <i class="lni lni-trash-can"></i>
                </button>';
            }




            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "phone" => $phone,
                "departement" => $departement,
                "entreprise" => $entreprise,
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
    public function  getIntern(Request $request)
    {
        $contract = Contract::find($request->id);

        $title = "";
        $body = "";

        if ($request->action == "view") {
            $contract->load(['intern', 'entreprise', 'user']);
            $status = BasicController::status($contract->status);

            $manager = $contract->manager != null ? $contract->manager->lastname . ' ' . $contract->manager->firstname : 'Personne';

            $delais = BasicController::delais_end($contract->end);

            $title = "Stagiaire N° " . $contract->id;
            $body = '<div class="row">
                <div class="col-12 mb-5">
                    <h6 class="mb-0">Nom & Prénom </h6>
                    <p class="mb-0">' . $contract->intern->lastname . ' ' . $contract->intern->firstname . '</p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Email
                    </h6>
                    <p class="mb-0">' . $contract->intern->email . '</p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Téléphone
                    </h6>
                    <p class="mb-0">' . $contract->intern->phone . '</p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Date de Naissance </h6>
                    <p class="mb-0">' . $contract->intern->birthday . '</p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Lieu de Naissance </h6>
                    <p class="mb-0">' . $contract->intern->birthplace . '</p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Genre</h6>
                    <p class="mb-0">' . $contract->intern->gender . '</p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Type de Contrat </h6>
                    <p class="mb-0">' . $contract->type_contract . '</p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Date de début </h6>
                    <p class="mb-0">' . $contract->begin . '</p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Date de fin</h6>
                    <p class="mb-0">' . $contract->end . '</p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Entreprise </h6>
                    <p class="mb-0">' . $contract->entreprise->name . '</p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Département </h6>
                    <p class="mb-0">' . $contract->departement . '</p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Poste </h6>
                    <p class="mb-0">' . $contract->poste . '</p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Statut</h6>
                    <p class="mb-0"><span class="status-btn ' . $status['type'] . '-btn">' . $status['message'] . '</span></p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Date de Création</h6>
                    <p class="mb-0">' . $contract->created_at . '</p>
                </div>
                <div class="col-6 mb-5">
                    <h6 class="mb-0">Créateur
                    </h6>
                    <p class="mb-0">' . $contract->user->lastname . '</p>
                </div>

                <div class="col-12 mb-5">
                    <p class="mb-0 text-center"><a href="' . url('contract/' . $contract->id) . '"><button class="btn btn-success">Générer le contrat de stage</button></a></p>
                </div>';

            if ($contract->status == 4 || $delais == true) {
                $body .= '<div class="col-12 mb-5">
                    <p class="mb-0 text-center"><a href="' . url('certificat/' . $contract->id) . '"><button class="btn btn-success">Générer le contrat de stage</button></a></p>
                </div>';
            }


            $body .= '</div>';

            //dd($body);
        } elseif ($request->action == "edit") {

            $contract->load(['entreprise', 'intern']);
            $entreprise = $contract->entreprise->name;

            $body = '<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelOne">Mettre à jour le Stagiaire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <i class="lni lni-close"></i>
                </button>
            </div>

            <form action="' .  url('admin/intern/' . $request->id . '') . '" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">

                                <div class="select-style-2">
                                    <div class="select-position">
                                        <select name="type_contract">
                                            <option>' . $contract->type_contract . '</option>
                                            <option>Stage École</option>
                                            <option>Stage Découverte</option>
                                            <option>Stage Pré-Emploi</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- end input -->
                                <!-- end input -->
                                <div class="input-style-3">
                                    <input name="begin" type="date" placeholder="Date de Début" value="' . $contract->begin . '"  />
                                    <span class="icon"><i class="lni lni-envelope"></i></span>
                                </div>
                                <!-- end input -->
                                <!-- end input -->
                                <div class="input-style-3">
                                    <input name="end" type="date" placeholder="Date de Fin" value="' . $contract->end . '" />
                                    <span class="icon"><i class="lni lni-phone"></i></span>
                                </div>
                                <!-- end input -->
                                <!-- end input -->
                                <div class="input-style-3">
                                    <input name="departement" type="text" placeholder="Adresse" value="' . $contract->departement . '" />
                                    <span class="icon"><i class="lni lni-users"></i></span>
                                </div>
                                <!-- end input -->
                                <!-- end input -->
                                <div class="input-style-3">
                                    <input name="poste" type="text" placeholder="Poste" value="' . $contract->poste . '" />
                                    <span class="icon"><i class="lni lni-users"></i></span>
                                </div>
                                <!-- end input -->

                                <div class="select-style-2">
                                    <div class="select-position">
                                        <select name="status">
                                            <option value="' . STATUT_DO . '">Terminé</option>
                                            <option value="' . STATUT_APPROVE . '">Approuvé</option>
                                            <option value="' . STATUT_REFUSED . '">Refusé</option>
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
            <form method="POST" action="' . url('admin/intern/' . $request->id . '') . '">
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

        if ($request->candidature_id) {

            $candidature = Candidature::find($request->candidature_id);

            $candidature->status = STATUT_APPROVE;
            $candidature->save();

            $user = User::find($request->user_id);

            if ($user->security_role_id == 5) {
                $contract = new Contract();

                $contract->type_contract = $request->type_contract;
                $contract->begin = $request->begin;
                $contract->end = $request->end;
                $contract->departement = $request->departement;
                $contract->poste = $request->poste;
                $contract->entreprise_id = $request->entreprise_id;
                $contract->intern_id = $user->id;
                $contract->status = STATUT_PENDING;

                $user_connect = Auth::user();
                $contract->user_id = $user_connect->id;

                $contract->save();

                $intern = new Intern();

                $intern->entreprise_id = $request->entreprise_id;
                $intern->intern_id = $user->id;

                $intern->save();

                Mail::to($user->email)->queue(new InternMessage($contract));
                $user->notify(new NewIntern($contract));


                return redirect('admin/list-interns')->with('success', "Le stagiaire a bien été créée !");
            } else {
                $user =  new User();

                $user->lastname = $request->lastname;
                $user->firstname = $request->firstname;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->birthday = $request->birthday;
                $user->birthplace = $request->birthplace;
                $user->gender = $request->gender;
                $user->security_role_id = 5;
                $user->entreprise_id = $request->entreprise_id;

                if ($user->save()) {
                    $contract = new Contract();

                    $contract->type_contract = $request->type_contract;
                    $contract->begin = $request->begin;
                    $contract->end = $request->end;
                    $contract->departement = $request->departement;
                    $contract->poste = $request->poste;
                    $contract->entreprise_id = $request->entreprise_id;
                    $contract->intern_id = $user->id;
                    $contract->status = STATUT_PENDING;

                    $user_connect = Auth::user();
                    $contract->user_id = $user_connect->id;

                    $contract->save();

                    $intern = new Intern();

                    $intern->entreprise_id = $request->entreprise_id;
                    $intern->intern_id = $user->id;

                    $intern->save();

                    Mail::to($user->email)->queue(new InternMessage($contract));
                    $user->notify(new NewIntern($contract));

                    return redirect('admin/list-interns')->with('success', "Le stagiaire a bien été créée !");
                } else {
                    return back()->with('error', "Une erreur s'est produite.");
                }
            }
        } else {
            $user =  new User();

            $user->lastname = $request->lastname;
            $user->firstname = $request->firstname;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->birthday = $request->birthday;
            $user->birthplace = $request->birthplace;
            $user->gender = $request->gender;
            $user->security_role_id = 5;
            $user->entreprise_id = $request->entreprise_id;

            if ($user->save()) {
                $contract = new Contract();

                $contract->type_contract = $request->type_contract;
                $contract->begin = $request->begin;
                $contract->end = $request->end;
                $contract->departement = $request->departement;
                $contract->poste = $request->poste;
                $contract->entreprise_id = $request->entreprise_id;
                $contract->intern_id = $user->id;
                $contract->status = STATUT_PENDING;

                $user_connect = Auth::user();
                $contract->user_id = $user_connect->id;

                $contract->save();

                $intern = new Intern();

                $intern->entreprise_id = $request->entreprise_id;
                $intern->intern_id = $user->id;

                $intern->save();

                Mail::to($user->email)->queue(new InternMessage($contract));
                $user->notify(new NewIntern($contract));

                return redirect('admin/list-interns')->with('success', "Le stagiaire a bien été créée !");
            } else {
                return back()->with('error', "Une erreur s'est produite.");
            }
        }
    }

    public function update(Request $request, Contract $contract)
    {

        if (isset($_POST['delete'])) {
            if ($contract->delete()) {
                return redirect('admin/list-interns')->with('success', "Le contrat a bien été supprimée !");
            } else {
                return back()->with('error', "Une erreur s'est produite.");
            }
        } else {
            $contract->type_contract = $request->type_contract;
            $contract->begin = $request->begin;
            $contract->end = $request->end;
            $contract->departement = $request->departement;
            $contract->poste = $request->poste;
            $contract->entreprise_id = $request->entreprise_id;
            $contract->status = STATUT_PENDING;
            if ($contract->save()) {
                return redirect('admin/list-interns')->with('success', "Le contrat a bien été mis à jour !");
            } else {
                return back()->with('error', "Une erreur s'est produite.");
            }
        }
    }
}
