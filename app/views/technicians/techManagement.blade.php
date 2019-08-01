@extends('masters.techReportMaster')

@section('title')
Lake Doctors Technician Management
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="panel-body sdg_zero_bounce sdg_flex">
                    <div class="col-md-4 sdg_tool_panel sdg_stretch _flex_order_2 sdg_no_bmp">
                        <div class="act_head">
                            <h2>Technician Management</h2>
                            <p>
                                You can edit field activity and add new technician data.
                            </p>
                        </div>

                        <div class="col-xs-12 col-sm-12 sdg_no_bmp invis" id="sidebar-left">
                            <ul class="nav main-menu">
                                <li>
                                    <a  style="font-size: 16px; padding-left: 25px;" class="ajax-link" href="/technicians">
                                        <i style="padding-right:15px;" class="fa fa-dashboard"></i>
                                        <span class="hidden-xs">Technician Management</span>
                                    </a>
                                </li>

                                <li class="dropdown">
                                    <a  style="font-size: 16px; padding-left: 25px;" class="dropdown-toggle active-parent"
                                        data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                        <i style=padding-right:15px;" class="fa fa-bar-chart-o"></i>
                                        <span class="hidden-xs">Reports</span>
                                    </a>
                                    <div class="collapse" id="collapseExample">
                                        <div class="well">
                                            <ul class="nav sid-nav" style="display: block;">
                                                <li>
                                                    <div href="#field" aria-controls="field" role="tab" data-toggle="tab" data-control="field">
                                                    <a style="font-size: 16px; padding-left: 10px;" class="ajax-link" data-toggle="modal" data-target="#techModal">Techs by Office </a>
                                                    </div>
                                                </li>
                                                <li><a style="font-size: 16px; padding-left: 10px;" href="#" class="ajax-link">Tech List</a></li>

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
                                <h2>Technicians</h2>
                            </div>


                        </div>
                        <p>Here is the current information for technicians.</p>
                        <div class="col-md-10">
                            <ul class="account-sum-block">
                                <li>
                                    <span style='color:green;'><i class="fa fa-check-circle"></i></span>
                                    <span class="tech-sum-header">Active: </span>
                                    <span>{{ $active  }}</span>
                                </li>
                                <li>
                                    <span style='color:green;'><i class="fa fa-check-circle"></i></span>
                                    <span class="tech-sum-header">InActive: </span>
                                    <span>{{ $inactive }}</span>
                                </li>
                                <li>
                                    <span style='color:green;'><i class="fa fa-check-circle"></i></span>
                                    <span class="tech-sum-header">Man Hours for {{ date('M') }}: </span>
                                    <span>{{number_format( $monthHours, 2) }}</span>
                                <li>
                                    <span style='color:green;'><i class="fa fa-check-circle"></i></span>
                                    <span class="tech-sum-header">Total Man Hours: </span>
                                    <span>{{ number_format($totalHours, 2 )}}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-10 edit-box">
                            <h4>Technician List</h4>
                            <hr>
                            <div class="col-md-6">
                                <div data-tool-type="act" class="btn btn-primary tech-list-tool alert-info" title="Filter Active Technicians Only"><i class="fa fa-bolt"></i> Active </div>
                            <div data-tool-type="ina" class="btn btn-primary tech-list-tool alert-info" title="Filter Inactive Technicians Only"><i class="fa fa-bed"></i> Inactive </div>
                            <div data-tool-type="nor" class="btn btn-danger tech-list-tool alert-danger"  title="Remove Filters"><i class="fa fa-remove"></i>  </div>
                            </div>
                            <div class="input-group col-md-6">
                                <select class="form-control" id="officeSelect" name="officeSelect">
                                    <option value="default">Office</option>
                                    @foreach($offices as $o)
                                        <option value="{{ $o['abvr'] }}">{{ $o['abvr']. ' - ' . $o['officeName']  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <row>


                                <div class="input-group sdg_bottom_25 col-md-12">
                                    <input id="tech_search" type="text" class="form-control act-search"
                                           placeholder="Refine the list of Technicians">
                                    <span class="input-group-btn">
                                        <a id='tech-text-empty' class="btn btn-danger alert-danger act-btn"
                                           type="button"><i class="fa fa-remove"></i>
                                        </a>
                                    </span>
                                    <div style="position: relative" id="autoDisplay" class="autoDisplay"></div>
                                </div><!-- /input-group -->

                            </row>
                            <table id="tech_table" class="table table-striped">
                                <thead>
                                    <tr class="tech-list-head">
                                        <th style="width:100px;">Code</th>
                                        <th style="width:100px;">Name</th>
                                        <th style="width:100px;">Office</th>
                                        <th style="width:100px;">Rate</th>
                                        <th style="width:100px;">Active</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($report as $rep)

                                    <tr id="tech-edit-id-{{ $rep['id'] }}"
                                        data-code="{{ $rep['code'] }}"
                                        data-name="{{ $rep['name'] }}"
                                        data-off="{{ $rep['office'] }}"
                                        data-rate="{{ $rep['rate'] }}"
                                        data-act="{{ $rep['active']  }}">
                                        <td>
                                            <div class="tech-edit-code">{{ $rep['code'] }}</div>
                                        </td>
                                        <td>
                                            <div class="tech-edit-name">{{ $rep['name'] }}</div>
                                        </td>
                                        <td>
                                            <div class="office_value"  class="tech-edit-abvr">{{ $rep['abvr'] }}</div>
                                        </td>
                                        <td>
                                            <div class="tech-edit-rate">{{ $rep['rate'] }}</div>
                                        </td>
                                        <td>
                                            <div class="tech-edit-active">
                                                @if($rep['active'] )
                                                    <span class="label-good">Yes</span>

                                                    @else
                                                    <span class="label-bad">No</span>

                                                @endif

                                            </div>
                                        </td>
                                        <td style="width:90px;">
                                            <div data-tech-edit="{{ $rep['id'] }}" class="tech-edit col-md-6" title="Edit Technician" ><i class="fa fa-edit"></i></div>
                                            <div data-tech-remove="{{ $rep['id'] }}" class="tech-remove col-md-6" title="Remove Technician" ><i class="fa fa-remove"></i></div>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12">
                            <hr><br />
                        <div class="col-md-4 pull-right _flex _flex_v_center _flex_end invis" >
                                     <span class="act_tools btn btn-danger alert-danger fa-lg  invis" style="margin-right:15px;" title="Cancel">
                                    <i class="fa fa-remove"></i> Cancel
                                </span>
                                <span class="act_tools btn btn-success alert-success fa-lg invis" title="Save Changes">
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
<script src="<?php echo asset( '/js/tech.backend.js' ); ?>" type="text/javascript"></script>
@endsection