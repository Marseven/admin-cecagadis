@extends('layouts.auth')

@section('content')
    <!-- ========== signin-section start ========== -->
    <div class="container-fluid plr_30 body_white_bg pt_30">
        <div class="row justify-content-center body_white_bg mt_50">
            <div class="col-lg-12">
                <div class="white_box mb_30">
                    <div class="row justify-content-center">
                        <img class="mb_30" src="{{ asset('admin/img/ceca.png') }}" alt="logo"
                            style="width: 10%; heigth: auto;" />
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-6">

                            <div class="modal-content cs_modal">
                                <div class="modal-header">
                                    <h5 class="modal-title">Mot de Passe Oublié ?</h5>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('password.update') }}">
                                        @csrf
                                        <input value="{{ $request->token }}" type="hidden" name="token" />
                                        <div class="">
                                            <input type="text" name="email" class="form-control" placeholder="Email"
                                                value="{{ old('email') }}">
                                            @error('email')
                                                <span style="color: red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="">
                                            <input type="password" name="password" class="form-control"
                                                placeholder="Mot de Passe" value="{{ old('password') }}">
                                            @error('password')
                                                <span style="color: red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="">
                                            <input type="password" name="password_confirmation" class="form-control"
                                                placeholder="Confirmer Mot de Passe"
                                                value="{{ old('password_confirmation') }}">
                                            @error('password_confirmation')
                                                <span style="color: red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn_1 full_width text-center">Réinitaliser</button>
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
