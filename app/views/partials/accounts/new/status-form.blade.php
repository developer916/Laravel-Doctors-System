<div class="col-md-12 edit-box">
    <h4>Status</h4>
    <hr>
    <div class="form-group">
        <label for="act_status" class="col-sm-3 control-label">Status</label>

        <div class="col-sm-7">
            <select class="form-control" value=""
                    name="act_status" id="act_status" placeholder="">
                @foreach($status['status'] as $sk => $sv)
                    <option value="{{ $sk }}">{{ $sv }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div id="comb_disp" class="form-group poof">
        <label for="combine_with" class="col-sm-3 control-label">Combined With</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" name="combine_with" id="combine_with" placeholder="">
        </div>
    </div>
    <div class="form-group">
        <label for="status_date" class="col-sm-3 control-label">Status Date</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" name="status_date" id="status_date" placeholder="mm/dd/yyyy">
        </div>
    </div>
    <div class="form-group">
        <label for="status_type" class="col-sm-3 control-label">Type</label>

        <div class="col-sm-7">
            <select class="form-control" name="status_type" id="status_type" placeholder="">
                <option value="default">Type &mdash;</option>
                @foreach($status['types'] as $tk)
                    <option value="{{ $tk['id']  }}">{{ $tk['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div id="freq_disp" class="form-group poof">
        <label for="status_freq" class="col-sm-3 control-label">Frequency</label>

        <div class="col-sm-7">
            <select class="form-control" name="status_freq" id="status_freq" >
                <optgroup id="fqt" label="Quarterly">
                    @foreach($status['fqt'] as $fqk => $fqv)
                        <option value="{{ $fqk }}">{{ $fqv }}</option>
                    @endforeach
                </optgroup>
                <optgroup id="fbm" label="Bi-Monthly">
                    @foreach($status['fbm'] as $fbk => $fbv)
                        <option value="{{ $fbk }}">{{ $fbv }}</option>
                    @endforeach
                </optgroup>

            </select>
        </div>
    </div>

    <div id="freq_fountain_cleaning" class="form-group poof">
        <label for="status_freq" class="col-sm-3 control-label">Frequency</label>

        <div class="col-sm-7">
            <select class="form-control" name="status_freq" id="status_freq_fountain_cleaning">
                <optgroup id="fqt_fountain_cleaning" label="Quarterly">
                    @foreach($status['fqt'] as $fqk => $fqv)
                        <option value="{{ $fqk }}">{{ $fqv }}</option>
                    @endforeach
                </optgroup>
                <optgroup id="fbm_fountain_cleaning" label="Bi-Monthly">
                    @foreach($status['fbm'] as $fbk => $fbv)
                        <option value="{{ $fbk }}">{{ $fbv }}</option>
                    @endforeach
                </optgroup>

            </select>
        </div>
    </div>

    <div id="other_group" class="form-group poof">
        <label for="status_other" class="col-sm-3 control-label">Other Frequency</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" name="status_other" id="status_other" placeholder="">
        </div>
    </div>
</div>