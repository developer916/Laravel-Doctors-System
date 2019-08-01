@extends('account.accountapp')

@section('title')
    Lake Doctors Account {{ $act->accountNumber }}
@endsection

@section('content')
<input id="xsrf" value="{{ csrf_token() }}" type="hidden">
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
                                           href="/account/{{ $act->accountNumber }}">
                                            <i style="padding-right:15px;" class="fa fa-dashboard"></i>
                                            <span class="hidden-xs">Account Info</span>
                                        </a>
                                    </li>

                                    <li class="dropdown">
                                        <a style="font-size: 16px; padding-left: 25px;"
                                           class="dropdown-toggle active-parent" data-toggle="collapse"
                                           href="#collapseExample" aria-expanded="false"
                                           aria-controls="collapseExample">
                                            <i style="padding-right:15px;" class="fa fa-bar-chart-o"></i>
                                            <span class="hidden-xs">Reports</span>
                                        </a>

                                        <div class="collapse" id="collapseExample">
                                            <div class="well">
                                                <ul class="nav sid-nav" style="display: block;">
                                                    <li><a style="font-size: 16px; padding-left: 10px;"
                                                           href="/account/report/field/{{ $act->accountNumber }}" class="ajax-link">Field
                                                            Activity</a></li>
                                                    <li><a style="font-size: 16px; padding-left: 10px;" href="/account/report/materialAct/{{ $act->accountNumber }}" target="_blank" class="ajax-link">Materials Usage</a></li>
                                                    <li><a style="font-size: 16px; padding-left: 10px;"  data-toggle="modal" data-target="#search_car"
                                                           class="ajax-link">Customer Activity</a></li>
                                                    {{--<li><a style="font-size: 16px; padding-left: 10px;" href="#"--}}
                                                           {{--class="ajax-link">Treatment / Biologist</a></li>--}}
                                                    {{--<li><a style="font-size: 16px; padding-left: 10px;" href="#"--}}
                                                           {{--class="ajax-link">Account Expiration</a></li>--}}
                                                    <li><a style="font-size: 16px; padding-left: 10px;" target="_blank" href="/print/cpr/{{ $act->accountNumber }}"
                                                           class="ajax-link">Customer Profile</a></li>

                                                </ul>
                                            </div>
                                        </div>

                                    </li>
                                    @if(isset($me['15']) && $me['15'])
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
                                                    <li><a href="/account/edit/{{ $act->accountNumber }}" class="ajax-link">This
                                                            Account</a></li>
                                                    {{--<li><a href="#" class="ajax-link">Field Activity</a></li>--}}

                                                </ul>
                                            </div>
                                        </div>

                                    </li>
                                        @endif
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
                                        <span ><i class="status-ok fa fa-check-circle"></i></span>
                                        <span class="act-sum-header">Company: </span>
                                        <span>{{ strtoupper($act->actName) }}</span>
                                    </li>
                                    <li>
                                        <span>
                                            @if($statBool)
                                            <i class="status-ok fa fa-check-circle"></i>
                                            @else
                                            <i class="status-bad fa fa-times-circle"></i>
                                            @endif
                                        </span>
                                        <span class="act-sum-header">Status: </span>
                                        <span>{{ $status->statusName }}</span>
                                        @if(strtolower($status->statusName) != 'ac')
                                        <span>{{ $status->status_date ? $status->status_date : ' - NO DATE AVAILABLE' }}</span>
                                        @endif
                                        @if(isset($me['15']) && $me['15'])
                                        <span class="pull-right act-status-edit" title="Edit Account Status">
                                            <a href="/account/edit/{{ $act->accountNumber }}#status-box" class="ajax-link">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </span>
                                        @endif
                                    </li>
                                    <li>
                                        <span><i class="status-ok fa fa-check-circle"></i></span>
                                        <span class="act-sum-header">Last Treated: </span>
                                        <span>{{ $lastService }}</span>
                                    </li>
                                    <li>
                                        <span><i class="status-ok fa fa-check-circle"></i></span>
                                        <span class="act-sum-header">Billing Amt: </span>
                                        <span>${{ $accounting->billing }}</span>
                                    </li>
                                    <li>
                                        <span><i class="status-ok fa fa-check-circle"></i></span>
                                        <span class="act-sum-header">End Date: </span>
                                        <span>{{ date('m/d/Y', strtotime($info->date_end) ) }}</span>
                                    </li>
                                    <li>
                                        <span><i class="status-ok fa fa-check-circle"></i></span>
                                        <span class="act-sum-header">Contact Name: </span>
                                        <span>{{ $contact->firstName }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-10 edit-box">
                                <h4>Account</h4>
                                <hr>
                                <label><strong>{{ $act->accountNumber }}</strong></label>
                            </div>
                            <div class="col-md-10 edit-box">
                                <h4>Monthly Budget</h4>
                                <hr>
                                <label>${{ $accounting->budget }}</label>
                            </div>

                            <div class="col-md-10 edit-box">
                                <h4>Billing Address</h4>
                                <hr>
                                @if($location->care_of)
                                <span>C/O: {{ strtoupper($location->care_of) }}</span><br/><br/>
                                @endif
                                <span>{{ $location->address1 }}</span><br/>
                                @if(isset($location->address2) && $location->address2 !== '')
                                <span>{{ $location->address2 }}</span><br/>
                                @endif
                                @if(isset($location->address3) && $location->address3 !== '')
                                    <span>{{ $location->address3 }}</span><br/>
                                @endif
                                <span>{{ $location->city . ', '. $location->state . ' ' . $location->zipcode }}</span><br/>
                            </div>
                            <div class="col-md-10">
                                <hr>
                                <div class="col-md-4 pull-right _flex _flex_v_center _flex_end">
                                    @if(isset($me['15']) && $me['15'])
                                    <a href="/account/edit/{{ $act->accountNumber }}">
                                        <span class="act_tools btn btn-primary alert-info fa-lg " style="margin-right:15px;"
                                              title="Details">
                                            <i class="fa fa-edit"></i> Details
                                        </span>
                                    </a>
                                    @endif
                                    <a href="/dash">
                                        <span class="act_tools btn btn-danger alert-danger fa-lg " style="margin-right:15px;" title="Cancel">
                                            <i class="fa fa-remove"></i> Cancel
                                        </span>
                                    </a>

                                    <button class="act_tools btn btn-danger alert-danger fa-lg delete-account">
                                        <i class="fa fa-trash"></i> Delete Account
                                    </button>

                                    <form method="POST" action="{{ route('account.delete', ['id' => $act->id]) }}" name="delete-account">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_method" value="DELETE">
                                    </form>

                                {{--<span class="act_tools btn btn-success alert-success fa-lg" title="Save Changes">--}}
                                    {{--<i class="fa fa-check"></i> Save--}}
                                {{--</span>--}}

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
    <script src="<?php echo asset('/js/view.account.backend.js'); ?>" type="text/javascript"></script>
    <script type="text/javascript">
        $( ".delete-account" ).on( "click", function () {
            var confirmMessage = "Are you sure you wish to delete #" + "{{ $act->id }}" + " {{ $act->actName }} ?";
            if (confirm( confirmMessage ))
            {
                $( "form[name='delete-account']" ).submit();
            }
        });
    </script>
@endsection

