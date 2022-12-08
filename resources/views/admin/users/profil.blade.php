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
                            <h2>{{ $user->lastname }}</h2>
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
                                    <li class="breadcrumb-item"><a href="#0">Utilisateur</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Profil
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
            <form method="POST" action="{{ url('admin/update-user/' . $user->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row card-style settings-card-1 mb-30">
                    <div class="col-md-3 border-right settings-card-1">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5 profile-info">
                            <div class="profile-image align-items-center">
                                <img src="{{ asset($user->picture != null ? $user->picture : 'admin/images/profile/placeholder.png') }}"
                                    alt="" width="50%">

                            </div>
                            <br>
                            <span class="font-weight-bold">{{ $user->lastname . ' ' . $user->firstname }}</span><span
                                class="text-black-50">{{ $user->SecurityRole->name }}</span><span> </span>
                        </div>
                    </div>
                    <div class="col-md-5 border-right">
                        <div class="p-3 py-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right">Profil</h4>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6"><label class="labels">Nom</label><input type="text"
                                        class="form-control" name="lastname" placeholder="Nom"
                                        value="{{ $user->lastname }}"></div>

                                <div class="col-md-6"><label class="labels">Prénom</label><input type="text"
                                        class="form-control" name="firstname" value="{{ $user->firstname }}"
                                        placeholder="Prénom"></div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12 mb-3"><label class="labels">Email</label><input type="text"
                                        class="form-control" name="email" placeholder="Emailr"
                                        value="{{ $user->email }}">
                                </div>

                                <div class="col-md-12 mb-3"><label class="labels">Téléphone</label><input type="text"
                                        class="form-control" name="phone" placeholder="Téléphone"
                                        value="{{ $user->phone }}">
                                </div>

                                <div class="col-md-12 mb-3"><label class="labels">Addresse</label><input type="text"
                                        class="form-control" name="adress" placeholder="Adresse"
                                        value="{{ $user->adress }}">
                                </div>

                                <div class="col-md-12 mb-3"><label class="labels">Date de Naissance</label><input
                                        type="date" class="form-control" name="birthday" placeholder="Date de Naissance"
                                        value="{{ $user->birthday }}"></div>

                                <div class="col-md-12 mb-3"><label class="labels">Lieu de Naissance</label><input
                                        type="text" class="form-control" name="birthplace"
                                        placeholder="Lieu de Naissance" value="{{ $user->birthplace }}"></div>
                                <div class="col-md-12 mb-3">
                                    <label class="labels">Photo d'identité</label>
                                    <input name="picture" type="file" class="form-control">
                                </div>
                            </div>
                            <div class="mt-5 text-center"><button class="btn btn-success"
                                    style="background-color: #2b9753 !important;" type="submit">Enregistrer</button></div>

                        </div>
                    </div>
                    @if ($entreprise != null)
                        <div class="col-md-4">
                            <div class="p-3 py-5">
                                <div class="d-flex justify-content-between align-items-center experience">
                                    <h4>
                                        Entreprise</h4>
                                </div><br>
                                <ul>
                                    <li>Nom : <strong>{{ $entreprise->name }}</strong></li>
                                    <br>
                                    <li>Email : <strong>{{ $entreprise->email }}</strong></li>
                                    <br>
                                    <li>Téléphone : <strong>{{ $entreprise->phone }}</strong></li>
                                    <br>
                                    <li>Adresse : <strong>{{ $entreprise->adress }}</strong></li>
                                </ul>

                            </div>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </section>
@endsection
