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
                            <h2>Tâches du Projet N° {{ $offer->id }}</h2>
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
                                        Liste des Tâches
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
                            <h6 class="mb-10">Liste des Tâches <a href="#"
                                    class="main-btn primary-btn rounded-sm btn-hover float-right" data-bs-toggle="modal"
                                    data-bs-target="#cardModalAdd">+ Ajouter</a></h6>
                            <p class="text-sm mb-20">

                            </p>
                            <div class="table-wrapper table-responsive">
                                <table id="kt_datatable" class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <h6>#</h6>
                                            </th>
                                            <th>
                                                <h6>Libellé</h6>
                                            </th>
                                            <th>
                                                <h6>Début</h6>
                                            </th>
                                            <th>
                                                <h6>Fin</h6>
                                            </th>
                                            <th>
                                                <h6>Statut</h6>
                                            </th>
                                            <th>
                                                <h6>Action</h6>
                                            </th>
                                        </tr>
                                        <!-- end table row-->
                                    </thead>
                                    <tbody>
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

    <div class="modal fade" id="cardModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelOne"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="modal-content">
            </div>
        </div>
    </div>

    <div class="modal fade" id="cardModalAdd" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelOne">Ajouter une tâche</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="lni lni-close"></i>
                    </button>
                </div>
                <form action="{{ route('admin-create-task') }}" method="POST">
                    <div class="modal-body">
                        <div class="input-style-3">
                            <input name="label" type="text" placeholder="Titre de Projet" />
                            <input name="project_id" type="hidden" value="{{ $project->id }}" />
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
                            <span class="icon"><i class="lni lni-calendar"></i></span>
                        </div>
                        <!-- end input -->
                        <div class="input-style-3">
                            <input name="end" type="date" placeholder="Date de Fin" />
                            <span class="icon"><i class="lni lni-calendar"></i></span>
                        </div>
                        <!-- end input -->
                    </div>
                    <div class="modal-footer">
                        <button style="background-color: #2b9753 !important;" class="btn btn-success"
                            type="submit">Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cardModalView" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelOne"></h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="lni lni-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cardModalCenter" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Suppression</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="lni lni-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer cette tâche ?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
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
                },
                order: [
                    [0, "desc"]
                ],
                processing: true,
                serverSide: true,
                ajax: "{{ url('admin/ajax-tasks/' . $project->id) }}",
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'label'
                    },
                    {
                        data: 'begin'
                    },
                    {
                        data: 'end'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'actions'
                    },
                ]
            });
        });

        $(document).on("click", ".modal_view_action", function() {

            var id = $(this).data('id');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('admin-ajax-task') }}",
                dataType: 'json',
                data: {
                    "id": id,
                    "action": "view",
                },
                success: function(data) {
                    //get data value params
                    var title = data.title;
                    var body = data.body;

                    $('#cardModalView .modal-title').text(title); //dynamic title
                    $('#cardModalView .modal-body').html(body); //url to delete item
                    $('#cardModalView').modal('show');
                }
            });

            //show the modal
        });


        $(document).on("click", ".modal_edit_action", function() {
            var id = $(this).data('id');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('admin-ajax-task') }}",
                dataType: 'json',
                data: {
                    "id": id,
                    "action": "edit",
                },
                success: function(data) {
                    //get data value params
                    var body = data.body;
                    //dynamic title
                    $('#cardModal .modal-content').html(body); //url to delete item
                    $('#cardModal').modal('show');
                }
            });

        });

        $(document).on("click", ".modal_evalue_action", function() {
            var id = $(this).data('id');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('admin-ajax-task') }}",
                dataType: 'json',
                data: {
                    "id": id,
                    "action": "evalue",
                },
                success: function(data) {
                    //get data value params
                    var body = data.body;
                    //dynamic title
                    $('#cardModal .modal-content').html(body); //url to delete item
                    $('#cardModal').modal('show');
                }
            });

        });

        $(document).on("click", ".modal_delete_action", function() {
            var id = $(this).data('id');
            var bank = $(this).data('bank');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('admin-ajax-task') }}",
                dataType: 'json',
                data: {
                    "id": id,
                    "action": "delete",
                },
                success: function(data) {
                    //get data value params
                    var body = data.body;
                    //dynamic title
                    $('#cardModalCenter .modal-footer').html(body); //url to delete item
                    $('#cardModalCenter').modal('show');
                }
            });
        });
    </script>
@endpush
