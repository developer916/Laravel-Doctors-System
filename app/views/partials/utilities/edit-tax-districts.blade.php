<div class="row">
    <div class="col-md-12">
        <h4>Edit Tax Districts</h4>
        <div class="col-md-10">
        </div>


    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <select class="form-control select-default select-default" name="utilities-tax-state-select" id="utilities-tax-state-select">
                <option value="default">Select a State Please</option>
                @foreach($states as $st)
                    <option value="{{ $st->id }}">{{ $st->name }}</option>
                    @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div id="tax-district-display-table" class="col-md-12 invis no-left-padding no-right-padding">
        <span id="tax-dist-print-header"></span>
        <table class="table table-striped">
            <thead>
                <td>Code</td>
                <td>Name</td>
                <td>Percent</td>
                <td></td>
            </thead>
            <tbody id="tax-dist-display">

            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div id="edit-tax-error" class="col-md-12 invis reset-warning">
            <span class="">
                <i class="fa fa-remove red"></i> Form Error
            </span>
    </div>
    <div id="edit-tax-bad" class="col-md-12 invis reset-warning">
            <span class="">
                <i class="fa fa-remove red"></i> Submit Error: Please try again.
            </span>
    </div>
    <div id="edit-tax-process" class="col-md-12 invis reset-warning">
            <span class="">
                <i class="fa fa-spin fa-spinner blue"></i> Processing
            </span>
    </div>
    <div id="edit-tax-good" class="col-md-12 invis reset-warning">
            <span class="">
                <i class="fa fa-check green"></i> Tax Edit Saved
            </span>
    </div>
</div>
<div class="row" style="margin-top: 10px;">
    <div id="tax-edit-ctrl" class="col-md-12 invis">
        <div id="tax-district-do-edit" class="btn btn-success alert-success">
            <i class="fa fa-edit"></i>
            Save
        </div>

        {{--  <div id="material-delete" class="btn btn-warning alert-warning">
              <i class="fa fa-remove"></i>
              Delete
          </div>--}}
        <div id="tax-district-edit-exit" class="btn btn-danger alert-danger"><i class="fa fa-remove"></i> Cancel</div>
    </div>
    <div class="col-md-12">
        <div id="tax-district-back" class="btn btn-primary alert-primary showMeLater"><i class="fa fa-arrow-left"></i> Back</div>
        <div id="tax-district-print" class="btn btn-primary alert-primary showMeLater" style="margin-left: 10px; display: none;"><i class="fa fa-print"></i> Print</div>
    </div>
</div>