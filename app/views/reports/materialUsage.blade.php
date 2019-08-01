@extends('masters.printReport')

@section('title')
Lake Doctors Material/Herbicides Usage Report
@endsection

@section('content')
<div class="container">
    <div class="col-md-10 edit-box">
        <h4>Materials / Herbicides</h4>
        <hr>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Code</th>
                <th>Tech</th>
                <th>Qty</th>
                <th>Cost</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($report as $rep)
                <tr>
                    <td>{{ $rep['code'] }}</td>
                    <td>{{ $rep['tech'] }}</td>
                    <td>{{ $rep['qty'] }}</td>
                    <td>${{ $rep['cost'] }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>${{ $total }}</td>
            </tr></tfoot>
        </table>

    </div>
</div>
@endsection

@section('scripts')
<script src="<?php echo asset( '/js/app.backend.js' ); ?>" type="text/javascript"></script>
@endsection