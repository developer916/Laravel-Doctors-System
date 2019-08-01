<div class="col-md-12 edit-box">
    <h4>Date</h4>
    <hr>
    <div class="form-group">
        <label for="date_since" class="col-sm-3 control-label">Cust. Since</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{  date('m/d/Y') }}" name="date_since" id="date_since"
                   placeholder="mm/dd/yyyy">
        </div>
    </div>
    <div class="form-group">
        <label for="date_begin" class="col-sm-3 control-label">Begin Date</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="" name="date_begin" id="date_begin"
                   placeholder="mm/dd/yyyy" required>
        </div>
    </div>
    <div class="form-group">
        <label for="date_end" class="col-sm-3 control-label">End Date</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="" name="date_end" id="date_end" placeholder="mm/dd/yyyy" required>
        </div>
    </div>
</div>