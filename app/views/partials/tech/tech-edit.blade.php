<h2>Edit Technician</h2>

<div class="form-group has_error">
    <input type="text" class="form-control tech-edit-valid" name="tech_code" id="tech_edit_code" placeholder="Code">
</div>

<div class="form-group">
    <input type="text" class="form-control tech-edit-valid" name="tech_name" id="tech_edit_name" placeholder="Technician's Name">
</div>
<input id="tech-token" type="hidden" value="{{ csrf_token() }}">

<div class="form-group">
    <select class="form-control tech-edit-valid" name="tech_office" id="tech_edit_office" >
        <option value="default">Office</option>
        @foreach($offices as $o)
            <option value="{{ $o['id'] }}">{{ $o['officeName']  }}</option>
        @endforeach
    </select>
</div>



<div class="form-group">
    <input type="text" class="form-control tech-edit-valid" name="tech_rate" id="tech_edit_rate" placeholder="Pay Rate">
</div>
<div class="form-group">
    <label class="checkbox-inline">
        <input type="checkbox" id="tech_active" value="1"> Active
    </label>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="edit-tech" class="btn btn-success alert-success">
            <i class="fa fa-plus"></i>
            Edit Technician
        </div>
        <div id="close-edit-tech" class="btn btn-danger alert-danger">
            <i class="fa fa-remove"></i>
            Cancel
        </div>
    </div>
</div>