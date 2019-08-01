<h4>Create Inventory</h4>
<form target="_blank" id="car-report" role="form" method="post" action="{{ route('create_inv') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="col-md-12 margin-b-5">
        <select id="off_ask" name="office" class="form-control resetSelect select-default" id="office" required>
            <option value="" selected>Select office</option>
            @foreach( $offices as $o)
                <option value="{{ $o->id }}">{{ $o->abvr }} &mdash; {{ $o->officeName }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-12 margin-b-5">
        <input id="inv_date" type="text" data-reset-value="{{ date('m/Y') }}" name="inv_date" class="form-control reset-value" placeholder="Enter Month of new Inventory"
               value="{{ date('m/Y') }}" required>
    </div>
    <div class="col-md-12 margin-b-5">
        <button class="btn btn-success alert-success" id="create_new_inv" type="submit">Create</button>
        <button class="btn btn-danger alert-danger" id="cancel_inv" type="button">Cancel</button>
    </div>
</form>