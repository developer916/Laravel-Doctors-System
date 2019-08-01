@extends('dash.app')


@section('styles')
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

@endsection

@section('content')
    <div class="row">
        <div class="hidden-xs hidden-sm" style="height:50px;">

        </div>
    </div>
    <aside id="left_side" class="left"></aside>
    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="navbar-right">
                <span class="nav-bump"><strong>Welcome, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</strong></span>
                <span class="nav-bump"><a><strong>Who's Online(0)</strong></a></span>
                <span><a href='/auth/logout'>Sign Out</a></span>
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1" style="margin-top:15px">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('success') }}
            </div>
            @endif
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body" style="min-height:350px">
                        <div>
                            <h2>How can we help you?</h2>
                        </div>
                        <div class="_flex _flex_wrap _flex_around _flex_h_around menu-target">
                            @if(isset($me['16']) && $me['16'])
                                <a href="#account" aria-controls="account" role="tab" data-toggle="tab"
                                   data-control="account" data-menu="Account">
                                    <div class="big_nav_btn" data-toggle="modal" data-target="#work_area">
                                        <div class="">
                                            <img alt="Accounts" src="img/largeicon_accounts.png"/>
                                        </div>
                                        <strong>Accounts</strong>
                                    </div>
                                </a>
                            @endif
                            @if(isset($me['23']) && $me['23'])
                                <a href="#field" aria-controls="field" role="tab" data-toggle="tab" data-control="field"
                                   data-menu="Field Activity">
                                    <div class="big_nav_btn" data-toggle="modal" data-target="#work_area">
                                        <div class="">
                                            <img alt="Accounts" src="img/largeicon_field.png"/>
                                        </div>
                                        <strong>Field Activity</strong>
                                    </div>
                                </a>
                            @endif

                            @if(isset($me['24']) && $me['24'])
                                <a href="#inventory" aria-controls="materials" role="tab" data-toggle="tab"
                                   data-control="inventory" data-menu="Inventory">
                                    <div class="big_nav_btn" data-toggle="modal" data-target="#work_area">
                                        <div class="">
                                            <img alt="Accounts" src="img/largeicon_materials.png"/>
                                        </div>
                                        <strong>Inventory</strong>

                                    </div>
                                </a>
                            @endif

                            @if(isset($me['27']) && $me['27'])
                                <a href="#utility" aria-controls="utility" role="tab" data-toggle="tab"
                                   data-control="utility" data-menu="Utilities">
                                    <div class="big_nav_btn" data-toggle="modal" data-target="#work_area">
                                        <div class="">
                                            <img alt="Accounts" src="img/largeicon_utilities.png"/>
                                        </div>
                                        <strong>Utilities</strong>
                                    </div>
                                </a>

                                <a href="#technicians" aria-controls="technicians" role="tab" data-toggle="tab"
                                   data-control="technicians" data-menu="Technicians">
                                    <div class="big_nav_btn" data-toggle="modal" data-target="#work_area">
                                        <div class="">
                                            <img alt="Accounts" src="img/largeicon_technicians.png"/>
                                        </div>
                                        <strong>Technicians</strong>
                                    </div>
                                </a>
                            @endif
                            @if(isset($me['19']) && $me['19'])
                                <a href="#reports" aria-controls="reports" role="tab" data-toggle="tab"
                                   data-control="reports" data-menu="Reports">
                                    <div class="big_nav_btn" data-toggle="modal" data-target="#work_area">
                                        <div class="">
                                            <img alt="Accounts" src="img/largeicon_reports.png"/>
                                        </div>
                                        <strong>Reports</strong>
                                    </div>
                                </a>
                            @endif

                            @if( isset($me['29']) && $me['29'] )
                                <a href="#worksheet" aria-controls="inventory" role="tab" data-toggle="tab"
                                   data-control="worksheet" data-menu="Worksheets">
                                    <div class="big_nav_btn" data-toggle="modal" data-target="#work_area">
                                        <div class="">
                                            <img alt="Accounts" src="img/largeicon_inventory.png"/>
                                        </div>
                                        <strong>Worksheets</strong>
                                    </div>
                                </a>
                            @endif

                            <?php if ( Auth::user()->level < 5 ) { ?>
                                <a href="#users" aria-controls="users" role="tab" data-toggle="tab" data-control="users"
                                   data-menu="Users">
                                    <div class="big_nav_btn" data-toggle="modal" data-target="#work_area">
                                        <div class="">
                                            <img alt="Accounts" src="img/largeicon_accounts.png"/>
                                        </div>
                                        <strong>Users</strong>
                                    </div>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('breadcrumbs.breadcrumbs')
            </div>
        </div>
    </div>
@endsection

@section('footer')

@endsection

@section('scripts')
    <script src="{{asset('/js/app.backend.js')}}" type="text/javascript"></script>
@endsection