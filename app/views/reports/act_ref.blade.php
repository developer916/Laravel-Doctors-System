@extends('reports.blank')

@section('title')
    Lake Doctors - Account Reference List
@endsection
@section('content')
    <div class="container">
        <div class="row hidden-print">
            <div class="pull-right col-md-2" style="margin-top: 10px; text-align: right;">
                <a onclick="window.print()"><i class="fa fa-print"></i> Print Report</a>
            </div>
            <div class="pull-right col-md-4" style="margin-top: 10px; text-align: right;">
                <div class="col-md-3 pull-right">
                    <label class="radio-inline">
                        <input type="radio" name="activeControls" id="inactive-radio" value="Inactive"
                               style="margin-top:0;"> Inactive
                    </label>
                </div>
                <div class="col-md-3 pull-right">
                    <label class="radio-inline">
                        <input type="radio" name="activeControls" id="all-radio" value="Active"
                               style="margin-top:0;"> Active
                    </label>
                </div>
                <div class="col-md-3 pull-right">
                    <label class="radio-inline">
                        <input type="radio" name="activeControls" id="all-radio" value="All"
                               style="margin-top:0;" checked> All
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <hr class="page-hr"/>
            <div class="col-md-12">
                <h4><strong>Account Reference List</strong></h4>
            </div>
            <div class="col-md-12">
            <hr class="page-hr"/>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
            <tr id="head-row">
                <th id="head-acct">Acct #</th>
                <th id="head-name">Account Name</th>
                <th id="head-email">Email</th>
                <th id="head-co">Office</th>
                <th id="head-sales">Salesman</th>
                <th id="head-status">Status</th>
                <th id="head-co">Budget</th>
                <th id="head-exp">Exp. Date</th>
            </tr>
            </thead>
            @if(isset($act))
                @foreach($act as $a)
                    <tr class='Hideable' data-status="{{ $a->status }}">
                        <td class="body-acct">{{ $a->actNum }}</td>
                        <td class="body-name">{{ $a->actName }}</td>
                        <td class="body-email">{{ $a->email }}</td>
                        <td class="body-office">{{ $a->office }}</td>
                        <td class="body-sales">{{ $a->salesman }}</td>
                        <td class="body-status">{{ $a->status  }}</td>
                        <td class="body-budget">{{ $a->budget }}</td>
                        <td class="body-exp">{{ $a->exp}}</td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
@endsection

@section('scripts')
    <script src="<?php echo asset('/js/report.act_ref.backend.js'); ?>" type="text/javascript"></script>
@endsection