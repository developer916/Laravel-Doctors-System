@extends('reports.blank')

@section('title')
    Lake Doctors - Account Expiration Report
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
            <div class="col-md-12">
                <hr class="page-hr"/>
                <h4><strong>Account Expiration Report</strong></h4>
                <hr class="page-hr"/>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr id="head-row">
                    <th id="head-acct">Acct #</th>
                    <th id="head-name">Account Details</th>
                    <th id="head-exp" class="text-center">Exp. Date</th>
                    <th id="head-sales" class="text-center">Salesman</th>
                    <th id="head-office" class="text-center">Office</th>
                    <th id="head-co" class="text-center">Contact Name</th>
                    <th id="head-phone" class="text-center">Phone</th>
                    <th id="head-status">Status</th>
                </tr>
            </thead>
            @if(isset($act))
                @foreach($act as $a)
                <tr class='Hideable' data-status="{{ $a->status }}">
                    <td class="body-acct">{{ $a->actNum }}</td>
                    <td class="body-name" style="width:30%">{{ $a->actName }}<br>
                    @if($a->care_of)
                        {{ $a->care_of }}<br>
                    @endif
                    @if(isset($a->address1) && $a->address1 !== '')
                        {{ $a->address1 }}<br>
                    @endif
                    @if(isset($a->address2) && $a->address2 !== '')
                        {{ $a->address2 }}<br>
                    @endif
                        {{ $a->city . ', '. $a->state . ' ' . $a->zipcode }}
                    </td>
                    <td class="body-exp text-center">{{ $a->exp }}</td>
                    <td class="body-sales text-center">{{ $a->sales }}</td>
                    <td class="body-office text-center">{{ $a->office }}</td>
                    <td class="body-co text-center">
                        {{ $a->contact2 }}
                        @if(isset($a->title) && $a->title !== '')
                        {{ ', ' . $a->title }} <br>
                        @endif
                        @if(isset($a->contact) && $a->contact !== '')
                            <br>{{ $a->contact }}
                        @endif
                    </td>
                    <td class="body-phone text-center">{{ $a->phone }}
                    @if(isset($a->phone2) && $a->phone2 !== '')
                        <br>{{ $a->phone2 }}
                    @endif
                    </td>
                    <td class="body-status text-center">{{ $a->status  }}</td>
                </tr>
                @endforeach
            @endif
        </table>
    </div>
@endsection

@section('scripts')
    <script src="<?php echo asset('/js/report.act_ref.backend.js'); ?>" type="text/javascript"></script>
@endsection