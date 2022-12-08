@extends('layouts.auth')

@section('content')
    <section class="signin-section">
        <div class="container-fluid">
            <div class="row g-0 auth-row">
                <div class="col-lg-6">
                    <div class="auth-cover-wrapper bg-primary-100">
                        <div class="auth-cover">
                            <div class="title text-center">
                                <p class=" flex justify-center">
                                    <a href="{{ route('home') }}">
                                        <img src="{{ asset('admin/images/logo/logo.png') }}" alt="logo" />
                                    </a>
                                </p>
                                <p class="text-medium">
                                    Améliorez la gestion des stages en entreprise.
                                    <br class="d-sm-block" />
                                    Une solution pensée pour vous, entreprise & stagiaire.
                                </p>
                            </div>
                            <div class="cover-image">
                                <img src="{{ asset('admin/images/auth/signin-image.svg') }}" alt="" />
                            </div>
                            <div class="shape-image">
                                <img src="{{ asset('admin/images/auth/shape.svg') }}" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-lg-6">
                    <div class="signup-wrapper">
                        <div class="form-wrapper">
                            <h6 class="mb-15">Inscription</h6>
                            <p class="text-sm mb-25">
                                Gérez mieux vos stages.
                            </p>

                            @include('layouts.flash')
                            <br>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-style-1">
                                            <label>Nom</label>
                                            <input name="lastname" type="text" placeholder="Nom" />
                                            @error('lastname')
                                                <span style="color: red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-style-1">
                                            <label>Prénom</label>
                                            <input name="firstname" type="text" placeholder="Prénom" />
                                            @error('firstname')
                                                <span style="color: red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-12">
                                        <div class="input-style-1">
                                            <label>Email</label>
                                            <input name="email" type="email" placeholder="Email" />
                                            @error('email')
                                                <span style="color: red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-style-1">
                                            <label>Téléphone</label>
                                            <input name="phone" type="tel" placeholder="Téléphone" />
                                            @error('phone')
                                                <span style="color: red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-12">
                                        <div class="input-style-1">
                                            <label>Mot de Passe</label>
                                            <input name="password" type="password" placeholder="******" />
                                            @error('password')
                                                <span style="color: red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-style-1">
                                            <label>Confirmer Mot de Passe</label>
                                            <input name="password_confirmation" type="password" placeholder="******" />
                                            @error('password_confirmation')
                                                <span style="color: red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-12">
                                        <div class="form-check checkbox-style mb-30">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="checkbox-not-robot" required />
                                            <label class="form-check-label" for="checkbox-not-robot">
                                                Je ne suis pas un robot</label>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-12">
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
                                                Valider
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </form>
                            <div class="singup-option pt-10">

                                <p class="text-sm text-medium text-dark text-center">
                                    Vous avez déjà un compte ? <a href="{{ route('login') }}">Connexion</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </section>
@endsection
