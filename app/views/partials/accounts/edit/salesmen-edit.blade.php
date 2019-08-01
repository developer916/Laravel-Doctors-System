<div class="col-md-12 edit-box">
    <h4>Salesman</h4>
    <hr>
    <div class="form-group">
        <label for="state" class="col-sm-3 control-label">Sales Rep</label>

        <div class="col-sm-7">
            <select class="form-control" name="salesman_salesman" id="salesman_salesman" placeholder="" <?php if ( Auth::user()->level == 0 || Auth::user()->level > 2 ){ echo "disabled";} ?>>
                <option value="default">Please Select a Salesman</option>
                @foreach($salesman as $sales)
                    <option value="{{ $sales['id'] }}" {{ ( intval( $sales['id'] ) == $actSalesmen->salesmen_id ?   'selected="true"' : '')  }}>{{ $sales['abvr'] }}&nbsp;&mdash;&nbsp;{{ $sales['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="salesman_po" class="col-sm-3 control-label">PO#</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $info->po_number }}" name="salesman_po" id="salesman_po" placeholder="">
        </div>
    </div>

    <div class="form-group">
        <label for="salesman_exempt" class="col-sm-3 control-label">Tax Exempt#</label>

        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $actTax->exemptNumber }}" name="salesman_exempt" id="salesman_exempt" placeholder="">
        </div>
    </div>

</div>