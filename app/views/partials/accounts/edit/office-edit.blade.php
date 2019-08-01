<div class="col-md-12 edit-box">
    <h4>Office</h4>
    <hr>
    <div class="form-group">
        <label for="office_office" class="col-sm-3 control-label">Main Office</label>

        <div class="col-sm-7">
            <select class="form-control" name="office_office" id="office_office" placeholder="">
                <option>Please Select an office</option>
                @foreach($office as $off)
                    <option value="{{ $off['id'] }}" {{ ( intval( $off['id'] ) == $actOffice->office_id ?   'selected="true"' : '')  }}>{{ $off['abvr'] }} &mdash; {{ $off['officeName'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>