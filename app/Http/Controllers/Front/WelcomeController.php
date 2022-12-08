<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\BasicController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use App\Models\Demande;
use App\Models\Entreprise;
use App\Models\Offer;
use App\Models\Project;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends BasicController
{
    //
    public function add()
    {
        return view('front.add');
    }

    public function entreprise()
    {
        $entreprises = Entreprise::all();
        $user = Auth::user();
        $demandes = Demande::where('school_id', $user->school_id)->get();
        return view('front.entreprise', ['entreprises' => $entreprises, 'demandes' => $demandes,]);
    }

    public function edit()
    {
        return view('auth.update');
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
            return redirect('profil')->with('success', "Votre profil a été mis à jour !");
        } else {
            return back()->with('error', "Une erreur s'est produite.");
        }
    }

    public function profil()
    {
        $user = User::find(Auth::user()->id);
        if ($user->security_role_id == 5) {
            $user->load(['candidatures', 'SecurityRole', 'employe', 'contracts']);
            $candidatures = $user->candidatures;
            $contracts = $user->contracts;
            $projects = Project::where('intern_id', $user->id)->get();
            $entreprise = $user->employe;
            return view('auth.profil', [
                'candidatures' => $candidatures,
                'contracts' => $contracts,
                'entreprise' => $entreprise,
                'projects' => $projects
            ]);
        } else {
            $user->load(['candidatures', 'SecurityRole', 'school']);
            $candidatures = $user->candidatures;
            $contracts = null;
            $schools = School::where('manager_id', $user->id)->get();
            $demandes = Demande::where('school_id', $schools->first()->id)->get();
            $stagiaires = User::where('school_id', $schools->first()->id)->where('security_role_id', 5)->get();
            return view('auth.profil', [
                'candidatures' => $candidatures,
                'demandes' => $demandes,
                'contracts' => $contracts,
                'schools' => $schools,
                'stagiaires' => $stagiaires
            ]);
        }
    }
}
