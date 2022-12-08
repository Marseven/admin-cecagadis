@extends('layouts.admin')

@section('content')
    <!-- ========== notification-wrapper start ========== -->
    <div class="notification-wrapper">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title mb-30">
                            <h2>Notifications</h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper mb-30">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#0">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Notifications
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

            <div class="card-style">
                @if ($user->notifications->count() > 0)
                    @foreach ($user->notifications as $notification)
                        <div class="single-notification">

                            <div class="notification">
                                <div class="image warning-bg">
                                    <i class="icon-bell"></i>
                                </div>
                                <a href="#0" class="content">
                                    <h6>{{ $notification->data['title'] }}</h6>
                                    <p class="text-sm text-gray">
                                        {{ $notification->data['content'] }}
                                    </p>
                                    <span
                                        class="text-sm text-medium text-gray">{{ date_format(date_create($notification->data['date']), 'd M Y') }}
                                        <span
                                            class="counter">{{ date_format(date_create($notification->data['date']), 'H:i:s') }}</span></span>
                                </a>
                            </div>
                            <div class="action">

                            </div>
                        </div>
                        <!-- end single notification -->
                    @endforeach
                    @php
                        $user->unreadNotifications->markAsRead();
                    @endphp
                @else
                    <div class="single-notification">

                        <div class="notification">
                            <div class="image warning-bg">
                                <i class="icon-bell"></i>
                            </div>
                            <a href="#0" class="content">
                                <h6>Aucune Notifications</h6>
                                <p class="text-sm text-gray">
                                    Pas de notifications pour le moment.
                                </p>
                            </a>
                        </div>
                        <div class="action">

                        </div>
                    </div>
                    <!-- end single notification -->
                @endif


            </div>
        </div>
        <!-- end container -->
    </div>
    <!-- ========== notification-wrapper start ========== -->
@endsection
