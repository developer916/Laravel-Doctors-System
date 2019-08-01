
<div class="col-md-12 edit-box">
    <h4>Contact Name</h4>
    <hr>
    <div class="form-group">
        <label for="contact_name" class="col-sm-3 control-label">Name</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $contact->firstName }}" name="contact_name" id="contact_name" placeholder="Contact Name">
        </div>
    </div>
    <div class="form-group">
        <label for="contact_title" class="col-sm-3 control-label">Title</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" value="{{ $contact->title }}" name="contact_title" id="contact_title" placeholder="Title">
        </div>
    </div>
    <div class="form-group">
        <label for="contact_phone" class="col-sm-3 control-label">Phone</label>
        <div class="col-sm-7">
            <input type="text" class="form-control phone" value="{{ $phone_work . ' x ' . $phone_work_ext }}" name="contact_phone" id="contact_phone" placeholder="xxx-xxx-xxxx xxxx">
        </div>
    </div>
    <div class="form-group">
        <label for="contact_fax" class="col-sm-3 control-label">Fax</label>
        <div class="col-sm-7">
            <input type="text" class="form-control mobile"  value="{{ $contact->phone_fax }}" name="contact_fax" id="contact_fax" placeholder="xxx-xxx-xxxx">
        </div>
    </div>
    <div class="form-group">
        <label for="contact_mobile" class="col-sm-3 control-label">Mobile</label>
        <div class="col-sm-7">
            <input type="text" class="form-control mobile" value="{{ $contact->phone_cell }}" name="contact_mobile" id="contact_mobile" placeholder="xxx-xxx-xxxx">
        </div>
    </div>
    <div class="form-group">
        <label for="contact_email" class="col-sm-3 control-label">Email</label>
        <div class="col-sm-7">
            <input type="email" class="form-control" value="{{ $contact->email }}" name="contact_email" id="contact_email" placeholder="Email">
        </div>
    </div>
</div>