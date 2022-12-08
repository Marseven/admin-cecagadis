@extends('layouts.admin')

@php
    $user = Auth::user();
@endphp

@section('content')
    <!-- ========== tab components start ========== -->
    <section class="tab-components">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title mb-30">
                            <h2>Projet</h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper mb-30">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#0">Tableau de Bord</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#0">Projet</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Ajouter
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== title-wrapper end ========== -->

            <!-- ========== form-elements-wrapper start ========== -->
            <div class="form-elements-wrapper">
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        <!-- input style start -->
                        <div class="card-style mb-30">
                            <h6 class="mb-25">Ajouter un Projet</h6>
                            <form method="POST" action="{{ route('admin-create-project') }}" enctype="multipart/form-data">
                                @csrf
                                <!-- end input -->
                                <div class="input-style-3">
                                    <input name="label" type="text" placeholder="Titre de Projet" />
                                    <span class="icon"><i class="lni lni-bullhorn"></i></span>
                                </div>
                                <!-- end input -->
                                <div class="input-style-3">
                                    <textarea name="description" placeholder="Description du projet" rows="5"></textarea>
                                    <span class="icon"><i class="lni lni-text-format"></i></span>
                                </div>
                                <!-- end input -->
                                <div class="input-style-3">
                                    <input name="begin" type="date" placeholder="Date de Début" />
                                    <span class="icon"></span>
                                </div>
                                <!-- end input -->
                                <div class="input-style-3">
                                    <input name="end" type="date" placeholder="Date de Fin" />
                                    <span class="icon"></span>
                                </div>
                                <!-- end input -->
                                <div class="input-style-3">
                                    <input name="departement" type="text" placeholder="Département" />
                                    <span class="icon"><i class="lni lni-bookmark"></i></span>
                                </div>
                                <!-- end input -->
                                @if ($user->security_role_id <= 3)
                                    <div class="select-style-2">
                                        <div class="select-position">
                                            <select name="supervisor_id">
                                                <option value="">Sélectionner le superviseur</option>
                                                @foreach ($superviseurs as $superviseur)
                                                    <option value="{{ $superviseur->id }}">
                                                        {{ $superviseur->lastname . ' ' . $superviseur->firstname }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- end input -->
                                @elseif($user->security_role_id == 3)
                                    <input name="supervisor_id" type="hidden" value="{{ $user->id }}" />
                                @endif

                                <div class="select-style-2">
                                    <div class="select-position">
                                        <select name="intern_id">
                                            <option value="">Sélectionner le stagiaire</option>
                                            @foreach ($interns as $intern)
                                                <option value="{{ $intern->id }}">
                                                    {{ $intern->lastname . ' ' . $intern->firstname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- end input -->

                                <div class="row">
                                    <div class="col-6">
                                        <div
                                            class="
                            button-group
                            d-flex
                            justify-content-center
                            flex-wrap
                          ">
                                            <button
                                                class="
                              main-btn
                              primary-btn
                              btn-hover
                              w-100
                              text-center
                            "
                                                type="submit">
                                                Enregister
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div
                                            class="
                            button-group
                            d-flex
                            justify-content-center
                            flex-wrap
                          ">
                                            <button
                                                class="
                              main-btn
                              danger-btn
                              btn-hover
                              w-100
                              text-center
                            "
                                                type="reset">
                                                Annuler
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </form>

                        </div>
                        <!-- end card -->
                        <!-- ======= input style end ======= -->
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- ========== form-elements-wrapper end ========== -->
        </div>
        <!-- end container -->
    </section>
    <!-- ========== tab components end ========== -->
@endsection
