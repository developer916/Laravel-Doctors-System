@extends('reports.blank')

@section('title')
    Lake Doctors - Care Of Report{{ (isset($abvr)? ': '. $abvr : '') }}
@endsection
@section('content')
    <div class="container">
        <div class="row hidden-print">
            <div class="pull-right col-md-2" style="margin-top: 10px; text-align: right;">
                <a onclick="window.print()"><i class="fa fa-print"></i> Print Report</a>
            </div>
            <div class="pull-right col-md-8" style="margin-top: 10px; text-align: right;">
                <div class="col-md-4 pull-right">
                    <label class="radio-inline">
                        <input type="radio" name="activeControls" id="inactive-radio" value="company"
                               style="margin-top:0;"> Company Name
                    </label>
                </div>
                {{--<div class="col-md-2 pull-right">--}}
                    {{--<label class="radio-inline">--}}
                        {{--<input type="radio" name="activeControls" id="inactive-radio" value="office"--}}
                               {{--style="margin-top:0;"> Office--}}
                    {{--</label>--}}
                {{--</div>--}}
                <div class="col-md-3 pull-right">
                    <label class="radio-inline">
                        <input type="radio" name="activeControls" id="all-radio" value="management"
                               style="margin-top:0;"> Management Co
                    </label>
                </div>
                <div class="col-md-3 pull-right">
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
                <th id="head-acct">Cust #</th>
                <th id="head-manage">Management Company</th>
                <th id="head-office">Terr</th>
                <th id="head-co">Company</th>
            </tr>
            </thead>
            @if(isset($act))
                @foreach($act as $a)
                    <tr>
                        <td class="body-acct">{{ $a->id }}</td>
                        <td class="body-manage">{{ $a->co }}</td>
                        <td class="body-office">{{ $a->abvr }}</td>
                        <td class="body-co">{{ $a->name }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>No Accounts Found</td>
                </tr>
            @endif
        </table>
    </div>
@endsection

@section('scripts')
    <script src="<?php echo asset('/js/report.co.backend.js'); ?>" type="text/javascript"></script>
@endsection