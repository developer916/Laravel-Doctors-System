<h2>Add New Technician</h2>

<div class="col-md-12">
    <div class="form-group"><input type="radio" value="normal"  name="tech-user-type" checked>Tech already a User &nbsp;&nbsp;&nbsp;
        <input type="radio" value="tech" id="tech-with-user"  name="tech-user-type">Tech with new user
    </div>
</div>

<div class="col-md-12" id="addTech">

    <div class="form-group has_error">
        <input type="text" class="form-control tech-valid" name="tech_code" id="tech_code" placeholder="Code">
    </div>

    <div class="form-group">
        <input type="text" class="form-control tech-valid" name="tech_name" id="tech_name"
               placeholder="Technician's Name">
    </div>

    <div class="form-group">
        <select class="form-control tech-valid" name="tech_user" id="tech_user">
            <option value="default">User</option>
            @foreach($users as $o)
                <option value="{{ $o['id'] }}">{{ $o['last_name'] . ', ' . $o['first_name'] . ' - ' . $o['email']  }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <select class="form-control tech-valid" name="tech_office" id="tech_office">
            <option value="default">Office</option>
            @foreach($offices as $o)
                <option value="{{ $o['id'] }}">{{ $o['officeName']  }}</option>
            @endforeach
        </select>
    </div>


    <div class="form-group">
        <input type="text" class="form-control tech-valid" name="tech_rate" id="tech_rate" placeholder="Pay Rate">
    </div>


    <div class="row">
        <div class="col-md-12">
            <div id="add-tech" class="btn btn-success alert-success">
                <i class="fa fa-plus"></i>
                Add Technician
            </div>
<!--            <div id="close-add-tech" class="btn btn-danger alert-danger">
                <i class="fa fa-remove"></i>
                Cancel
            </div>
-->
        </div>
    </div>
</div>

<div class="invis col-md-12" id="userTech">
    @include('partials.users.add-user')
</div>