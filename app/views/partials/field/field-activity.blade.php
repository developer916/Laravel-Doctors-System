<div class="row">
    <div class="col-md-12">
    <h2>Field Activity</h2>
    <p>Please enter an account number and date to begin.</p>
    <div class="form-group has_error">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="text" class="f_a_name form-control fa-valid fa-inputs " name="fa_account" id="f_a_account"
               placeholder="Account Number">
        <div id="faTooltipFade" class="tooltip bottom tooltipFade"
             role="tooltip">
            <div class="tooltip-arrow"></div>
            <div id="fa-autodisplay" class="tooltip-inner auto_display autoDisplay"></div>
        </div>
    </div>
    <div class="form-group">
        <input type="text" class="form-control f_a_new_tech" id="f_a_new_tech" placeholder="Tech">
        <div class="faTechTooltipFade tooltip bottom tooltipFade"
             role="tooltip">
            <div class="tooltip-arrow"></div>
            <div class="tooltip-inner auto_display autoDisplay fa-tech-autodisplay"></div>
        </div>
                
    </div>
    <!-- <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">tech</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control f_a_edit_tech" id="f_a_edit_tech" placeholder="Tech">
                </div>
            </div> -->

    <div class="form-group">
        <input type="text" class="fa_date form-control fa-valid fa-inputs"  name="fa_date" id="f_a_date"
               placeholder="Date" value="{{ date('m/d/Y') }}">
        <span class="fa_date_error red invis"><i class="fa fa-asterisk"></i> Please # use the following formats (mm-dd-yyyy OR mm/dd/yyyy)</span>
    </div>
    <div id="fa_checking" class="fa_checking blue fa-errors invis">
        <span class="blue"><i class="fa fa-spin fa-spinner fa-2x"></i> Checking if an activity already exists</span>
    </div>
    <div id="fa_fetching" class="fa_fetching blue fa-errors invis">
        <span class="blue"><i class="fa fa-spin fa-spinner fa-2x"></i> Fetching Information</span>
    </div>
    <div class="fa_edit_question invis">
        <div class="col-md-9">
            <span>
                <p>
                    That Field Activity already exists. Would you like to edit it?
                </p>
            </span>
        </div>
        <div class="col-md-3">
            <span class="green tool-btn fa_edit_yes">Yes</span>&nbsp;&nbsp;
            <span class="red tool-btn fa_edit_no">No</span>
        </div>
    </div>
    <div class="f_a_new">
        <!-- <h4>New Field Activity for <span class="f_a_edit_act">{ACT}</span></h4> -->
        <h4>New Field Activity</h4>


        <form class="form-horizontal">
            
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Man Hours</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control f_a_new_man_hours"
                           placeholder="Man Hours">
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>Quantity</th>
                    <th>Units</th>
                    <th>Cost</th>
                    <th>Total</th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="fa_new_table">
                <tr class="addMat">
                    <td>
                        <input type="text" class="new-code form-control" name="new-code"
                        onkeydown="autofillInput(event)">
                        <div class="faMatTooltipFade tooltip bottom tooltipFade"
                             role="tooltip">
                            <div class="tooltip-arrow"></div>
                            <div class="fa-mat-autodisplay tooltip-inner auto_display autoDisplay"></div>
                        </div>
                    </td>
                    <td style="width: 80px;"><input type="text" name="new-qty" class="new-qty form-control"></td>
                    <td class="new-units"></td>
                    <td class="new-cost"></td>
                    <td class="new-total"></td>
                    <td class="delete-row">
                        <i class="fa fa-remove"></i>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Notes</label>
                <div class="col-sm-10">
                    <textarea name="notes" class="f_a_new_notes form-control " cols="30" rows="5"></textarea>
                </div>
            </div>

        </form>
    </div>

    <div class="f_a_edit invis">
        <h4>Edit Field Activity for <span class="f_a_edit_act">{ACT}</span></h4>

        <form class="form-horizontal">
        <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Tech</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control f_a_new_tech" id="f_a_new_tech" placeholder="Tech">
                    <div id="faTechTooltipFade" class="tooltip bottom tooltipFade"
                         role="tooltip">
                        <div class="tooltip-arrow"></div>
                        <div id="fa-tech-autodisplay" class="tooltip-inner auto_display autoDisplay"></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Man Hours</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control f_a_edit_man_hours" id="f_a_edit_man_hours"
                           placeholder="Man Hours">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Notes</label>
                <div class="col-sm-10">
                    <textarea name="notes" id="f_a_edit_notes"  class="form-control " cols="30" rows="5"></textarea>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>Quantity</th>
                    <th>Units</th>
                    <th>Cost</th>
                    <th>Total</th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="fa_edit_table"></tbody>
            </table>
        </form>


    </div>
    <div id="fa_saving" class="fa_fetching blue fa-errors invis">
        <span class="blue"><i class="fa fa-spin fa-spinner fa-2x"></i> Saving Field Activity</span>
    </div>
    <div id="fa_saved" class="fa_fetching green fa-errors invis">
        <span class="green"><i class="fa fa-check"></i> Field Activity Saved</span>
    </div>
    <div class=" pull-right">
        <div id="f-a-save-new" class="btn btn-success alert-success"><i class="fa fa-check"></i> Save</div>
        <div id="f-a-exit" class="btn btn-danger alert-danger">
            Back
        </div>
    </div>

    </div>
</div>

