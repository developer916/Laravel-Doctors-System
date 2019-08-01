@extends('reports.blank')

@section('title')
    Lake Doctors Customer Activity Report
@endsection

@section('content')
    <div id="car" class="container">
        <div class="row hidden-print">
            <div class="pull-right col-md-2" style="margin-top: 10px; text-align: right;">
                <a onclick="window.print()"><i class="fa fa-print"></i> Print Report</a>
            </div>
            <div class="pull-right col-md-6" style="margin-top: 10px; text-align: right;">
                <div class="col-md-2">
                    <label class="radio-inline">
                    <input type="radio" name="activeControls" id="all-radio" value="all" Checked
                           style="margin-top:0;"> All
                </label>
                </div>
                <div class="col-md-2">
                    <label class="radio-inline">
                    <input type="radio" name="activeControls" id="active-radio" value="active"
                           style="margin-top:0;"> Active
                </label>
                </div>
            <div class="col-md-2">
                <label class="radio-inline">
                    <input type="radio" name="activeControls" id="inactive-radio" value="inactive"
                           style="margin-top:0;"> Inactive
                </label>
                </div>
                <div id="inactive-select-master" class="col-md-6 invis">
                    <select class="form-control" id="inactive-select" style="margin-top: -8px; margin-bottom: 3px;">
                    <option value="default">All</option>
                    @foreach($status as $s)
                        @if($s->id != 0)
                            <option value="{{$s->id}}">{{ $s->code }} &mdash; {{ $s->name }}</option>
                        @endif
                    @endforeach
                </select>
                </div>
                <div class="col-md-3">
                    <label class="radio-inline">
                        <input type="radio" name="activeControls" id="date-radio" value="date"
                               style="margin-top:0;"> By Date
                    </label>
                </div>
                <div class="col-md-3">
                    <label class="radio-inline">
                        <input type="radio" name="activeControls" id="tech-radio" value="tech"
                               style="margin-top:0;"> By Salesmen
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <hr class="page-hr"/>
            <h1 class="report-title"><strong>Customer Activity Report</strong></h1>
            <hr class="page-hr"/>
        </div>

        @if(count($act) <= 0)

            <div class="row">
            <div class="col-md-12 text-itallic-bold">
                <h4>Summary of Report</h4>
            </div>
