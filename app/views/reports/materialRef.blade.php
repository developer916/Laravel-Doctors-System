@extends('masters.printReport')

@section('title')
    Lake Doctors Material/Hrebicide Refference List
@endsection

@section('content')
    <div class="container">
        <div class="col-md-10 edit-box">
            <div class="col-md-6">
                <h4>Materials /Herbicides</h4>
            </div>
            <div class="col-md-6">
                <div class="pull-right" style="position: relative; top: 5px;">
                    Sort By:
                    <label><input type="radio" name="report-type" data-val="code"
                                  style="position: relative; top:2px;margin-left: 5px; margin-right: 5px;" checked> Code</label>
                    <label><input type="radio" name="report-type" data-val="name"
                                  style="position: relative; top:2px;margin-left: 5px; margin-right: 5px;"> Name</label>
                </div>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            <table id="mat-table" class="table table-striped">
                <thead>
                <tr>
                    <th class="mat-code">Code</th>
                    <th class="mat-code">Material Name</th>
                    <th class="mat-name invis">Material Name</th>
                    <th class="mat-name invis">Code</th>
                    <th>Primary Supplier</th>
                    <th>Unites</th>
                    <th>Cost</th>
                    <th>Eff. Date</th>
                </tr>
                </thead>
                <tbody class="mat-code">
                @foreach ($report as $rep)

                    <tr>
                        <td>{{ $rep['code'] }}</td>
                        <td>{{ $rep['name'] }}</td>
                        <td>{{ $rep['primary'] }}</td>
                        <td>{{ $rep['units'] }}</td>
                        <td>{{ $rep['cost'] }}</td>
                        <td>{{ date('m/d/Y', strtotime($rep['updated_at']) ) }}</td>
                    </tr>
                @endforeach
                </tbody>
                </thead>
                <tbody class="mat-name invis">
                @foreach ($report2 as $rep)

                    <tr>
                        <td>{{ $rep['name'] }}</td>
                        <td>{{ $rep['code'] }}</td>
                        <td>{{ $rep['primary'] }}</td>
                        <td>{{ $rep['units'] }}</td>
                        <td>{{ $rep['cost'] }}</td>
                        <td>{{date('m/d/Y', strtotime($rep['updated_at']) ) }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="<?php echo asset('/js/material-ref.report.module.js'); ?>" type="text/javascript"></script>
@endsection