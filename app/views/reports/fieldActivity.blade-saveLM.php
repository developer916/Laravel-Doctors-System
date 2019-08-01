@extends('reports.report-act-app') @section('title') Lake Doctors Field Activity {{ $id }} @endsection @section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body sdg_zero_bounce sdg_flex">
                    <div class="col-md-4 sdg_tool_panel sdg_stretch _flex_order_2 sdg_no_bmp">
                        <div class="act_head">
                            <h2>Field Activity Report</h2>
                            <p>
                                You can edit this report by clicking the edit icon in the upper right corner or expanding the Edit tab below.
                            </p>
                        </div>
                        <div class="col-xs-12 col-sm-12 sdg_no_bmp" id="sidebar-left">
                            <ul class="nav main-menu">
                                <li>
                                    <a style="font-size: 16px; padding-left: 25px;" class="ajax-link" href="/account/{{ $id }}">
                                        <i style="padding-right:15px;" class="fa fa-dashboard"></i>
                                        <span class="hidden-xs">Account Info</span>
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a style="font-size:16px;padding-left:25px" class="dropdown-toggle active-parent" data-toggle="collapse" href="#reportsFA" aria-expanded="false" aria-controls="reportsFA">
                                        <i style="padding-right:15px" class="fa fa-bar-chart-o"></i>
                                        <span class="hidden-xs">Reports</span>
                                    </a>
                                    <div class="collapse" id="reportsFA">
                                        <div class="well">
                                            <ul class="nav sid-nav" style="display:block">
                                                <li><a style="font-size:16px;padding-left:10px" href="#" class="ajax-link">Materials Usage</a></li>
                                                <li><a style="font-size:16px;padding-left:10px" href="#" class="ajax-link">Customer Activity</a></li>
                                                <li><a style="font-size:16px;padding-left:10px" href="#" class="ajax-link">Treatment / Biologist</a></li>
                                                <li><a style="font-size:16px;padding-left:10px" href="/account/report/expiration_list" class="ajax-link">Account Expiration</a></li>
                                                <li><a style="font-size:16px;padding-left:10px" href="/print/cpr/{{ $id }}" class="ajax-link">Customer Profile</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a style="font-size:16px;padding-left:25px;" href="/account/edit/{{ $id }}" class="ajax-link">
                                        <i style="padding-right:15px;" class="fa fa-edit"></i>
                                        <span class="hidden-xs">Edit</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-7 col-md-offset-1 sdg_stretch sdg_btm_bump _flex_order_2">
                        <div class="_flex _flex_stretch">
                            <div class="col-md-8 sdg_no_l_bump">
                                <h2>Account {{ $id }}</h2>
                            </div>
                        </div>
                        <p>Below is the account information for the selected account.</p>
                        <div class="col-md-10">
                            <ul class="account-sum-block">
                                <li>
                                    <span><i class="status-ok fa fa-check-circle"></i></span>
                                    <span class="act-sum-header">Company: </span>
                                     @if($act->actName)
                                    <span>{{ $act->actName }}</span>
                                    @endif
                                </li>
                                <li>
                                    <span>
                                        @if($act->actStatus->status_id == 0)
                                        <i class="status-ok fa fa-check-circle"></i>
                                            @else
                                        <i class="status-bad fa fa-remove"></i>
                                        @endif
                                    </span>
                                    <span class="act-sum-header">Status: </span>
                                    <span>{{ $act->actStatus->Name->code }} &mdash; {{ $act->actStatus->Name->name }}</span>
                                </li>
                            </ul>
                            <h3>Last Service</h3>
                            <ul class="account-sum-block">
                                @if( isset( $lastService->hours ) )                         
                                <li>
                                    <span><i class="status-ok fa fa-check-circle"></i></span>
                                    <span class="act-sum-header">Man Hours: </span>
                                    <span>{{ $lastService->hours }}</span>
                                </li>
                                @endif
                                @if( isset( $lastService->techName->code ) )                                 
                                <li>
                                    <span><i class="status-ok fa fa-check-circle"></i></span>
                                    <span class="act-sum-header">Tech: </span>
                                    <span>{{ $lastService->techName->code }} &mdash; {{ $lastService->techName->name }}</span>
                                </li>
                                @endif
                                @if( isset( $lastService->service_date ) ) 
                                <li>
                                    <span><i class="status-ok fa fa-check-circle"></i></span>
                                    <span class="act-sum-header">Service Date: </span>
                                    <span>{{ $lastService->service_date }}</span>
                                </li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-10 edit-box">
                            <h4>Man Hours</h4>
                            <hr>
                            <input type="text" class="form-control" value="{{ $lastService->hours }}" />
                        </div>
                        <div class="col-md-10 edit-box">
                            <h4>Tech</h4>
                            <hr>
                            <select name="tech_id" id="tech_id" class="form-control">
                                @foreach($tech as $tec)
                                    <option value="{{ $tec->id }}" <?php echo ( $lastService->tech_id == $tec->id ? 'selected="true"' : ''  ); ?> >{{ $tec->code }} &mdash; {{ $tec->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-10 edit-box">
                                <h4>Materials /Herbicides </h4>
                            <hr>
<br />
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            @foreach ($field as $rep)
                                <div class="col-md-12 no-padding">
                                    <div class="col-md-6 no-padding">
                                        <span>
                                            Technician
                                        </span>
                                        {{ (isset($rep->tech_id ) && $rep->tech_id  != 999 && isset( $techList[$rep->tech_id] ) ? $techList[$rep->tech_id] : 'Not Assigned') }}
                                    </div>
                                    <div class="col-md-2 no-padding">
                                        <span>
                                            Hours
                                        </span>
                                        {{ $rep->hours }}
                                    </div>
                                    <div class="col-md-3 no-padding">
                                        <span>
                                            Date
                                        </span>
                                        {{ $rep->service_date }}
                                    </div>
                                    <div class="col-md-1 no-padding">
                                        <span class="pull-right list-tool">
                                           <a> <i title="Add item" class="fa fa-edit"></i></a>
                                            <i class="status-ok fa fa-plus add-field-data" data-id="{{ $rep->id }}" data-edit="false"></i>
                                        </span>
                                    </div>
                                </div>
                            <table id="field_data_{{ $rep->id }}" class="table table-striped field-data">
                                <thead>
                                    <tr>
                                        <th>Material</th>
                                        <th>Quantity</th>
                                        <th>Units</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th style="width:50px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rep->fieldData as $fd )
                                    <tr>
                                        <td class="field-data"><input class="form-control" value="{{ $mats[ $fd->material_id]->code }}" data-mat="{{ $fd->material_id  }}" name="mat-name-{{ $fd->id }}" /></td>
                                        <td class="field-data"><input class="form-control qty-ctrl" data-mat="{{ $fd->id }}" value="{{ $fd->quantity }}" name="qty-{{ $fd->id }}" /></td>
                                        <td class="field-data">{{ $mats[ $fd->material_id ]->units }}</td>
                                        <td class="field-data"><span class="mat-cost-{{$fd->id}}">{{ $mats[ $fd->material_id]->cost }}</span></td>
                                        <td class="field-data"><span class="mat-tot-{{$fd->id}}">{{  $fd->quantity * $mats[ $fd->material_id ]->cost  }}</span></td>
                                        {{--<td class="field-data"><span class="mat-tot-{{$fd->id}}">{{ money_format('$%i',  $fd->quantity * $mats[ $fd->material_id ]->cost ) }}</span></td>--}}
                                        <td class="field-data">
                                            <span class="pull-right list-tool remove-field-data">
                                                <i data-id="{{ $fd->id }}" title="Save Changes" class="status-ok save-mat fa fa-check"></i>
                                                <i data-id="{{ $fd->id }}" title="Remove this item" class="status-bad remove-mat dead-link fa fa-remove"></i>
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                                <div class="col-md-10 edit-box {{ $rep->notes != null ? '' : 'invis' }}">
                                    <h4>Notes</h4>
                                    <hr>
                                    <p>{{ $rep->notes }}</p>

                                </div>
                                <br />
                            @endforeach
                        </div>
                        <div class="col-md-12">
                            <hr>
                        <div class="col-md-4 pull-right _flex _flex_v_center _flex_end" >
                                     {{--<span class="act_tools btn btn-danger alert-danger fa-lg " style="margin-right:15px;" title="Cancle">--}}
                                    {{--<i class="fa fa-remove"></i> Cancel--}}
                                {{--</span>--}}
                                {{--<span class="act_tools btn btn-success alert-success fa-lg" title="Save Changes">--}}
                                    {{--<i class="fa fa-check"></i> Save--}}
                                {{--</span>--}}

                        </div>
                        </div>
                        <!--                        <div class="col-md-10">
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
                                                </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    @include('breadcrumbs.breadcrumbs')

</div>
@endsection @section('scripts')
<script src="<?php echo asset( '/js/field.backend.js' ); ?>" type="text/javascript"></script>
@endsection