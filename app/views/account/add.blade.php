@extends('account.accountapp')

@section('title')
Lake Doctors Add Account
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body sdg_zero_bounce sdg_flex">
                    <div class="col-md-4 sdg_tool_panel sdg_stretch _flex_order_2 sdg_no_bmp">
                        <div class="act_head">
                            <h2>Add Account</h2>
                            <p>Here you can add account.</p>
                        </div>
                        @if(false)
                        <div class="col-xs-12 col-sm-12 sdg_no_bmp" id="sidebar-left">
                            <ul class="nav main-menu">
                                {{--<li>--}}
                                    {{--<a  style="font-size: 16px; padding-left: 25px;" class="ajax-link" href="/account/">--}}
                                        {{--<i style="padding-right:15px;" class="fa fa-dashboard"></i>--}}
                                        {{--<span class="hidden-xs">Account Info</span>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                <li class="dropdown" style="display:none">
                                    <a  style="font-size: 16px; padding-left: 25px;" class="dropdown-toggle active-parent" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                        <i style="padding-right:15px;" class="fa fa-bar-chart-o"></i>
                                        <span class="hidden-xs">Reports</span>
                                    </a>
                                    <div class="collapse" id="collapseExample">
                                        <div class="well">
                                            <ul class="nav sid-nav" style="display: block;">
                                                <li><a style="font-size: 16px; padding-left: 10px;" href="/account/report/field" class="ajax-link">Field Activity</a></li>
                                                <li><a style="font-size: 16px; padding-left: 10px;" href="#" class="ajax-link">Materials Usage</a></li>
                                                <li><a style="font-size: 16px; padding-left: 10px;" href="#" class="ajax-link">Customer Activity</a></li>
                                                <li><a style="font-size: 16px; padding-left: 10px;" href="#" class="ajax-link">Treatment / Biologist</a></li>
                                                <li><a style="font-size:16px;padding-left:10px" href="/account/report/expiration_list" class="ajax-link">Account Expiration</a></li>
                                                <li><a style="font-size:16px;padding-left:10px" href="/print/cpr/{{ $id }}" class="ajax-link">Customer Profile</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown"  style="display:none">
                                    <a  style="font-size:16px;padding-left:25px" class="dropdown-toggle active-parent" data-toggle="collapse" href="#addCollapse" aria-expanded="false" aria-controls="addCollapse">
                                        <i style="padding-right:15px" class="fa fa-edit"></i>
                                        <span class="hidden-xs">Edit</span>
                                    </a>
                                    <div class="collapse" id="addCollapse">
                                        <div class="well">
                                            <ul class="nav sid-nav" style="display: block;">
                                                <li><a href="/account/edit/{{ $id }}" class="ajax-link">This Account</a></li>
                                                <li><a href="/account/report/field" class="ajax-link">Field Activity</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-8 sdg_stretch sdg_btm_bump _flex_order_2">
                        <div class="_flex _flex_stretch">
                            <div class="col-md-8 sdg_no_l_bump">
                                <h2>Account Number Pending</h2>
                            </div>
                        </div>
                        <form id="edit-form" method="post" action="/account/create" class="form-horizontal">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            {{--primary address--}}
                            @include('partials.accounts.new.primary-address-form')
                            {{--contact Name--}}
                            @include('partials.accounts.new.contact-form')
                            {{--budget --}}
                            @include('partials.accounts.new.budget-form')
                            {{--date--}}
                            @include('partials.accounts.new.dates-form')
                            {{--status--}}
                            @include('partials.accounts.new.status-form')
                            {{--services--}}
                            @include('partials.accounts.new.services-form')
                            {{--office--}}
                            @include('partials.accounts.new.office-form')
                            {{--salesman--}}
                            @include('partials.accounts.new.salesmen-form')
                            {{--notes--}}
                            @include('partials.accounts.new.notes-form')
                            {{--tech warning--}}
                            @include('partials.controls.tech-warning')
                            {{--control buttons--}}
                            @include('partials.controls.add-cancel-form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    @include('breadcrumbs.breadcrumbs')
</div>
@endsection

@section('scripts')
<script src="<?php echo asset( '/js/edit.backend.js' ); ?>" type="text/javascript"></script>
@endsection