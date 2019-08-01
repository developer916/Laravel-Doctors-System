@extends('reports.report-act-app') @section('title') Lake Doctors Field Activity {{ $id }} @endsection @section('content')
<?php
$FMreadOnly = '';
$AMreadOnly = 'readonly';
if( Auth::user()->level == 1 || Auth::user()->level == 6)
{
    $AMreadOnly = '';
}

if( Auth::user()->level > 2 && Auth::user()->level < 6 )
{
    $FMreadOnly = 'readonly';
}
?>
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
                                        <a style="font-size: 16px; padding-left: 25px;"
                                           class="dropdown-toggle active-parent" data-toggle="collapse"
                                           href="/account/{{ $id }}" aria-expanded="false"
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
                                                    <li><a style="font-size: 16px; padding-left: 10px;" href="/account/report/materialAct/{{ $act->accountNumber }}"  class="ajax-link">Materials Usage</a></li>
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
                                        @if($act->actStatus->status_id == 0 || $act->actStatus->status_id == 1)
                                        <i class="status-ok fa fa-check-circle"></i>
                                            @else
                                        <i class="status-bad fa fa-remove"></i>
                                        @endif
                                    </span>
                                    <span class="act-sum-header">Status: </span>
                                    @if( isset( $act->actStatus->Name ) )
                                        <span>{{ $act->actStatus->Name->code }}
                                            @if( $act->actStatus->Name->name != '' )
                                            &mdash; {{ $act->actStatus->Name->name }}
                                            @endif
                                        </span>
                                    @endif
                                </li>
                            </ul>
                            <h3>Last Service</h3>
                            <ul class="account-sum-block">
                                @if( isset( $lastService->hours ) )                         
                                <li>
                                    <span><i class="status-ok fa fa-check-circle"></i></span>
                                    <span class="act-sum-header">Man Hours: </span>
                                    <span id='ls_man_hours'>{{ $lastService->hours }}</span>
                                </li>
                                @endif
                                @if( isset( $lastService->techName->code ) )                                 
                                <li>
                                    <span><i class="status-ok fa fa-check-circle"></i></span>
                                    <span class="act-sum-header">Tech: </span>
                                    <span id='ls_tech_code'>{{ $lastService->techName->code }} &mdash; {{ $lastService->techName->name }}</span>
                                </li>
                                @endif
                                @if( isset( $lastService->service_date ) ) 
                                <li>
                                    <span><i class="status-ok fa fa-check-circle"></i></span>
                                    <span class="act-sum-header">Service Date: </span>
                                    <span id='ls_date'>{{ $lastService->service_date }}</span>
                                </li>
                                @endif
                            </ul>
                        </div>
                        <?php
                        /*
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
                        */
                        ?>
                        <div class="col-md-10 edit-box" style="background: #d6e9f9;">
                                <h4>Materials /Herbicides </h4>
                                <div class="pull-right status-bad" id="far_removed_msg" style="display:none; font-weight: bold;">Field Activity Removed</div>
                            <hr style="background-color: #CCC;">
                            <br />
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <?php $ctr = 0; ?>
                            @foreach ($field as $rep)
                                <div style="padding: 10px; background: #FFF; margin-bottom: 15px;" data-ctr="{{$ctr}}" data-report="{{$rep->id}}" id="far_form_{{$rep->id}}">
                                    <div class="col-md-12 status-ok" id="far_save_success_{{$rep->id}}" style="display: none; font-weight: bold; text-align: center;">
                                        Updates to Field Activity Report #{{$rep->id}} Successfully Saved
                                    </div>
                                    <div class="col-md-12 no-padding">
                                        @if( Auth::user()->level > 2 && Auth::user()->level < 6 )
                                            <div class="col-md-6 no-padding">
                                                <span>
                                                    Technician
                                                </span>
                                                {{ (isset($rep->tech_id ) && $rep->tech_id  != 999 && isset( $techList[$rep->tech_id] ) ? $techList[$rep->tech_id] : 'Not Assigned') }}                                            </div>
                                            <div class="col-md-3 no-padding">
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
                                        @else
                                            <div class="col-md-4 no-padding">
                                                <span>
                                                    Technician
                                                </span>
                                                <select name="tech_id_{$rep->id}" id="tech_id_{{$rep->id}}" class="form-control">
                                                    @foreach($tech as $tec)
                                                        <option value="{{ $tec->id }}" <?php echo ( $rep->tech_id == $tec->id ? 'selected="true"' : ''  ); ?> >{{ $tec->code }} &mdash; {{ $tec->name }}</option>
                                                    @endforeach
                                                </select>   
                                            </div>
                                            <div class="col-md-1 no-padding"></div>
                                            <div class="col-md-1 no-padding" style="width: 13%">
                                                <span>
                                                    Hours
                                                </span>
                                                <input type="text" class="form-control" value="{{ $rep->hours }}" id="man_hours_{{$rep->id}}" />   
                                            </div>
                                            <div class="col-md-1 no-padding"></div>
                                            <div class="col-md-3 no-padding">
                                                <span>
                                                    Date
                                                </span>
                                                <input type="text" class="form-control" value="{{ $rep->service_date }}" id="serivce_date_{{$rep->id}}" />   
                                            </div>
                                            <div class="col-md-2 no-padding" style="width: 11%">
                                                <span><br/></span>
                                                <span class="list-tool" style="padding-left: 5px; margin-top: 5px;">
                                                    <i data-id="{{ $rep->id }}" data-ctr="{{$ctr}}" title="Save Changes" style="font-size: 24px;" class="status-ok save-rep-info fa fa-save"></i>
                                                </span>
                                                 <span class="list-tool" style="padding-left: 5px; margin-top: 5px;">
                                                    <i data-id="{{ $rep->id }}" title="This will delete the entire activity report" style="font-size: 24px;color: #D9534F" class="delete-rep-info fa fa fa-trash"></i>
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <table id="field_data_{{ $rep->id }}" class="table table-striped field-data">
                                        <thead>
                                            <tr>
                                                <th>Material</th>
                                                <th>Quantity</th>
                                                <th>Units</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                                @if( $AMreadOnly == '' )
                                                    <th style="width:50px;">
                                                        <span class="pull-right list-tool">
                                                            <i class="status-ok fa fa-plus add-field-data" data-id="{{ $rep->id }}" data-edit="false"></i>
                                                        </span>
                                                    </th>  
                                                @endif    
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rep->fieldData as $fd )
                                            <tr>
                                                <td class="field-data">
                                                    <input  class="form-control update_field_data" 
                                                            type="text"
                                                            data-id="{{$fd->id}}"
                                                            value="{{ $fd->Material->code }}" 
                                                            data-mat="{{ $fd->Material->id  }}" 
                                                            name="mat-name-{{ $fd->id }}" 
                                                            autocomplete="off" 
                                                            {{ $AMreadOnly }}/>
                                                    <div class="faMatTooltipFade tooltip bottom tooltipFade" role="tooltip" id="tooltipFade_{{$fd->id}}">
                                                        <div class="tooltip-arrow"></div>
                                                        <div id="auto_display_{{$fd->id}}" class="fa-mat-autodisplay tooltip-inner auto_display autoDisplay"></div>
                                                    </div>        
                                                </td>
                                                
                                                <td class="field-data"><input class="form-control qty-ctrl" data-mat="{{ $fd->id }}" value="{{ $fd->quantity }}" id="qty-{{ $fd->id }}" name="qty-{{ $fd->id }}" {{ $AMreadOnly }}/></td>
                                                <td class="field-data"><span id="unit_{{$fd->id}}">{{ $fd->Material->units }}<span></td>
                                                <td class="field-data"><span class="mat-cost-{{$fd->id}}" id="price_{{$fd->id}}">{{ $fd->Material->cost }}</span></td>
                                                <td class="field-data"><span class="mat-tot-{{$fd->id}}" id="mat_total_{{$fd->id}}">{{  $fd->quantity * $fd->Material->cost  }}</span></td>
                                                {{--<td class="field-data"><span class="mat-tot-{{$fd->id}}">{{ money_format('$%i',  $fd->quantity * $fd->Material->cost ) }}</span></td>--}}
                                                @if( $AMreadOnly == '' )
                                                    <td class="field-data">
                                                        <span class="pull-right list-tool remove-field-data">
                                                            <i data-id="{{ $fd->id }}" title="Save Changes" class="status-ok save-mat fa fa-check"></i>
                                                            <i data-id="{{ $fd->id }}" title="Remove this item" class="status-bad remove-mat dead-link fa fa-remove"></i>
                                                        </span>
                                                    </td>
                                                @endif    
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="col-md-12 {{ $rep->notes != null ? '' : 'invis' }}">
                                        <h4>Notes</h4>
                                        <hr>
                                        <p>{{ $rep->notes }}</p>

                                    </div>
                                    <div class="clearfix"></div>
                                </div>  
                                <?php $ctr++; ?>      
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
<script src="<?php echo asset( '/js/view.account.backend.js' ); ?>" type="text/javascript"></script>
@endsection