<h4>Inventory Report</h4>
<form target="_blank" id="inv-report" role="form" method="post" action="{{ route('materialInv') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="col-md-12 margin-b-5">
        <select id="off_ask" name="office" class="form-control resetSelect select-default" id="office">
            <option value="default" selected>Select office</option>
            @foreach( $offices as $o)
                <option value="{{ $o->id }}">{{ $o->abvr }} &mdash; {{ $o->officeName }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-12 margin-b-5">
        <input id="inv_date_beg" type="text" data-reset-value="{{ date('m/d/Y') }}" name="inv_date_beg" class="form-control reset-value" placeholder="Enter report begin date filter"
               value="{{ date('m/d/Y' , strtotime('-180 days'))   }}">
    </div>
    <div class="col-md-12 margin-b-5">
        <input id="inv_date_end" type="text" data-reset-value="{{ date('m/d/Y') }}" name="inv_date_end" class="form-control reset-value" placeholder="Enter report end date filter"
               value="{{ date('m/d/Y') }}">
    </div>

    <div class="col-md-12 margin-b-5">
    <input id="mat-auto-lookup1"  name="mat-auto-lookup" type="text" class="form-control act-search disabled" placeholder="Search by Material Name">
    <div style="position: relative" id="autoDisplay"></div>
    </div>

    <div id="mat-auto-tooltip1" class="tooltip bottom tooltipFade" role="tooltip">
        <div class="tooltip-arrow"></div>
        <div id="mat-display1" class="tooltip-inner auto_display" style="overflow-y: scroll;">

        </div>
    </div>

    <div class="col-md-12 margin-b-5">
        <select id="sort1" name="sort1" class="form-control resetSelect select-default" >
            <option value="name" selected>Select Sort1</option>
                <option value="abvr">Office</option>
                <option value="month">Date</option>
                <option value="name">Material</option>
        </select>
    </div>
    <div class="col-md-12 margin-b-5">
        <select id="sort2" name="sort2" class="form-control resetSelect select-default" >
            <option value="name" selected>Select Sort2</option>
                <option value="abvr">Office</option>
                <option value="month">Date</option>
                <option value="name">Material</option>
        </select>
    </div>
    <div class="col-md-12 margin-b-5">
        <select id="sort3" name="sort3" class="form-control resetSelect select-default" >
            <option value="name" selected>Select Sort3</option>
                <option value="abvr">Office</option>
                <option value="month">Date</option>
                <option value="name">Material</option>
        </select>
    </div>


    <div class="col-md-12 margin-b-5">
        <button class="btn btn-success alert-success" id="inv_report" type="submit">Run Report</button>
        <button class="btn btn-danger alert-danger" id="cancel_inv" type="button">Cancel</button>
    </div>
</form>
@section('scripts')
    <script src="<?php echo asset('/js/cpr.backend.js'); ?>" type="text/javascript"></script>
@endsection