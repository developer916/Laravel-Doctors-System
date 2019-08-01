<div class="col-md-12 edit-box">
    <div>
        <div class="col-md-8">
            <h4>Notes</h4>
        </div>
        <div class="col-md-2 _flex_end test-icons">
            <div style="display:inline-block;">
                <i class="fa fa-lg fa-area-chart"></i>
            </div>
            <div style="display:inline-block;">
                <i class="fa fa-lg fa-anchor"></i>
            </div>
            <div style="display:inline-block;">
                <i class="fa fa-lg fa-map"></i>
            </div>
            <div style="display:inline-block;">
                <i class="fa fa-lg fa-info"></i>
            </div>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
    </div>
    <div class="form-group">
        <label for="notes_permit" class="col-sm-3 control-label">Permit #</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" name="notes_permit" id="notes_permit" placeholder="">
        </div>
    </div>

    <div class="form-group">
        <label for="notes_expire" class="col-sm-3 control-label">Expire Date</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" name="notes_expire" id="notes_expire" placeholder="mm/dd/yyyy">
        </div>
    </div>

    <div class="form-group">
        <label for="notes_note" class="col-sm-3 control-label">Notes</label>
        <div class="col-sm-7">
            <textarea class="form-control" rows="10" id="notes_note" name="notes_note">{{ $act_notes or '' }}</textarea>
        </div>
    </div>



    <div class="form-group">
        <label for="notes_site_add" class="col-sm-3 control-label">Site Address</label>
        <div class="col-sm-7">
            <textarea class="form-control" rows="4" name="notes_site_add">{{ $act_site_address or '' }}</textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="zip" class="col-sm-3 control-label">Non-Automatic Renewal</label>
        <div class="col-sm-7 text-center">
            <input type="checkbox" name="note_auto" value="note_auto">
        </div>
    </div><div class="form-group">
        <label for="zip" class="col-sm-3 control-label">Non-Commission</label>
        <div class="col-sm-7 text-center">
            <input type="checkbox" name="note_comm" value="note_comm">
        </div>
    </div>

    <div class="form-group">
        <label for="notes_sec_phone" class="col-sm-3 control-label">Telephone Number</label>
        <div class="col-sm-7 text-center">
            <input type="text" value="{{ $act_sec_phone or '' }}" class="form-control phone" name="notes_sec_phone" id="notes_sec_phone" placeholder="">
        </div>
    </div>
    <div class="form-group">
        <label for="notes_contact" class="col-sm-3 control-label">Contact</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $act_contact_two or ''}}" name="notes_contact" id="notes_contact" placeholder="">
        </div>
    </div>

    <div class="form-group">
        <label for="notes_email" class="col-sm-3 control-label">Email</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $act_corp_email or '' }}" name="notes_email" id="notes_email" placeholder="">
        </div>
    </div>

</div>