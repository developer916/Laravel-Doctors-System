    <div class="col-md-12 margin-b-5"><h4>Customer Activity Report</h4></div>
    <form target="_blank" id="car-report" role="form" method="post" action="{{ route('car') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-md-12 margin-b-5">
            <input id="act_num" type="text" name="accountNumber" class="form-control resetInput" placeholder="Account Number(s) {12345, 54321}"
                   value="{{ (isset( $act->accountNumber ) ? $act->accountNumber :'' ) }}">
        </div>
        <div class="col-md-12 margin-b-5">
            <input id="ren_beg" type="text" name="startDate" class="form-control resetInput" placeholder="Renew Begin Date"
                   value="">
        </div>
        <div class="col-md-12 margin-b-5">
            <input id="ren_end" type="text" name="endDate" class="form-control resetInput" placeholder="Renew End Date"
                   value="">
        </div>
        <div class="col-md-12 margin-b-5">
            <input id="beg_d" type="text" name="serviceStart" class="form-control resetInput"
                   placeholder="Treatment Begin Date" value="">
        </div>
        <div class="col-md-12 margin-b-5">
            <input id="end_d" type="text" name="serviceEnd" class="form-control resetInput"
                   placeholder="Treatment End Date" value="">
        </div>
        <div class="col-md-12 margin-b-5">
            <select id="off_ask" name="office" class="form-control resetSelect" id="office">
                <option value="default" selected>Select office</option>
                @foreach($offices as $off)
                    <option value="{{ $off->id }}">{{ $off->abvr }} &mdash; {{ $off->officeName }}</option>
                    @endforeach
            </select>
        </div>
        <div class="col-md-12 margin-b-5">
            <select id="tech_ask" name="tech" class="form-control resetSelect" id="tech">
                <option value="default" selected>Please Choose Salesman</option>
                @foreach($tech as $tec)
                    <option value="{{ $tec->id }}">{{ $tec->code }} &mdash; {{ $tec->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12 margin-b-5">
            <button class="btn btn-success alert-success" id="run_cpr" type="submit">Run Report</button>
            <button class="btn btn-danger alert-danger" id="cancel_cpr" type="button">Cancel</button>
        </div>
    </form>