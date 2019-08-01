<div class="row">
    <div>
        <h4>Add Material / Herbicide</h4>
    </div>
    <form id="add-material">
        <input type="hidden" name="_token" id="csrf-token" value="{{ $encrypted_csrf_token }}" />
        <div class="form-group">
            <input type="text" class="form-control input-empty" name="code" id="mat-code" placeholder="Code">
        </div>
        <div class="form-group">
            <input type="text" class="form-control input-empty" name="cost" id="mat-name" placeholder="Name">
        </div>
        <div class="col-md-12 no-right-padding no-left-padding">
            <div class="col-md-6 no-left-padding">
                <div class="form-group">
                    <select class="form-control select-default" name="units" id="mat-units">
                        <option value="default">Select Units</option>
                        <option value="1">1</option>
                        <option value="EA">EA</option>
                        <option value="GAL">Gal</option>
                        <option value="HRL">HRL</option>
                        <option value="LB">LB</option>
                        <option value="LBS">LBS</option>
                        <option value="OZ">OZ</option>
                        <option value="PTS">PTS</option>
                        <option value="QT">QT</option>
                        <option value="QTS">QTS</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 no-right-padding">
                <div class="form-group input-hide invis">
                    <input type="text" class="form-control input-empty" name="other" id="mat-other" placeholder="Other">
                </div>
            </div>
        </div>

        <div class="form-group">
            <input type="text" class="form-control input-empty" name="cost" id="mat-cost" placeholder="Cost">
        </div>
        <div class="form-group">
            <input type="text" class="form-control input-empty" name="primary" id="mat-primary" placeholder="Primary">
        </div>
        <div class="form-group">
            <input type="text" class="form-control input-empty" name="secondary" id="mat-secondary"
                   placeholder="Secondary">
        </div>
        <div id="mat-error" class="col-md-12 invis reset-warning">
            <span class="">
                <i class="fa fa-remove red"></i> Form Error
            </span>
        </div>
        <div id="mat-bad" class="col-md-12 invis reset-warning">
            <span class="">
                <i class="fa fa-remove red"></i> Submit Error: Please try again.
            </span>
        </div>
        <div id="mat-process" class="col-md-12 invis reset-warning">
            <span class="">
                <i class="fa fa-spin fa-spinner blue"></i> Processing
            </span>
        </div>
        <div id="mat-good" class="col-md-12 invis reset-warning">
            <span class="">
                <i class="fa fa-check green"></i> Saved
            </span>
        </div>
    </form>
</div>
<div class="row">
    <div class="col-md-12">
        <div id="material-do-new" class="btn btn-success alert-success"><i class="fa fa-plus"></i>
            Add
        </div>
        <div id="material-new-exit" class="btn btn-danger alert-danger">Cancel</div>
    </div>
</div>