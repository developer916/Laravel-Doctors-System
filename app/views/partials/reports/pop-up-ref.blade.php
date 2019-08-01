    <div class="col-md-12 margin-b-5"><h4>Account Reference List</h4></div>
    <form target="_blank" id="car-report" role="form" method="post" action="{{ route('act_ref') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-md-12 margin-b-5">
            <select id="exp_office" name="exp_office" class="form-control resetSelect office">
                <option value="default" selected>All Offices</option>
                @foreach($offices as $off)
                    <option value="{{ $off->id }}">{{ $off->abvr }} &mdash; {{ $off->officeName }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12 margin-b-5">
            <select id="exp_sales" name="exp_sales" class="form-control resetSelect salesman">
                <option value="default" selected>Select salesman</option>
                @foreach($salesman as $sal)
                    <option value="{{ $sal->id }}">{{ $sal->abvr }} &mdash; {{ $sal->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12 margin-b-5">
            <select id="exp_sort" name="exp_sort" class="form-control resetSelect">>
                <option value="">Sort By --</option>
                <option value="actName">Account Name</option>
                <option value="accountNumber" selected="">Account #</option>
            </select>
        </div>
        <div class="col-md-12 margin-b-5">
            <button class="btn btn-success alert-success" id="run_cpr" type="submit">Run Report</button>
            <button class="btn btn-danger alert-danger" id="cancel_cpr" type="button">Cancel</button>
        </div>
    </form>