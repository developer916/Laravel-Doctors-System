@extends('account.accountapp')

@section('title')
Lake Doctors Account #####
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="panel-body sdg_zero_bounce sdg_flex">
                    <div class="col-md-4 sdg_tool_panel sdg_stretch _flex_order_2 sdg_no_bmp">
                        <div class="act_head">
                            <h2>Account Details</h2>
                            <p>
                                You can edit account info at any time. The top of the page will give you all important up to date account information. Below you can click to run reports that are specific to this account.
                            </p>
                        </div>

                        <div class="col-xs-12 col-sm-12 sdg_no_bmp" id="sidebar-left">
                            <ul class="nav main-menu">
                                <li>
                                    <a class="ajax-link" href="#">
                                        <i class="fa fa-dashboard"></i>
                                        <span class="hidden-xs">Account Info</span>
                                    </a>
                                </li>

                                <li class="dropdown">
                                    <a class="dropdown-toggle active-parent" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                        <i class="fa fa-bar-chart-o"></i>
                                        <span class="hidden-xs">Reports</span>
                                    </a>
                                    <div class="collapse" id="collapseExample">
                                        <div class="well">
                                            <ul class="nav sid-nav" style="display: block;">
                                                <li><a href="#" class="ajax-link">Field Activity</a></li>
                                                <li><a href="#" class="ajax-link">Materials Usage</a></li>
                                                <li><a href="#" class="ajax-link">Customer Activity</a></li>
                                                <li><a href="#" class="ajax-link">Treatment / Biologist</a></li>
                                                <li><a href="#" class="ajax-link">Account Expiration</a></li>
                                                <li><a href="#" class="ajax-link">Customer Profile</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle active-parent" data-toggle="collapse" href="#collapseExample1" aria-expanded="false" aria-controls="collapseExample">
                                        <i class="fa fa-edit"></i>
                                        <span class="hidden-xs">Edit</span>
                                    </a>
                                    <div class="collapse" id="collapseExample1">
                                        <div class="well">
                                            <ul class="nav sid-nav" style="display: block;">
                                                <li><a href="/account/edit/{{ $id }}" class="ajax-link">This Account</a></li>
                                                <li><a href="#" class="ajax-link">Field Activity</a></li>

                                            </ul>
                                        </div>
                                    </div>

                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-7 col-md-offset-1 sdg_stretch sdg_btm_bump _flex_order_2">
                        <div class="_flex _flex_stretch">
                            <div class="col-md-8 sdg_no_l_bump">
                                <h2>Manage Account</h2>
                            </div>
                            <div class="col-md-4 pull-right _flex _flex_v_center _flex_end" >
                                <span class="act_tools act_tool_search" title="Look up another account">
                                    <i class="fa fa-lg fa-search"></i>
                                </span>
                                <a href="/account/edit/{{ $id }}">
                                <span class="act_tools act_tool_edit" title="Edit this account">
                                    <i class="fa fa-lg fa-edit"></i>
                                </span></a>
                                <span class="act_tools act_tool_add" title="Add new account">
                                    <i class="fa fa-lg fa-plus"></i>
                                </span>
                                <span class="act_tools act_tool_remove" title="Delete this account">
                                    <i class="fa fa-lg fa-remove"></i>
                                </span>                        
                            </div>
                        </div>
                        <p>Below is the account information for the selected account.</p>
                        <div class="col-md-10">
                            <ul class="account-sum-block">
                                <li>
                                    <span style='color:green;'><i class="fa fa-check-circle"></i></span>
                                    <span class="act-sum-header">Company: </span>
                                    <span>{{ $act_name }}</span>
                                </li>
                                <li>
                                    <span style='color:green;'><i class="fa fa-check-circle"></i></span>
                                    <span class="act-sum-header">Status: </span>
                                    <span>{{ ($act_status != ''?$act_status: 'Last Treated June 17, 2015') }}</span>
                                </li>
                                <li>
                                    <span style='color:green;'><i class="fa fa-check-circle"></i></span>
                                    <span class="act-sum-header">Billing Amt: </span>
                                    <span>${{ $act_billing_amount }}</span>
                                </li>
                                <li>
                                    <span style='color:green;'><i class="fa fa-check-circle"></i></span>
                                    <span class="act-sum-header">End Date: </span>
                                    <span>{{ date("m/d/Y", strtotime(date("m/d/Y", strtotime($act_end_ date)) . " + 365 day")) }}</span>
                                    </li>
                                <li>
                                    <span style='color:green;'><i class="fa fa-check-circle"></i></span>
                                    <span class="act-sum-header">Contact Name: </span>
                                    <span>{{ $act_contact_two }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-10 edit-box">
                            <h4>Account</h4>
                            <hr>
                            <label>{{ $id }}</label>
                        </div>
                        <div class="col-md-10 edit-box">
                            <h4>Monthly Budget</h4>
                            <hr>
                            <input name="monthly_budget" type ='text' value="{{ $act_budget }}" placeholder="xx.xx">
                        </div>

                        <div class="col-md-10 edit-box">
                            <h4>Billing Amount</h4>
                            <hr>
                            <input name="billing_amount" type ='text' value="{{ $act_billing_amount }}" placeholder="xx.xx">
                        </div>
                        <div class="col-md-10 edit-box">
                            <h4>Billing Address</h4>
                            <hr>
                            <span>{{ $act_address }}</span><br />
                            <span>{{ $act_address2 }}</span><br />
                            <span>{{ $act_city . ', '. $act_state . ' ' . $act_zip }}</span><br />

                        </div>
                        <div class="col-md-10">
                            <hr>
                            <div class="col-md-4 pull-right _flex _flex_v_center _flex_end" >
                                <span class="act_tools act_tool_remove fa-stack fa-lg " title="Cancle">
                                    <i class="fa fa-square fa-stack-2x"></i>
                                    <i class="fa fa-remove fa-stack-1x fa-inverse"></i>
                                </span>
                                <span class="act_tools act_tool_add  fa-stack fa-lg" title="Save Changes">
                                    <i class="fa fa-square fa-stack-2x"></i>
                                    <i class="fa fa-check fa-stack-1x fa-inverse"></i>
                                </span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="<?php echo asset( '/js/app.backend.js' ); ?>" type="text/javascript"></script>
<script src="<?php echo asset( '/js/jquery.mask.min.js' ); ?>" type="text/javascript"></script>
@endsection