@extends('layouts.front')

@php
    $user = Auth::user();
@endphp

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css" />
@endpush

@section('content')
    <!-- ====== Banner Section Start -->
    <div
        class="
        relative
        z-10
        pt-[120px]
        md:pt-[130px]
        lg:pt-[160px]
        pb-[100px]
        bg-primary
        overflow-hidden
      ">
        <div class="container">
            <div class="flex flex-wrap items-center -mx-4">
                <div class="w-full px-4">
                    <div class="text-center">
                        <h1 class="font-semibold text-white text-4xl">{{ $user->lastname }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <span class="absolute top-0 left-0 z-[-1]">
                <svg width="495" height="470" viewBox="0 0 495 470" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="55" cy="442" r="138" stroke="white" stroke-opacity="0.04"
                        stroke-width="50" />
                    <circle cx="446" r="39" stroke="white" stroke-opacity="0.04" stroke-width="20" />
                    <path d="M245.406 137.609L233.985 94.9852L276.609 106.406L245.406 137.609Z" stroke="white"
                        stroke-opacity="0.08" stroke-width="12" />
                </svg>
            </span>
            <span class="absolute top-0 right-0 z-[-1]">
                <svg width="493" height="470" viewBox="0 0 493 470" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="462" cy="5" r="138" stroke="white" stroke-opacity="0.04"
                        stroke-width="50" />
                    <circle cx="49" cy="470" r="39" stroke="white" stroke-opacity="0.04"
                        stroke-width="20" />
                    <path d="M222.393 226.701L272.808 213.192L259.299 263.607L222.393 226.701Z" stroke="white"
                        stroke-opacity="0.06" stroke-width="13" />
                </svg>
            </span>
        </div>
    </div>
    <!-- ====== Banner Section End -->

    <!-- ====== About Section Start -->
    <section id="about" class="pt-20 lg:pt-[120px] pb-20 lg:pb-[120px] bg-[#f3f4fe]">
        <div class="container">
            <div class="container mx-auto my-5 p-5">

                @include('layouts.flash')
                <br>
                <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
                    <ul class="flex flex-wrap -mb-px" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button
                                class="inline-block text-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-sm font-medium text-center border-transparent border-b-2 dark:text-gray-400 dark:hover:text-gray-300 active"
                                id="profile-tab" data-tabs-target="#profile" type="button" role="tab"
                                aria-controls="profile" aria-selected="true">Profil</button>
                        </li>
                        @if ($user->security_role_id == 6)
                            <li class="mr-2" role="presentation">
                                <button
                                    class="inline-block text-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-sm font-medium text-center border-transparent border-b-2 dark:text-gray-400 dark:hover:text-gray-300"
                                    id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab"
                                    aria-controls="dashboard" aria-selected="false">Entreprise</button>
                            </li>
                        @endif
                        <li class="mr-2" role="presentation">
                            <button
                                class="inline-block text-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-sm font-medium text-center border-transparent border-b-2 dark:text-gray-400 dark:hover:text-gray-300"
                                id="settings-tab" data-tabs-target="#settings" type="button" role="tab"
                                aria-controls="settings" aria-selected="false">Stage</button>
                        </li>

                    </ul>
                </div>
                <div id="myTabContent">
                    <div class="bg-gray-50 p-4 rounded-lg dark:bg-gray-800" id="profile" role="tabpanel"
                        aria-labelledby="profile-tab">
                        <div class="md:flex no-wrap md:-mx-2 ">
                            <!-- Left Side -->
                            <div class="w-full md:w-3/12 md:mx-2">
                                <!-- Profile Card -->
                                <div class="bg-white p-3 border-t-4 border-blue-400">
                                    <div class="image overflow-hidden">
                                        <img class="h-auto w-full mx-auto"
                                            src="{{ asset($user->picture != null ? $user->picture : 'admin/images/profile/placeholder.png') }}"
                                            alt="">
                                    </div>
                                    <h1 class="text-gray-900 font-bold text-xl leading-8 my-1">
                                        {{ $user->lastname . ' ' . $user->firstname }}</h1>
                                    <p class="text-sm text-gray-500 hover:text-gray-600 leading-6"></p>
                                    <ul
                                        class="bg-gray-100 text-gray-600 hover:text-gray-700 hover:shadow py-2 px-3 mt-3 divide-y rounded shadow-sm">
                                        <li class="flex items-center py-3">
                                            <span>Statut</span>
                                            <span class="ml-auto"><span
                                                    class="bg-blue-500 py-1 px-2 rounded text-white text-sm">Active</span></span>
                                        </li>
                                        <li class="flex items-center py-3">
                                            <span>Profil</span>
                                            <span class="ml-auto">{{ $user->SecurityRole->name }}</span>
                                        </li>
                                        @if ($user->security_role_id == 6)
                                            <li class="flex items-center py-3">
                                                <span>Ecole</span>
                                                <ul class="m-5">
                                                    @foreach ($schools as $sc)
                                                        <li>{{ $sc->name }}</li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @else
                                            @if ($entreprise != null)
                                                <li class="flex items-center py-3">
                                                    <span>Entreprise</span>
                                                    <span class="ml-auto">{{ $entreprise->name }}</span>
                                                </li>
                                            @endif
                                        @endif

                                        <li class="flex items-center py-3">
                                            <span>Inscrit Depuis</span>
                                            <span class="ml-auto">{{ $user->created_at }}</span>
                                        </li>
                                        <li class="flex items-center py-3">
                                            <a class="bg-red-500 py-1 px-2 rounded text-white text-sm"
                                                href="{{ route('logout') }}">
                                                <i class="lni lni-exit"></i>
                                                Déconnexion
                                            </a>

                                            <a class="ml-2 bg-blue-500 py-1 px-2 rounded text-white text-sm"
                                                href="{{ url('user/' . $user->id) }}">
                                                <i class="lni lni-edit"></i>
                                                Mettre à Jour
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- End of profile card -->
                                <div class="my-4"></div>

                            </div>
                            <!-- Right Side -->
                            <div class="w-full md:w-9/12 mx-2 h-64">
                                <!-- Profile tab -->
                                <!-- About Section -->
                                <div class="bg-white p-3 shadow-sm rounded-sm">
                                    <div class="flex items-center space-x-2 font-semibold text-gray-900 leading-8">
                                        <span clas="text-green-500">
                                            <svg class="h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </span>
                                        <span class="tracking-wide">À Propos</span>
                                    </div>
                                    <div class="text-gray-700">
                                        <div class="grid md:grid-cols-2 text-sm">
                                            <div class="grid grid-cols-2">
                                                <div class="px-4 py-2 font-semibold">Nom</div>
                                                <div class="px-4 py-2">{{ $user->lastname }}</div>
                                            </div>
                                            <div class="grid grid-cols-2">
                                                <div class="px-4 py-2 font-semibold">Prenom</div>
                                                <div class="px-4 py-2">{{ $user->firstname ?? '-' }}</div>
                                            </div>
                                            <div class="grid grid-cols-2">
                                                <div class="px-4 py-2 font-semibold">Sexe</div>
                                                <div class="px-4 py-2">{{ $user->gender ?? '-' }}</div>
                                            </div>
                                            <div class="grid grid-cols-2">
                                                <div class="px-4 py-2 font-semibold">Téléphone.</div>
                                                <div class="px-4 py-2">{{ $user->phone ?? '-' }}</div>
                                            </div>
                                            <div class="grid grid-cols-2">
                                                <div class="px-4 py-2 font-semibold">Adresse</div>
                                                <div class="px-4 py-2">{{ $user->adress ?? '-' }}</div>
                                            </div>
                                            <div class="grid grid-cols-2">
                                                <div class="px-4 py-2 font-semibold">Email.</div>
                                                <div class="px-4 py-2">
                                                    <a class="text-blue-800"
                                                        href="mailto:jane@example.com">{{ $user->email ?? '-' }}</a>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-2">
                                                <div class="px-4 py-2 font-semibold">Date de Naissance</div>
                                                <div class="px-4 py-2">{{ $user->birthday ?? '-' }}</div>
                                            </div>
                                            <div class="grid grid-cols-2">
                                                <div class="px-4 py-2 font-semibold">Lieu de Naissance</div>
                                                <div class="px-4 py-2">{{ $user->birthplace ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- End of about section -->

                                <div class="my-4"></div>

                                <!-- Experience and education -->
                                <div class="bg-white p-3 shadow-sm rounded-sm">

                                    <div class="grid grid-cols-2">
                                        <div>
                                            <div
                                                class="flex items-center space-x-2 font-semibold text-gray-900 leading-8 mb-3">
                                                <span clas="text-green-500">
                                                    <svg class="h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                </span>
                                                <span class="tracking-wide">Candidature(s)</span>
                                            </div>
                                            <ul class="list-inside space-y-2">
                                                @foreach ($candidatures as $cd)
                                                    @php
                                                        $cd->load(['entreprise', 'offer']);
                                                        $contract = null;
                                                        $delais = false;
                                                        if ($contracts != null) {
                                                            foreach ($contracts as $ct) {
                                                                if ($ct->entreprise_id == $cd->entreprise->id && $user->id == $ct->intern_id) {
                                                                    $contract = $ct;
                                                                }
                                                            }
                                                        }

                                                        if ($contract != null) {
                                                            $delais = App\Http\Controllers\BasicController::delais_end($contract->end);
                                                        }
                                                        $status = App\Http\Controllers\BasicController::status($cd->status);
                                                    @endphp
                                                    <li>
                                                        <div class="text-teal-600">
                                                            {{ $cd->offer->label . ' - ' . $cd->entreprise->name }}</div>
                                                        <div class="text-gray-500 text-xs">{{ $status['message'] }} -
                                                            {{ $cd->created_at }}</div>

                                                        @if ($cd->status == 2)
                                                            <div class="mt-2">
                                                                <a href="{{ url('contract/' . $contract->id) }}">
                                                                    <span
                                                                        class="bg-blue-500 py-1 px-2 rounded text-white text-sm">Contrat</span>
                                                                </a>

                                                                @if ($contract->status == 4 || $delais == true)
                                                                    <a href="{{ url('certificat/' . $contract->id) }}">
                                                                        <span
                                                                            class="ml-2 bg-blue-500 py-1 px-2 rounded text-white text-sm">Certificat</span>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        @endif


                                                    </li>
                                                @endforeach

                                                @if ($candidatures->count() == 0)
                                                    <li>
                                                        <div class="text-teal-600">Aucune Candidature envoyée Pour le
                                                            moment</div>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>

                                    </div>
                                    <!-- End of Experience and education grid -->
                                </div>
                                <!-- End of profile tab -->
                            </div>
                        </div>
                    </div>
                    @if ($user->security_role_id == 6)
                        <div class="bg-gray-50 p-4 rounded-lg dark:bg-gray-800 hidden" id="dashboard" role="tabpanel"
                            aria-labelledby="dashboard-tab">
                            <div class="bg-white p-3 shadow-sm rounded-sm">

                                <div class="grid grid-cols-2">
                                    <div>
                                        <div
                                            class="flex items-center space-x-2 font-semibold text-gray-900 leading-8 mb-3">
                                            <span clas="text-green-500">
                                                <svg class="h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </span>
                                            <span class="tracking-wide">Demande de Partenariat</span>
                                        </div>
                                        <ul class="list-inside space-y-2">
                                            @foreach ($demandes as $dem)
                                                @php
                                                    $dem->load(['entreprise']);
                                                    $status = App\Http\Controllers\BasicController::status($dem->status);
                                                @endphp
                                                <li>
                                                    <div class="text-teal-600">
                                                        {{ $dem->entreprise->name . ' - ' . $dem->entreprise->adress }}
                                                    </div>
                                                    <div class="text-gray-500 text-xs">
                                                        {{ $dem->entreprise->email . ' - ' . $dem->entreprise->phone }}
                                                    </div>
                                                    <br>
                                                    <div>
                                                        @if ($dem->type_d == 'EtoS')
                                                            @if ($dem->status == 0)
                                                                <a href="{{ url('demande-response/' . $dem->id) }}">
                                                                    <span
                                                                        class="bg-blue-500 py-1 px-2 rounded text-white text-sm">Accepter
                                                                        la demande</span>
                                                                </a>
                                                            @else
                                                                <span
                                                                    class="bg-green-500 py-1 px-2 rounded text-white text-sm">{{ $status['message'] }}</span>
                                                            @endif
                                                        @else
                                                            @if ($dem->status == 0)
                                                                <a href="#">
                                                                    <span
                                                                        class="bg-blue-500 py-1 px-2 rounded text-white text-sm">
                                                                        Demande Envoyée</span>
                                                                </a>
                                                            @else
                                                                <span
                                                                    class="bg-green-500 py-1 px-2 rounded text-white text-sm">{{ $status['message'] }}</span>
                                                            @endif
                                                        @endif

                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                </div>
                                <!-- End of Experience and education grid -->
                            </div>
                        </div>
                    @endif
                    @if ($user->security_role_id == 5)
                        <div class="bg-gray-50 p-4 rounded-lg dark:bg-gray-800 hidden" id="settings" role="tabpanel"
                            aria-labelledby="settings-tab">
                            <div class="bg-white p-3 shadow-sm rounded-sm">

                                <div class="grid grid-cols-2">
                                    <div>
                                        <div
                                            class="flex items-center space-x-2 font-semibold text-gray-900 leading-8 mb-3">
                                            <span clas="text-green-500">
                                                <svg class="h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </span>
                                            <span class="tracking-wide">Projets</span>
                                        </div>
                                        <ul class="list-inside space-y-2">
                                            @foreach ($projects as $pr)
                                                @php
                                                    $pr->load(['entreprise']);
                                                    $status = App\Http\Controllers\BasicController::status($pr->status);
                                                @endphp
                                                <li>
                                                    <div class="text-teal-600">
                                                        <a href="#"
                                                            data-modal-toggle="project-modal-{{ $pr->id }}">
                                                            {{ $pr->label . ' - ' . $status['message'] }}
                                                        </a>
                                                    </div>
                                                    <div class="text-gray-500 text-xs">Date de Fin : {{ $pr->end }}
                                                    </div>
                                                    <div class="text-gray-500 text-xs">{{ $pr->created_at }}</div>
                                                </li>
                                            @endforeach

                                            @if ($projects->count() == 0)
                                                <li>
                                                    <div class="text-teal-600">Aucun Projet Pour le moment</div>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>

                                </div>
                                <!-- End of Experience and education grid -->
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 p-4 rounded-lg dark:bg-gray-800 hidden" id="settings" role="tabpanel"
                            aria-labelledby="settings-tab">
                            <div class="bg-white p-3 shadow-sm rounded-sm">

                                <div class="grid grid-cols-2">
                                    <div>
                                        <div
                                            class="flex items-center space-x-2 font-semibold text-gray-900 leading-8 mb-3">
                                            <span clas="text-green-500">
                                                <svg class="h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </span>
                                            <span class="tracking-wide">Stagiaires</span>
                                        </div>
                                        <ul class="list-inside space-y-2">
                                            @foreach ($stagiaires as $stg)
                                                @php
                                                    $stg->load(['employe']);
                                                @endphp
                                                <li>
                                                    <div class="text-teal-600">
                                                        {{ $stg->lastname . '  ' . $stg->firstname }}
                                                    </div>
                                                    <div class="text-gray-500 text-xs">Entreprise :
                                                        {{ $stg->employe->name }}
                                                    </div>
                                                    <div class="text-gray-500 text-xs">{{ $stg->created_at }}</div>
                                                </li>
                                            @endforeach

                                            @if ($stagiaires->count() == 0)
                                                <li>
                                                    <div class="text-teal-600">Aucun Stagiaire Pour le moment</div>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>

                                </div>
                                <!-- End of Experience and education grid -->
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </section>
    <!-- ====== About Section End -->
    @if ($user->security_role_id == 5)
        @foreach ($projects as $project)
            @php

                $project->load(['entreprise', 'supervisor', 'user', 'tasks', 'evalue']);

                $supervisor = $project->supervisor->lastname . ' ' . $project->supervisor->firstname;
                $entreprise = $project->entreprise->name;

                $evaluation = $project->evalue->first();
                $status = App\Http\Controllers\BasicController::status($project->status);
            @endphp
            <div id="project-modal-{{ $project->id }}" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed justify-center  top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                <div class="object-center px-4 pt-5 pb-4 sm:p-6 sm:pb-4 w-full max-w-md h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button type="button"
                            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                            data-modal-toggle="project-modal-{{ $project->id }}">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Fermer</span>
                        </button>
                        <div class="py-6 px-6 lg:px-8">
                            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Projet :
                                {{ $project->label }}
                            </h3>
                            <div class="row">
                                <div class="col-12 mb-5">
                                    <h6 class="mb-0">Nom </h6>
                                    <p class="mb-0"> {{ $project->label }} </p>
                                </div>
                                <div class="col-12 mb-5">
                                    <h6 class="mb-0">Description
                                    </h6>
                                    <p class="mb-0"> {{ $project->description }} </p>
                                </div>

                                <div class="col-6 mb-5">
                                    <h6 class="mb-0">Superviseur </h6>
                                    <p class="mb-0"> {{ $supervisor }} </p>
                                </div>
                                <div class="col-6 mb-5">
                                    <h6 class="mb-0">Entreprise </h6>
                                    <p class="mb-0">{{ $entreprise }} </p>
                                </div>
                                <div class="col-6 mb-5">
                                    <h6 class="mb-0">Début </h6>
                                    <p class="mb-0"> {{ $project->begin }} </p>
                                </div>
                                <div class="col-6 mb-5">
                                    <h6 class="mb-0">Fin </h6>
                                    <p class="mb-0"> {{ $project->end }} </p>
                                </div>
                                <div class="col-6 mb-5">
                                    <h6 class="mb-0">Nombre de Tâches </h6>
                                    <p class="mb-0"><a href="#"
                                            data-modal-toggle="task-modal-{{ $project->id }}">
                                            {{ $project->tasks->count() }} </a></p>
                                </div>
                                <div class="col-6 mb-5">
                                    <h6 class="mb-0">Statut</h6>
                                    <p class="mb-0"><span class="status-btn  {{ $status['type'] }}-btn">
                                            {{ $status['message'] }}
                                        </span></p>
                                </div>
                                <div class="col-6 mb-5">
                                    <h6 class="mb-0">Date de Création</h6>
                                    <p class="mb-0"> {{ $project->created_at }} </p>
                                </div>
                                <div class="col-6 mb-5">
                                    <h6 class="mb-0">Créateur
                                    </h6>
                                    <p class="mb-0">{{ $project->user->lastname }}</p>
                                </div>
                                <div class="col-6 mb-5">
                                    <h6 class="mb-0">Note</h6>
                                    <p class="mb-0"> {{ $evaluation->note ?? '-' }} / 20</p>
                                </div>
                                <div class="col-6 mb-5">
                                    <h6 class="mb-0">Remarque(s)
                                    </h6>
                                    <p class="mb-0"> {{ $evaluation->remarque ?? 'Aucune' }} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="task-modal-{{ $project->id }}" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed justify-center  top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                <div class="object-center px-4 pt-5 pb-4 sm:p-6 sm:pb-4 w-full max-w-md h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button type="button"
                            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                            data-modal-toggle="task-modal-{{ $project->id }}">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Fermer</span>
                        </button>
                        <div class="py-6 px-6 lg:px-8">
                            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Projet :
                                {{ $project->label }}
                            </h3>
                            <div class="row">
                                @foreach ($project->tasks as $task)
                                    @php

                                        $task->load(['user', 'evalue']);
                                        $evaluation = $task->evalue->first();

                                        $intern = $task->intern != null ? $task->intern->lastname . ' ' . $task->intern->firstname : 'Personne';
                                        $status = App\Http\Controllers\BasicController::status($task->status);
                                    @endphp
                                    <div class="col-12 mb-5">
                                        <h6 class="mb-0">Tâche N° : {{ $task->id }}</h6>
                                        <p class="mb-0"> {{ $task->label }} - <span
                                                class="status-btn  {{ $status['type'] }}-btn">
                                                {{ $status['message'] }} </span></p>
                                        <p class="mb-0"> {{ $task->begin }} - {{ $task->end }} </p>
                                        <p class="mb-0"> {{ $evaluation->note ?? '-' }} / 20</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif





@endsection

@push('scripts')
    <script src="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.bundle.js"></script>
    <script>
        // options with default values
        const options = {
            defaultTabId: 'profile',
            activeClasses: 'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-400 border-blue-600 dark:border-blue-500',
            inactiveClasses: 'text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300',
            onShow: () => {
                console.log('tab is shown');
            }
        };
    </script>
@endpush
