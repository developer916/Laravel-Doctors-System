<div class="col-md-12 edit-box">
    <h4>Budget</h4>
    <hr>
    <div class="form-group">
        <label for="zip" class="col-sm-3 control-label">Contract Amount</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $act_contact_amount or '' }}" name="budget_contract" id="budget_contract"
                   placeholder="0.00" >
        </div>
    </div>
    <div class="form-group">
        <label for="zip" class="col-sm-3 control-label">Billing Amount</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $act_billing_amount or '' }}" name="budget_billing" id="budget_billing"
                   placeholder="0.00" >
        </div>
    </div>
    <div class="form-group">
        <label for="zip" class="col-sm-3 control-label">Budget</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $act_budge or '' }}" name="budget_budge" id="budget_budge" placeholder="0.00" >
        </div>
    </div>
    <div class="form-group">
        <label for="zip" class="col-sm-3 control-label">Start-Up Amount</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $act_start_up_amount or '' }}" name="budget_start" id="budget_start"
                   placeholder="0.00" >
        </div>
    </div>
    <div class="form-group">
        <label for="zip" class="col-sm-3 control-label">Initial Budget</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $act_init_budge  or '' }}" name="budget_init" id="budget_init" placeholder="0.00">
        </div>
    </div>
    <div class="form-group">
        <label for="budget_terms" class="col-sm-3 control-label">Terms</label>

        <div class="col-sm-7">
            <select class="form-control" name="budget_terms" id="budget_terms" placeholder="">
                <option value="default">Please Select Terms</option>
                @foreach($terms as $tm)
                    <option value="{{ $tm['id'] }}">{{ $tm['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

</div>