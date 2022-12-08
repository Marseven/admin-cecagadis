<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BasicController;
use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use App\Models\Offer;
use App\Models\Project;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends BasicController
{
    //
    public function dashboard()
    {
        if (Auth::user()->security_role_id == 1) {
            $nb_stagiaire = User::where('security_role_id', 5)->count();
            $nb_projets = Project::all()->count();
            $nb_offres = Offer::all()->count();
            $nb_ecoles = School::all()->count();

            $projets = Project::where('status', STATUT_PENDING)->limit(5)->get();
        } else {
            $nb_stagiaire = User::where('security_role_id', 5)->where('entreprise_id', Auth::user()->entreprise_id)->count();
            $nb_projets = Project::where('entreprise_id', Auth::user()->entreprise_id)->count();
            $nb_offres = Offer::where('entreprise_id', Auth::user()->entreprise_id)->count();
            $nb_ecoles = School::all()->count();

            $projets = Project::where('entreprise_id', Auth::user()->entreprise_id)->where('status', STATUT_PENDING)->limit(5)->get();
        }



        return view('admin.dashboard', [
            'nb_stagiaire' => $nb_stagiaire,
            'nb_projets' => $nb_projets,
            'nb_offres' => $nb_offres,
            'nb_ecoles' => $nb_ecoles,
            'projets' => $projets,
        ]);
    }

    public function notifications()
    {
        $user = User::find(Auth::user()->id);
        return view('admin/notifications', ['user' => $user,]);
    }
}
