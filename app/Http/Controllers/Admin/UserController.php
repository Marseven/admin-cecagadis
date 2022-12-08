<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BasicController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use App\Models\Entreprise;
use App\Models\School;
use App\Models\SecurityRole;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function profil()
    {
        $user = User::find(Auth::user()->id);
        $user->load(['SecurityRole', 'entreprise', 'employe']);

        if ($user->entreprise->first() != null) {
            $entreprise = $user->entreprise;
        } elseif ($user->employe != null) {
            $entreprise = $user->employe->first();
        } else {
            $entreprise = null;
        }

        return view(
            'admin.users.profil',
            [
                'user' => $user,
                'entreprise' => $entreprise,
            ]
        );
    }

    public function admins()
    {
        $admins = User::where('security_role_id', '<', 3)->get();
        $roles = SecurityRole::all();
        return view(
            'admin.users.admins',
            [
                'admins' => $admins,
                'roles' => $roles
            ]
        );
    }

    public function superviseurs()
    {

        if (Auth::user()->security_role_id >= 2) {
            $roles = SecurityRole::whereIn('id', [4, 5])->get();
            $superviseurs = User::where('entreprise_id', Auth::user()->entreprise_id)->where('security_role_id', 4)->get();
        } else {
            $roles = SecurityRole::whereIn('id', [2, 3, 4, 5])->get();
            $superviseurs = User::where('security_role_id', 4)->get();
        }



        return view(
            'admin.users.superviseurs',
            [
                'superviseurs' => $superviseurs,
                'roles' => $roles
            ]
        );
    }

    public function add()
    {
        if (Auth::user()->security_role_id <= 2) {
            $roles = SecurityRole::whereIn('id', [2, 3, 4, 5])->get();
        } else {
            $roles = SecurityRole::whereIn('id', [4, 5])->get();
        }
        $entreprises = Entreprise::all();
        return view(
            'admin.users.add',
            [
                'roles' => $roles,
                'entreprises' => $entreprises
            ]
        );
    }

    public function create(Request $request)
    {
        $user =  new User();

        $user->lastname = $request->lastname;
        $user->firstname = $request->firstname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->entreprise_id = $request->entreprise_id;
        $user->security_role_id = $request->security_role_id;

        $role = SecurityRole::find($request->security_role_id);

        if ($user->save()) {
            if ($role->id <= 2) {
                return redirect('admin/list-superviseurs')->with('success', "Le " . $role->name . " a été ajouté !");
            } else {
                return redirect('admin/list-admins')->with('success', "Le " . $role->name . " a été ajouté !");
            }
        } else {
            return back()->with('error', "Une erreur s'est produite.");
        }
    }

    public function update(Request $request, User $user)
    {
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->birthday = $request->birthday;
        $user->birthplace = $request->birthplace;
        $user->email = $request->email;
        $user->adress = $request->adress;
        $user->gender = $request->gender;

        if (BasicController::formatPhone($request->phone) != false) {
            $user->phone = BasicController::formatPhone($request->phone);
        } else {
            return back()->withErrors("Numéro de Téléphone incorrect");
        }

        if ($request->file('picture')) {
            $picture = FileController::picture($request->file('picture'));
            if ($picture['state'] == false) {
                return back()->withErrors($picture['message']);
            }

            $user->picture = $picture['url'];
        }

        if ($user->save()) {
            return back()->with('success', "Le profil a été ajouté !");
        } else {
            return back()->with('error', "Une erreur s'est produite.");
        }
    }
}
