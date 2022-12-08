<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Administration - Ceca Gadis</title>
    <link rel="icon" href="img/logo.png" type="image/png">

    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap1.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/vendors/themefy_icon/themify-icons.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/vendors/swiper_slider/css/swiper.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/vendors/select2/css/select2.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/vendors/niceselect/css/nice-select.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/vendors/owl_carousel/css/owl.carousel.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/vendors/gijgo/gijgo.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/vendors/font_awesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/tagsinput/tagsinput.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/vendors/datatable/css/jquery.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/datatable/css/responsive.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/datatable/css/buttons.dataTables.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/vendors/text_editor/summernote-bs4.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/vendors/morris/morris.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/vendors/material_icon/material-icons.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/css/metisMenu.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/css/style1.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/colors/default.css') }}" id="colorSkinCSS">

    @stack('styles')

</head>

<body class="crm_body_bg body_white_bg">



    <section class="container-fluid body_white_bg">

        @include('layouts.flash')

        @yield('content')
    </section>



    <script src="{{ asset('admin/js/jquery1-3.4.1.min.js') }}"></script>

    <script src="{{ asset('admin/js/popper1.min.js') }}"></script>

    <script src="{{ asset('admin/js/bootstrap1.min.js') }}"></script>

    <script src="{{ asset('admin/js/metisMenu.js') }}"></script>

    <script src="{{ asset('admin/vendors/count_up/jquery.waypoints.min.js') }}"></script>

    <script src="{{ asset('admin/vendors/chartlist/Chart.min.js') }}"></script>

    <script src="{{ asset('admin/vendors/count_up/jquery.counterup.min.js') }}"></script>

    <script src="{{ asset('admin/vendors/swiper_slider/js/swiper.min.js') }}"></script>

    <script src="{{ asset('admin/vendors/niceselect/js/jquery.nice-select.min.js') }}"></script>

    <script src="{{ asset('admin/vendors/owl_carousel/js/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('admin/vendors/gijgo/gijgo.min.js') }}"></script>

    <script src="{{ asset('admin/vendors/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatable/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('admin/js/chart.min.js') }}"></script>

    <script src="{{ asset('admin/vendors/progressbar/jquery.barfiller.js') }}"></script>

    <script src="{{ asset('admin/vendors/tagsinput/tagsinput.js') }}"></script>

    <script src="{{ asset('admin/vendors/text_editor/summernote-bs4.js') }}"></script>
    <script src="{{ asset('admin/vendors/apex_chart/apexcharts.js') }}"></script>

    <script src="{{ asset('admin/js/custom.js') }}"></script>

    <script src="{{ asset('admin/js/active_chart.js') }}"></script>
    <script src="{{ asset('admin/vendors/apex_chart/radial_active.js') }}"></script>
    <script src="{{ asset('admin/vendors/apex_chart/stackbar.js') }}"></script>
    <script src="{{ asset('admin/vendors/apex_chart/area_chart.js') }}"></script>

    <script src="{{ asset('admin/vendors/apex_chart/bar_active_1.js') }}"></script>
    <script src="{{ asset('admin/vendors/chartjs/chartjs_active.js') }}"></script>

    @stack('scripts')

</body>

</html>
