<div class="col-md-12 edit-box">
    <h4>Budget</h4>
    <hr>
    <div class="form-group">
        <label for="budget_contract" class="col-sm-3 control-label">Contract Amount</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $accounting->yearlyAmount }}" name="budget_contract" id="budget_contract"
                   placeholder="0.00" >
        </div>
    </div>
    <div class="form-group">
        <label for="zip" class="col-sm-3 control-label">Billing Amount</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $accounting->billing }}" name="budget_billing" id="budget_billing"
                   placeholder="0.00" >
        </div>
    </div>
    <div class="form-group">
        <label for="budget_budge" class="col-sm-3 control-label">Budget</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $accounting->budget }}" name="budget_budge" id="budget_budge" placeholder="0.00" >
        </div>
    </div>
    <div class="form-group">
        <label for="budget_start" class="col-sm-3 control-label">Start-Up Amount</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $accounting->initialStart }}" name="budget_start" id="budget_start"
                   placeholder="0.00" >
        </div>
    </div>
    <div class="form-group">
        <label for="budget_init" class="col-sm-3 control-label">Initial Budget</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $accounting->initialBudget }}" name="budget_init" id="budget_init" placeholder="0.00" >
        </div>
    </div>
    <div class="form-group">
        <label for="budget_terms" class="col-sm-3 control-label">Terms</label>

        <div class="col-sm-7">
            <select class="form-control" name="budget_terms" id="budget_terms" placeholder="">
                <option value="default">Please Select Terms</option>
                @foreach($terms as $tm)
                    <option value="{{ $tm['id'] }}" {{ ( intval( $tm['id'] ) == $actTerm->term_id ?   'selected="true"' : '')  }}>{{ $tm['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

</div>