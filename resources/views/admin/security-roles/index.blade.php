@extends('layouts.admin')

@push('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <!-- ========== table components start ========== -->
    <section class="table-components">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title mb-30">
                            <h2>Rôles</h2>
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
                                        Liste des Rôles
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
                            <h6 class="mb-10">Liste des Rôles <a data-bs-toggle="modal" data-bs-target="#securityModal"
                                    class="main-btn primary-btn rounded-sm btn-hover float-right">+ Ajouter</a></h6>
                            <p class="text-sm mb-20">

                            </p>
                            <div class="table-wrapper table-responsive">
                                <table class="table" id="kt_datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Libellé</th>
                                            <th>Espace</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                            @php
                                                $role->load(['object']);
                                            @endphp
                                            <tr>
                                                <td>{{ $role->id }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>{{ $role->object ? $role->object->name : 'NULL' }}</td>
                                                <td>
                                                    <button class="btn btn-xs btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#cardModalView{{ $role->id }}">Voir</button>
                                                    <button class="btn btn-xs btn-dark" data-bs-toggle="modal"
                                                        data-bs-target="#cardModal{{ $role->id }}">Modifer</button>
                                                    <button class="btn btn-xs btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#cardModalCenter{{ $role->id }}">
                                                        Supprimer
                                                    </button>

                                                </td>
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

    @foreach ($roles as $role)
        <div class="modal fade" id="cardModalView{{ $role->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabelOne" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabelOne">{{ $role->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="lni lni-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive mb-3">
                            <table class="table text-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th class="w-75">Permissions du rôle</th>
                                        <th><i class="lni lni-eye"></i></th>
                                        <th><i class="lni lni-plus"></i></th>
                                        <th><i class="lni lni-pencil"></i></th>
                                        <th><i class="lni lni-trash-can"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rolepermissions as $permission)
                                        @if ($permission->security_role_id == $role->id)
                                            <tr>

                                                <td class="border-top-0">
                                                    {{ $permission->name }}
                                                </td>
                                                <td class="border-top-0">
                                                    <div class="form-check ">
                                                        <input type="checkbox"
                                                            {{ $permission->look == 'on' ? 'checked' : '' }} disabled
                                                            class="form-check-input" id="customCheckOne">
                                                        <label class="form-check-label" for="customCheckOne"></label>
                                                    </div>
                                                </td>
                                                <td class="border-top-0">
                                                    <div class="form-check ">
                                                        <input type="checkbox"
                                                            {{ $permission->creat == 'on' ? 'checked' : '' }} disabled
                                                            class="form-check-input" id="customCheckOne">
                                                        <label class="form-check-label" for="customCheckOne"></label>
                                                    </div>
                                                </td>
                                                <td class="border-top-0">
                                                    <div class="form-check ">
                                                        <input type="checkbox"
                                                            {{ $permission->updat == 'on' ? 'checked' : '' }} disabled
                                                            class="form-check-input" id="customCheckTwo">
                                                        <label class="form-check-label" for="customCheckTwo"></label>
                                                    </div>
                                                </td>
                                                <td class="border-top-0">
                                                    <div class="form-check ">
                                                        <input type="checkbox"
                                                            {{ $permission->del == 'on' ? 'checked' : '' }} disabled
                                                            class="form-check-input" id="customCheckThree">
                                                        <label class="form-check-label" for="customCheckThree"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" style="background-color: #2b9753 !important;"
                            class="btn btn-primary">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($roles as $role)
        <div class="modal fade" id="cardModal{{ $role->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabelOne" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabelOne">{{ $role->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="lni lni-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('admin/security-permission/edit/' . $role->id) }}" method="POST">
                            @csrf
                            <div class="table-responsive mb-3">
                                <table class="table text-nowrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="w-75">Permissions du rôle</th>
                                            <th><i class="lni lni-eye"></i></th>
                                            <th><i class="lni lni-plus"></i></th>
                                            <th><i class="lni lni-pencil"></i></th>
                                            <th><i class="lni lni-trash-can"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $permission)
                                            <tr>
                                                <td class="border-top-0">
                                                    {{ $permission->name }}
                                                </td>
                                                <td class="border-top-0">
                                                    <div class="form-check ">
                                                        <input type="checkbox" name="{{ $permission->name }}-view"
                                                            class="form-check-input" id="customCheckOne">
                                                        <label class="form-check-label" for="customCheckOne"></label>
                                                    </div>
                                                </td>
                                                <td class="border-top-0">
                                                    <div class="form-check ">
                                                        <input type="checkbox" name="{{ $permission->name }}-create"
                                                            class="form-check-input" id="customCheckOne">
                                                        <label class="form-check-label" for="customCheckOne"></label>
                                                    </div>
                                                </td>
                                                <td class="border-top-0">
                                                    <div class="form-check ">
                                                        <input type="checkbox" name="{{ $permission->name }}-edit"
                                                            class="form-check-input" id="customCheckTwo">
                                                        <label class="form-check-label" for="customCheckTwo"></label>
                                                    </div>
                                                </td>
                                                <td class="border-top-0">
                                                    <div class="form-check ">
                                                        <input type="checkbox" name="{{ $permission->name }}-delete"
                                                            class="form-check-input" id="customCheckThree">
                                                        <label class="form-check-label" for="customCheckThree"></label>
                                                    </div>
                                                </td>
                                                <input type="hidden" name="role" value="{{ $role->id }}">
                                                <input type="hidden" name="{{ $permission->name }}-permission"
                                                    value="{{ $permission->id }}">

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" style="background-color: #2b9753 !important;"
                            class="btn btn-primary">Enregistrer</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <div class="modal fade" id="securityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelOne"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelOne">Créer un rôle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="lni lni-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('admin/security-role') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="col-form-label">Libellé</label>
                            <input type="text" class="form-control" name="name">
                        </div>

                        <div class="mb-3">
                            <label for="security_object_id" class="col-form-label">Espace</label>
                            <select id="selectOne" class="form-control" name="security_object_id">
                                @foreach ($objects as $object)
                                    <option value="{{ $object->id }}">{{ $object->name }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" style="background-color: #2b9753 !important;"
                        class="btn btn-primary">Enregistrer</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($roles as $role)
        <!-- Modal -->
        <div class="modal fade" id="cardModalCenter{{ $role->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Suppression</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="lni lni-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        Êtes-vous sûr de vouloir supprimer ce rôle ?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger">Supprimer</button>
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
