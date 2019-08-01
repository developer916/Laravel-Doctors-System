@extends('reports.blank')

@section('title')
    Lake Doctors - Cancel/Completed Report
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
                        <input type="radio" name="activeControls" id="all-radio" value="salesman"
                               style="margin-top:0;"> Salesman
                    </label>
                </div>
                <div class="col-md-4 pull-right">
                    <label class="radio-inline">
                        <input type="radio" name="activeControls" id="active-radio" value="account" Checked
                               style="margin-top:0;"> Account #
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <hr class="page-hr"/>
            <div class="col-md-12">
                <h4><strong>Care Of Report</strong></h4>
            </div>
            <div class="col-md-12">
                <div class="pull-right">Issue Date: {{ date('m/d/Y') }}</div>
            </div>
            <div class="col-md-12">
            <hr class="page-hr"/>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
            <tr id="head-row">
                <th id="head-acct">Account #</th>
                <th id="head-name">Account Name</th>
                <th id="head-by">By</th>
                <th id="head-date">Date</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($act))
                @foreach($act as $a)
                    <tr class="account">
                        <td class="body-acct">{{ $a->actNum }}</td>
                        <td class="body-name">{{ $a->actName }}</td>
                        <td class="body-by">{{ $a->salesman }}</td>
                        <td class="body-date">{{ $a->date }}</td>
                    </tr>
                @endforeach
                @foreach($act2 as $a2)
                    <tr class="salesman invis">
                        <td class="body-acct">{{ $a2->actNum }}</td>
                        <td class="body-name">{{ $a2->actName }}</td>
                        <td class="body-by">{{ $a2->salesman }}</td>
                        <td class="body-date">{{ $a2->date }}</td>
                    </tr>
                    @endforeach
            @else
                <tr>
                    <td>No Accounts Found</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script src="<?php echo asset('/js/report.bio.backend.js'); ?>" type="text/javascript"></script>
@endsection