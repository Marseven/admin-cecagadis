@extends('layouts.admin')

@push('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@php
    $user_connect = Auth::user();
@endphp

@section('content')
    <!-- ========== table components start ========== -->
    <section class="table-components">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title mb-30">
                            <h2>Superviseurs</h2>
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
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Liste des Superviseurs
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

            <!-- ========== tables-wrapper start ========== -->
            <div class="tables-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-style mb-30">
                            <h6 class="mb-10">Liste des Superviseurs <a href="{{ url('admin/add-user') }}"
                                    class="main-btn primary-btn rounded-sm btn-hover float-right">+ Ajouter</a></h6>
                            <p class="text-sm mb-20">

                            </p>
                            <div class="table-wrapper table-responsive">
                                <table class="table" id="kt_datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nom & Prénoms</th>
                                            <th>Email</th>
                                            <th>Téléphone</th>
                                            @if ($user_connect->security_role_id <= 2)
                                                <th>Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($superviseurs as $superviseur)
                                            <tr>
                                                <td>{{ $superviseur->id }}</td>
                                                <td>{{ $superviseur->lastname . ' ' . $superviseur->firstname }}</td>
                                                <td>{{ $superviseur->email }}</td>
                                                <td>{{ $superviseur->phone }}</td>

                                                @if ($user_connect->security_role_id <= 2)
                                                    <td>
                                                        <button class="btn btn-xs btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#cardModal{{ $superviseur->id }}">Voir</button>
                                                        <button class="btn btn-xs btn-warning" data-bs-toggle="modal"
                                                            data-bs-target="#cardModal{{ $superviseur->id }}">Modifier</button>
                                                        <button class="btn btn-xs btn-danger" data-bs-toggle="modal"
                                                            data-bs-target="#cardModalCenter{{ $superviseur->id }}">
                                                            Supprimer
                                                        </button>

                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- end table -->
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== tables-wrapper end ========== -->
        </div>
        <!-- end container -->
    </section>
    <!-- ========== table components end ========== -->

    @foreach ($superviseurs as $superviseur)
        <div class="modal fade" id="cardModal{{ $superviseur->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabelOne" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabelOne">Mettre à jour le superviseur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="lni lni-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('admin/update-user/' . $superviseur->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label>Nom</label>
                                    <input name="lastname" type="text" placeholder="Nom"
                                        value="{{ $superviseur->lastname }}" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label>Prénom</label>
                                    <input name="firstname" type="text" placeholder="Prénom"
                                        value="{{ $superviseur->firstname }}" />
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label>Email</label>
                                    <input name="email" type="email" placeholder="Email"
                                        value="{{ $superviseur->email }}" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label>Téléphone</label>
                                    <input name="phone" type="tel" placeholder="Téléphone"
                                        value="{{ $superviseur->phone }}" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Rôle</label>
                                <select id="selectOne" class="form-control" name="security_role_id">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" style="background-color: #2b9753 !important;"
                            class="btn btn-success">Enregistrer</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($superviseurs as $superviseur)
        <!-- Modal -->
        <div class="modal fade" id="cardModalCenter{{ $superviseur->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Suppression</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        Êtes-vous sûr de vouloir supprimer ce superviseur ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
                        <form method="POST" action="{{ url('admin/update-user/' . $superviseur->id) }}">
                            @csrf
                            <input type="hidden" name="delete" value="true">
                            <button class="btn btn-danger" style="background-color: #D50100 !important;"
                                type="submit"><i class="me-2 icon-xxs dropdown-item-icon"
                                    data-feather="trash-2"></i>Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    <script src="{{ asset('admin/js/jquery-3.5.1.min.js') }}"></script>
    <!--begin::Page Vendors(used by this page)-->
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Page Vendors-->

    <script>
        $(document).ready(function() {
            $('#kt_datatable').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
                }
            });
        });
    </script>
@endpush
