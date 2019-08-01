<div class="col-md-12 edit-box">
    <h4>Salesman</h4>
    <hr>
    <div class="form-group">
        <label for="salesman_salesman" class="col-sm-3 control-label">Sales Rep</label>

        <div class="col-sm-7">
            <select class="form-control required" name="salesman_salesman" id="salesman_salesman" placeholder="">
                <option value="default">Please Select a Salesman</option>
                @foreach($salesman as $sales)
                    <option value="{{ $sales['id'] }}">{{ $sales['abvr'] }}&nbsp;&mdash;&nbsp;{{ $sales['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="salesman_po" class="col-sm-3 control-label">PO#</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" name="salesman_po" id="salesman_po" placeholder="">
        </div>
    </div>

    <div class="form-group">
        <label for="salesman_exempt" class="col-sm-3 control-label">Tax Exempt#</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" name="salesman_exempt" id="salesman_exempt" placeholder="">
        </div>
    </div>

</div>