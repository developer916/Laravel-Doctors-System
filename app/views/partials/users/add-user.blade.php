<h2>Add New User</h2>
<div class="row">
	<div class="col-md-12">
		<form class="form-inline">
			<div class="form-group">
				<input type="text" id="user-new-first" name="user-new-first"
					   class="form-control input-60 user-new-first" placeholder="First Name">
			</div>
			<div class="form-group">
				<input type="text" id="user-new-middle" name="user-new-middle"
					   class="form-control input-60 user-new-middle" placeholder="Middle Name">
			</div>
			<div class="form-group">
				<input type="text" id="user-new-last" name="user-new-last"
					   class="form-control input-60 user-new-last" placeholder="Last Name">
			</div>
		</form>

	</div>
	<div>&nbsp;</div>
	<div class="col-md-12">
		<div class="form-group">
			<input type="text" id="user-new-email" class="form-control user-new-email" placeholder="Email (UserName)">
		</div>
	</div>

    <div class="col-md-12">
        <div class="form-group"><input type="radio" value="normal"  name="user-type" checked>Normal User &nbsp;&nbsp;&nbsp;
        <input type="radio" value="tech" id="user_is_tech" class="user_is_tech"  name="user-type">Technician
        </div>
    </div>

    <div class="col-md-12 invis add-user-tech" id="add-user-tech">
        <div class="form-group has_error">
            <input type="text" class="form-control tech-valid tech-inputs user_tech_code" name="tech_code" id="user_tech_code" placeholder="Code">
        </div>

        <div class="form-group">
            <input type="text" class="form-control tech-valid tech-inputs user_tech_name" name="tech_name" id="user_tech_name" placeholder="Technician's Name">
        </div>

        <div class="form-group">
            <input type="text" class="form-control tech-valid tech-inputs user_tech_rate" name="tech_rate" id="user_tech_rate" placeholder="Pay Rate">
        </div>

    </div>
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-6">
				<h3>Offices</h3>
			</div>
			<div class="col-md-12 text-right">
                            <span data-check="all" data-type="office" class="perm-check check-all"
								  style="color: green;"><i class="fa fa-check-square-o"></i> All</span>&nbsp;|&nbsp;
                            <span data-check="none" data-type="office" class="perm-check check-none"
								  style="color: red;"><i class="fa fa-square-o"></i> None</span>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 text-right">
				@foreach( $officesData->left as $od )
				<div class="col-md-12">
					<label style="vertical-align: middle;">
						{{ $od->abvr }} &mdash; {{ $od->officeName }} &nbsp;&nbsp;
						<input type="checkbox" class="office-type" name="offices[]"
							   value="{{ $od->id }}">
					</label>
				</div>
				@endforeach
			</div>
			<div class="col-md-6 text-left">
				@foreach( $officesData->right as $od )
				<div class="col-md-12">
					<label style="vertical-align: middle;">
						<input type="checkbox" class="office-type" name-="offices[]"
							   value="{{ $od->id }}">&nbsp;&nbsp; {{ $od->abvr }} &mdash; {{ $od->officeName }}
					</label>
				</div>
				@endforeach
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<select name="user-new-user_level" id="user-new-user_level"
							class="form-control user-new-user_level">
						<option value="default">Please Select a Level</option>
						@foreach($userLevels as $ul)
						<option value="{{ $ul->id }}">{{ $ul->level_name }}</option>

						@endforeach
					</select>


				</div>
			</div>
			<h3>Permissions</h3>
			<div class="col-md-12 text-right">
                            <span data-check="all" data-type="perms" class="perm-check check-all" style="color: green;"><i
									class="fa fa-check-square-o"></i> All</span>&nbsp;|&nbsp;
                            <span data-check="none" data-type="perms" class="perm-check check-none" style="color: red;"><i
									class="fa fa-square-o"></i> None</span>
			</div>
			<div class="col-md-4">
				<h4>Account</h4>
				<div class="col-md-12">
					<label>
						<input class="perm-type" type="checkbox" name="parms[]" value="14"> Create
					</label>
				</div>
				<div class="col-md-12">
					<label>
						<input class="perm-type" type="checkbox" name="parms[]" value="15"> Modify
					</label>
				</div>
				<div class="col-md-12">
					<label>
						<input class="perm-type" type="checkbox" name="parms[]" value="16"> View
					</label>
				</div>
				<div class="col-md-12">
					<label>
						<input class="perm-type" type="checkbox" name="parms[]" value="17"> Delete
					</label>
				</div>
			</div>
			<div class="col-md-4">
				<h4>Field Activity</h4>
				<div class="col-md-12">
					<label>
						<input class="perm-type" type="checkbox" name="parms[]" value="20"> Create
					</label>
				</div>
				<div class="col-md-12">
					<label>
						<input class="perm-type" type="checkbox" name="parms[]" value="21"> Modify
					</label>
				</div>
				<div class="col-md-12">
					<label>
						<input class="perm-type" type="checkbox" name="parms[]" value="22"> View
					</label>
				</div>
				<div class="col-md-12">
					<label>
						<input class="perm-type" type="checkbox" name="parms[]" value="23"> Delete
					</label>
				</div>
			</div>
			<div class="col-md-4">
				<h4>Inventory</h4>
				<div class="col-md-12">
					<label>
						<input class="perm-type" type="checkbox" name="parms[]" value="25"> Create
					</label>
				</div>
				<div class="col-md-12">
					<label>
						<input class="perm-type" type="checkbox" name="parms[]" value="26"> Modify
					</label>
				</div>
				<div class="col-md-12">
					<label>
						<input class="perm-type" type="checkbox" name="parms[]" value="24"> View
					</label>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<h4>Worksheets</h4>
				<div class="col-md-12">
					<label>
						<input class="perm-type" type="checkbox" name="parms[]" value="30"> Modify
					</label>
				</div>
				<div class="col-md-12">
					<label>
						<input class="perm-type" type="checkbox" name="parms[]" value="29"> View
					</label>
				</div>
			</div>
			<div class="col-md-4">
				<h4>Reports</h4>
				<div class="col-md-12">
					<label>
						<input class="perm-type" type="checkbox" name="parms[]" value="19"> View
					</label>
				</div>
			</div>
			<div class="col-md-4">
				<h4>Admin</h4>
				<div class="col-md-12">
					<label>
						<input class="perm-type" type="checkbox" name="parms[]" value="27"> Admin
					</label>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div id="user-new-exit" class="btn btn-danger alert-danger">Cancel</div>
		<div id="user-do-new" class="user-do-new btn btn-success alert-success"><i class="fa fa-check"></i>
			Add
		</div>
	</div>
</div>