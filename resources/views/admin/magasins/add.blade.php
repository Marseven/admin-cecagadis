@extends('layouts.admin')

@section('content')
    <!-- ========== tab components start ========== -->
    <section class="tab-components">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title mb-30">
                            <h2>Entreprise</h2>
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
                                    <li class="breadcrumb-item"><a href="#0">Entreprise</a></li>
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
                            <h6 class="mb-25">Ajouter une Entreprise</h6>
                            <form method="POST" action="{{ route('admin-create-entreprise') }}">
                                @csrf
                                <!-- end input -->
                                <div class="input-style-3">
                                    <input name="name" type="text" placeholder="Nom de l'entreprise" />
                                    <span class="icon"><i class="lni lni-linkedin"></i></span>
                                </div>
                                <!-- end input -->
                                <!-- end input -->
                                <div class="input-style-3">
                                    <input name="email" type="text" placeholder="Email" />
                                    <span class="icon"><i class="lni lni-envelope"></i></span>
                                </div>
                                <!-- end input -->
                                <!-- end input -->
                                <div class="input-style-3">
                                    <input name="phone" type="tel" placeholder="Téléphone" />
                                    <span class="icon"><i class="lni lni-phone"></i></span>
                                </div>
                                <!-- end input -->
                                <!-- end input -->
                                <div class="input-style-3">
                                    <input name="adress" type="text" placeholder="Adresse" />
                                    <span class="icon"><i class="lni lni-map-marker"></i></span>
                                </div>
                                <!-- end input -->

                                <!-- end input -->
                                <div class="select-style-2">
                                    <div class="select-position">
                                        <select name="manager">
                                            <option value="">Sélectionner Gérant</option>
                                            @foreach ($managers as $manager)
                                                <option value="{{ $manager->id }}">
                                                    {{ $manager->lastname . ' ' . $manager->firstname }}</option>
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
