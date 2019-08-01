@extends('account.accountapp')

@section('title')
    Lake Doctors Account {{ $id }}
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
                                    You can edit account info at any time. The top of the page will give you all
                                    important up to date account information. Below you can click to run reports that
                                    are specific to this account.
                                </p>
                            </div>

                            <div class="col-xs-12 col-sm-12 sdg_no_bmp" id="sidebar-left">
                                <ul class="nav main-menu">
                                    <li>
                                        <a style="font-size: 16px; padding-left: 25px;" class="ajax-link"
                                           href="/account/{{ $id }}">
                                            <i style="padding-right:15px;" class="fa fa-dashboard"></i>
                                            <span class="hidden-xs">Account Info</span>
                                        </a>
                                    </li>

                                    <li class="dropdown">
                                        <a style="font-size: 16px; padding-left: 25px;"
                                           class="dropdown-toggle active-parent" data-toggle="collapse"
                                           href="#collapseExample" aria-expanded="false"
                                           aria-controls="collapseExample">
                                            <i style=padding-right:15px;" class="fa fa-bar-chart-o"></i>
                                            <span class="hidden-xs">Reports</span>
                                        </a>

                                        <div class="collapse" id="collapseExample">
                                            <div class="well">
                                                <ul class="nav sid-nav" style="display: block;">
                                                    <li><a style="font-size: 16px; padding-left: 10px;"
                                                           href="/account/report/field/{{ $id }}" class="ajax-link">Field
                                                            Activity</a></li>
                                                    <li><a style="font-size: 16px; padding-left: 10px;" href="#"
                                                           class="ajax-link">Materials Usage</a></li>
                                                    <li><a style="font-size: 16px; padding-left: 10px;" href="#"
                                                           class="ajax-link">Customer Activity</a></li>
                                                    <li><a style="font-size: 16px; padding-left: 10px;" href="#"
                                                           class="ajax-link">Treatment / Biologist</a></li>
                                                    <li><a style="font-size: 16px; padding-left: 10px;" href="#"
                                                           class="ajax-link">Account Expiration</a></li>
                                                    <li><a style="font-size: 16px; padding-left: 10px;" href="#"
                                                           class="ajax-link">Customer Profile</a></li>

                                                </ul>
                                            </div>
                                        </div>

                                    </li>
                                    <li class="dropdown">
                                        <a style="font-size: 16px; padding-left: 25px;"
                                           class="dropdown-toggle active-parent" data-toggle="collapse"
                                           href="#collapseExample1" aria-expanded="false"
                                           aria-controls="collapseExample">
                                            <i style="padding-right:15px;" class="fa fa-edit"></i>
                                            <span class="hidden-xs">Edit</span>
                                        </a>

                                        <div class="collapse" id="collapseExample1">
                                            <div class="well">
                                                <ul class="nav sid-nav" style="display: block;">
                                                    <li><a href="/account/edit/{{ $id }}" class="ajax-link">This
                                                            Account</a></li>
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
                                        <span>{{ $act_status }}</span>
                                        <span class="pull-right act-status-edit" title="Edit Account Status"><i class="fa fa-edit"></i> </span>
                                    </li>
                                    <li>
                                        <span style='color:green;'><i class="fa fa-check-circle"></i></span>
                                        <span class="act-sum-header">Last Treated: </span>
                                        <span>Last Treated June 17, 2015</span>
                                    </li>
                                    <li>
                                        <span style='color:green;'><i class="fa fa-check-circle"></i></span>
                                        <span class="act-sum-header">Billing Amt: </span>
                                        <span>${{ $act_billing_amount }}</span>
                                    </li>
                                    <li>
                                        <span style='color:green;'><i class="fa fa-check-circle"></i></span>
                                        <span class="act-sum-header">End Date: </span>
                                        <span>{{ $act_end_date }}</span>
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
                                <label>${{ $act_budget }}</label>
                            </div>

                            <div class="col-md-10 edit-box">
                                <h4>Billing Amount</h4>
                                <hr>
                                <label>${{ $act_billing_amount }}</label>
                            </div>
                            <div class="col-md-10 edit-box">
                                <h4>Billing Address</h4>
                                <hr>
                                <span>{{ $act_address }}</span><br/>
                                <span>{{ $act_address2 }}</span><br/>
                                <span>{{ $act_city . ', '. $act_state . ' ' . $act_zip }}</span><br/>

                            </div>
                            <div class="col-md-10">
                                <hr>
                                <div class="col-md-4 pull-right _flex _flex_v_center _flex_end">
                                    <a href="/account/edit/{{ $id }}">
                                <span class="act_tools btn btn-primary alert-info fa-lg " style="margin-right:15px;"
                                      title="Cancle">
                                    <i class="fa fa-edit"></i> Details
                                </span>
                                    </a>
                                <span class="act_tools btn btn-danger alert-danger fa-lg " style="margin-right:15px;"
                                      title="Cancle">
                                    <i class="fa fa-remove"></i> Cancel
                                </span>
                                <span class="act_tools btn btn-success alert-success fa-lg" title="Save Changes">
                                    <i class="fa fa-check"></i> Save
                                </span>

                                </div>
                            </div>
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
    <script src="<?php echo asset('/js/app.backend.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo asset( '/js/jquery.mask.min.js' ); ?>" type="text/javascript"></script>
@endsection

