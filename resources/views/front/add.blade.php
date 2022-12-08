@extends('layouts.admin')

@section('content')
    <div class="main_content_iner ">
        <div class="container-fluid plr_30 body_white_bg pt_30">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="white_box mb_30">
                        <div class="box_header ">
                            <div class="main-title">
                                <h3 class="mb-0">Renseignez les différents Chiffres d'affaires</h3>
                            </div>
                        </div>
                        <form method="POST" action="#">
                            @csrf
                            @php
                                $jour = date('d M Y'); // Notre Date par default

                                $month = strtotime($jour . '- 1 months');

                                $year = strtotime($jour . '- 1 years'); // on peut diminuer de 1 an aussi en specifiant le sign "-"
                            @endphp
                            <div class="mb-3">
                                <label class="form-label" for="sales_day">C.A du {{ $jour }}</label>
                                <input type="number" class="form-control" id="sales_day" placeholder="C.A du Jour">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="sales_month">C.A du {{ date('d M Y', $month) }}</label>
                                <input type="number" class="form-control" id="sales_month" placeholder="C.A du Jour à M-1">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="sales_year">C.A du {{ date('d M Y', $year) }}</label>
                                <input type="number" class="form-control" id="sales_year" placeholder="C.A du Jour à A-1">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn_1 full_width text-center">Enregister</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