<!--            <div class="col-md-12">
            <div class="col-md-2 text-itallic-bold">Number of Accounts:</div>
            <div class="col-md-10">1</div>
            </div>
 -->           
            <div class="col-md-12">
            <div class="col-md-2 text-itallic-bold">Accounts Involved:</div>
{{--            <div class="col-md-10">{{ $summary->actNum }}</div>--}}
            </div>
            <div class="col-md-12">
                <div class="col-md-2 text-itallic-bold">Treatment Dates:</div>
                <div class="col-md-10">{{ $summary->treatDate }}</div>
             </div>
            <div class="col-md-12">
            <div class="col-md-2 text-itallic-bold">Renew Dates:</div>
            <div class="col-md-10">{{ $summary->renewDate }}</div>
            </div>
            <div class="col-md-12">
            <div class="col-md-2 text-itallic-bold">Office Involved:</div>
            <div class="col-md-10">{{ $summary->office }}</div>
            </div>
            <div class="col-md-12">
            <div class="col-md-2 text-itallic-bold">SalesMen Involved:</div>
            <div class="col-md-10">{{ $summary->tech }}</div>
            </div>
             </div>  
        @endif 


        @foreach($act as $a)
            <div class="row account-status-link data-row" data-status="{{ $a->actStatus->status_id }}">
                {{--<div class="col-md-12">--}}
                {{--<hr class="page-hr"/>--}}
                {{--</div>--}}
                <div class="col-md-3">
                    <h4><strong>Account Totals for:</strong></h4>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-12 col-md-2"><h4><strong>{{ $a->accountNumber }}</strong></h4></div>
                    <div class="col-xs-12 col-md-10"><h4><strong>{{ strtoupper( $a->actName ) }}</strong></h4></div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-3 text-itallic-bold">
                        No. of Months Reported:
                    </div>
                    <div class="col-xs-6 col-md-9">
                        <div class="col-xs-3 col-md-3 text-right">{{ $actStats->totalMonths }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-3 text-itallic-bold">
                        Total Labor Hours:
                    </div>
                    <div class="col-xs-6 col-md-9">
                        <div class="col-xs-3 col-md-3 text-right">{{ $actStats->totalHours }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-3 text-itallic-bold">
                        Total Labor Costs:
                    </div>
                    <div class="col-xs-6 col-md-9">
                        <div class="col-xs-3 col-md-3 text-right">{{ number_format($actStats->totalHours * 80, 2) }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-3 text-itallic-bold">
                        Average Hours per Month:
                    </div>
                    <div class="col-xs-6 col-md-9">
                        <div class="col-xs-3 col-md-3 text-right">{{ round($actStats->totalHours / $actStats->totalMonths, 2) }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-3 text-itallic-bold">
                        Average Labor per Month:
                    </div>
                    <div class="col-xs-6 col-md-9">
                        <div class="col-xs-3 col-md-3 text-right">
                            {{ round( ($actStats->totalHours * 80) /  $actStats->totalMonths , 2)}}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-3 text-itallic-bold">
                        Total Chemical Cost:
                    </div>
                    <div class="col-xs-6 col-md-9">
                        <div class="col-xs-3 col-md-3 text-right">{{ number_format($actStats->costTotal, 2) }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-3 text-itallic-bold">
                        Average Chemicals per Month:
                    </div>
                    <div class="col-xs-6 col-md-9">
                        <div class="col-xs-3 col-md-3 text-right">{{ number_format($actStats->avgChem, 2) }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-3 text-itallic-bold">
                        Monthly Chemical Budget:
                    </div>
                    <div class="col-xs-6 col-md-9">
                        <div class="col-xs-3 col-md-3 text-right">{{ number_format( $actStats->monthlyChemBudget, 2) }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-3 text-itallic-bold">
                        Chemical Variance:
                    </div>
                    <div class="col-xs-6 col-md-9">
                        <div class="col-xs-3 col-md-3 text-right">{{ number_format($actStats->chemVar, 2) }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-3 text-itallic-bold">
                        Contract Billing Amount:
                    </div>
                    <div class="col-xs-6 col-md-9">
                        <div class="col-xs-3 col-md-3 text-right">{{ number_format( $actStats->contractBillingAmount, 2) }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-3 text-itallic-bold">
                        Alternative Cost:
                    </div>
                    <div class="col-xs-6 col-md-9">
                        <div class="col-xs-3 col-md-3 text-right">{{ $actStats->altCost }}</div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-12">
                    <hr class="dark-hr">
                </div>
                @if(isset($actStats->fieldServe))
                    <div id="report_data">
                    @foreach($actStats->fieldServe as $f)
                        <div class="col-xs-12 col-md-12">
                            <table class="table table-striped field-data">
                                <thead>
                                <tr>
                                    <th>Date Treated</th>
                                    <th>By</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Cost</th>
                                    <th>Unit</th>
                                    <th>Qty</th>
                                    <th>Ext. Cost</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($f->data as $d)
                                    <tr>
                                        <th class="data-date">{{ $f->service_date }}</th>
                                        <th class="data-tech">{{ $f->tech }}</th>
                                        <th>{{ $d->code }}</th>
                                        <th>{{ $d->name }}</th>
                                        <th>{{ $d->cost }}</th>
                                        <th>{{ $d->units }}</th>
                                        <th>{{ $d->qty}}</th>
                                        <th>{{ $d->matTotal }}</th>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-xs-6 col-md-2 text-right">Labor Hours:</div>
                                <div class="col-xs-6 col-md-10 text-left">{{ $f->hours }}</div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-2 text-right">Labor Cost:</div>
                                <div class="col-xs-6 col-md-10 text-left">${{ number_format($f->hours * 80, 2) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-2 text-right">Chem Cost:</div>
                                <div class="col-xs-6 col-md-10 text-left">${{ number_format($f->chemTotal, 2) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-2 text-right">Total:</div>
                                <div class="col-xs-6 col-md-10 text-left">${{ number_format($f->chemTotal + ($f->hours * 80), 2) }}</div>
                            </div>
                            <br/>
                            <hr class="dark-hr"/>
                        </div>
                    @endforeach
                    </div>
                @else
                    <h1>No Field Service for this account</h1>
                @endif
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script src="<?php echo asset('/js/report.car.backend.js'); ?>" type="text/javascript"></script>
@endsection