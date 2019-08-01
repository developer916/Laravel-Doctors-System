<div class="col-md-12 edit-box">
    <h4>Primary Address</h4>
    <hr>
    <div class="form-group">
        <label for="coName" class="col-sm-3 control-label">Company / Institution</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $act->actName  }}" name="company_name" id="coName"
                   placeholder="Company Name" minlength="3" required>
        </div>
    </div>

    <div class="form-group">
        <label for="co" class="col-sm-3 control-label">C/O</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" name="co" value="{{ $location->care_of }}" id="coName" placeholder="Care Of">
        </div>
    </div>
    <div class="form-group">
        <label for="addy1" class="col-sm-3 control-label">Address Line 1</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" name="address_1" value="{{ $location->address1 }}" id="addy1"
                   placeholder="Address Line 1" minlength="3" required>
        </div>
    </div>

    <div class="form-group">
        <label for="addy2" class="col-sm-3 control-label">Address Line 2</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" name="address_2" value="{{ $location->address2}}" id="addy2"
                   placeholder="Address Line 2">
        </div>
    </div>

    <div class="form-group">
        <label for="addy2" class="col-sm-3 control-label">Address Line 3***</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" name="address_3" value="{{ $location->address3 }}" id="addy3"
                   placeholder="(EDIT: Only show on report IF filled){Change Placeholder for Production}">
        </div>
    </div>


    <div class="form-group">
        <label for="city" class="col-sm-3 control-label">Town / City</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $location->city }}" name="city" id="city" placeholder="City" minlength="3" required>
        </div>
    </div>
    <div class="form-group">
        <label for="state" class="col-sm-3 control-label">State</label>

        <div class="col-sm-7">
            <select class="form-control" name="state" data-selected="{{ $location->state_id }}" id="state" placeholder="State">
                <option value="default">Please Choose a State...</option>
                @foreach($states as $state)
                    <option value="{{ $state['id'] }}" {{ ( intval( $state['id'] ) == $location->state_id ?   'selected="true"' : '')  }} >{{ $state['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="zip" class="col-sm-3 control-label">Zip Code</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $location->zipcode }}" name="zip" id="zip" placeholder="Zip Code" minlength="5" required>
        </div>
    </div>

    <div class="form-group">
        <label for="taxstate" class="col-sm-3 control-label">Tax State </label>

        <div class="col-sm-7">
            <select class="form-control" name="taxstate" id="taxstate" placeholder="Tax State">
                <option value="default">Please Choose a State...</option>
                @foreach($taxStates as $state_id => $state_name)
                    <option value="{{ $state_id }}" {{ ( intval( $state_id ) == $actTax->taxState ?   'selected="true"' : '')  }}> {{ $state_name }}</option>
                    @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="dist" class="col-sm-3 control-label">District</label>

        <div class="col-sm-7">
            <select class="form-control" name="dist" id="dist" placeholder="State" >
                <option value="default">Please Choose a Tax District...</option>
                @foreach($taxDistricts as $t)
                    <option value="{{ $t['id'] }}" {{ ( intval( $t['id'] ) == $actTax->taxDistrict ?   'selected="true"' : '')  }}>
                        {{ (intval($t['id_code']) < 10? '0'. $t['id_code']:$t['id_code']) }} &mdash; {{ $t['name'] }}
                    </option>
                @endforeach
            </select>
            <span id="tax-dist-spinner" class="invis">
                <i class="fa fa-spinner fa-spin fa-2x"></i>
            </span>
        </div>
    </div>
</div>