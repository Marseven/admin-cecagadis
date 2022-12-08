@extends('layouts.auth')

@section('content')
    <!-- ========== signin-section start ========== -->
    <div class="container-fluid plr_30 body_white_bg pt_30">
        <div class="row justify-content-center body_white_bg mt_50">
            <div class="col-lg-12">
                <div class="white_box mb_30">
                    <div class="row justify-content-center">
                        <div class="row justify-content-center">
                            <img class="mb_30" src="{{ asset('admin/img/ceca.png') }}" alt="logo"
                                style="width: 10%; heigth: auto;" />
                        </div>
                        <div class="col-lg-6">

                            <div class="modal-content cs_modal">
                                <div class="modal-header">
                                    <h5 class="modal-title">Mot de Passe Oublié ?</h5>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="">
                                            <input type="email" name="email" class="form-control"
                                                placeholder="Entrez votre email" value="{{ old('email') }}">
                                        </div>
                                        <button type="submit" class="btn_1 full_width text-center">Envoyez</button>
                                        <div class="text-center">
                                            <a href="{{ route('login') }}" class="pass_forget_btn">Vous avez un compte ?
                                                Connectez-vous</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="footer_iner text-center">
                        <p>2022 © CECA GADIS - Designé Par<a href="#"> Dan Marvhine Mavoungou</a></p>
                        <br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ========== signin-section end ========== -->
@endsection
