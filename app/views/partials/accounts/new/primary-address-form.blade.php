<div class="col-md-12 edit-box">
    <h4>Primary Address</h4>
    <hr>
    <div class="form-group">
        <label for="coName" class="col-sm-3 control-label">Company / Institution</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $act_name or '' }}" name="company_name" id="coName"
                   placeholder="Company Name" minlength="3" required>
        </div>
    </div>

    <div class="form-group">
        <label for="co" class="col-sm-3 control-label">C/O</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" name="co" value="{{ $act_co or '' }}" id="coName" placeholder="Care Of">
        </div>
    </div>
    <div class="form-group">
        <label for="addy1" class="col-sm-3 control-label">Address Line 1</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" name="address_1" value="{{ $act_address or '' }}" id="addy1"
                   placeholder="Address Line 1" minlength="3" required>
        </div>
    </div>

    <div class="form-group">
        <label for="addy2" class="col-sm-3 control-label">Address Line 2</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" name="address_2" value="{{ $act_address2 or '' }}" id="addy2"
                   placeholder="Address Line 2">
        </div>
    </div>

    <div class="form-group">
        <label for="addy2" class="col-sm-3 control-label">Address Line 3***</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" name="address_3" value="{{ $act_address2 or '' }}" id="addy3"
                   placeholder="(EDIT: Only show on report IF filled){Change Placeholder for Production}">
        </div>
    </div>


    <div class="form-group">
        <label for="city" class="col-sm-3 control-label">Town / City</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $act_city or ''}}" name="city" id="city" placeholder="City" minlength="3" required>
        </div>
    </div>
    <div class="form-group">
        <label for="state" class="col-sm-3 control-label">State</label>

        <div class="col-sm-7">
            <select class="form-control required" name="state" id="state" placeholder="State">
                <option value="default">Please Choose a State...</option>
                @foreach($states as $state)
                    <option value="{{ $state['id'] }}">{{ $state['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="zip" class="col-sm-3 control-label">Zip Code</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $act_zip or '' }}" name="zip" id="zip" placeholder="Zip Code" minlength="5" required>
        </div>
    </div>

    <div class="form-group">
        <label for="taxstate" class="col-sm-3 control-label">Tax State</label>

        <div class="col-sm-7">
            <select class="form-control" name="taxstate" id="taxstate" placeholder="Tax State">
                <option value="default">Please Choose a State...</option>
                @foreach($taxStates as $key => $state)
                    <option value="{{ $key }}">{{ $state }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="dist" class="col-sm-3 control-label">District</label>

        <div class="col-sm-7">
            <select class="form-control" name="dist" id="dist" placeholder="State" disabled>
                <option value="default">Please Choose a Tax District...</option>
            </select>
            <span id="tax-dist-spinner" class="invis">
                <i class="fa fa-spinner fa-spin fa-2x"></i>
            </span>

        </div>
    </div>
</div>