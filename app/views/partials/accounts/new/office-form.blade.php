<div class="col-md-12 edit-box">
    <h4>Office</h4>
    <hr>
    <div class="form-group">
        <label for="office_office" class="col-sm-3 control-label">Main Office</label>

        <div class="col-sm-7">
            <select class="form-control" name="office_office" id="office_office" placeholder="">
                <option value="default">Please Select an Office...</option>
                @foreach($office as $off)
                    <option value="{{ $off['id'] }}">{{ $off['abvr'] }} &mdash; {{ $off['officeName'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>