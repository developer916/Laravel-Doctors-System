<div id="users_menu" class="row">
    <div class="col-md-3">
        <ul class="btn-list">
            <li>
                <div id="users-lookup" class="btn btn-primary">
                    <a>User Lookup</a>
                </div>
            </li>


            <li id="user-levels" class="invis">
                <div class="btn btn-primary btn-sub-menu">
                    <a id="users-levels">User Levels</a>
                </div>
            </li>


        </ul>
    </div>
    <div class="col-md-9">

        {{--user lookup--}}

        <div id="user_lookup" class="invis">
            <div class="row">
                <div id="user-head" class="col-md-12">
                    <h4>Lookup Users By
                        <input type="radio" name="search_select" value="name" checked> Name
                        <input type="radio" name="search_select" value="office"> Office</h4>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12" id="user-by-name">
                        <div class="input-group">
                            <input id="user-lookup-name" placeholder="Lookup User" type="text"
                                   class="form-control act-search"
                                   autocomplete="off">
                                    <span id="getUserInfo" data-userId="" class="input-group-btn">
                                        <a class="btn btn-primary act-btn disabled"
                                           type="button">View</a>
                                    </span>
                        </div>
                        <div style="position: relative" id="userTooltipFade" class="tooltip bottom tooltipFade"
                             role="tooltip">
                            <div class="tooltip-arrow"></div>
                            <div id="userAutoDisplay" class="tooltip-inner auto_display autoDisplay"></div>
                        </div>

                        <div class="invis col-md-12" id="show-user">
                            <div class="col-md-2"><strong>Name:</strong></div>
                            <div class="col-md-10">
                                <label id="user-last-name"></label>,
                                <label id="user-first-name"></label>&nbsp;
                                <label id="user-middle-name"></label>
                            </div>
                            <div class="col-md-2"><strong>Email:</strong></div>
                            <div class="col-md-10"><label id="user-email"></label></div>
                            {{--<div class="col-md-2"><strong>Office:</strong></div>--}}
                            {{--<div class="col-md-10"><label id="user-office"></label></div>--}}
                            <div class="col-md-2"><strong>Level:</strong></div>
                            <div class="col-md-10"><label id="user-level"></label></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="user-show-exit" class="btn btn-danger alert-danger">Cancel</div>
                                    <div id="user-show-edit" class="btn btn-primary alert-primary"><i
                                                class="fa fa-edit"></i> Edit
                                    </div>
                                    <div id="user-remove-edit" class="btn btn-danger alert-danger"><i
                                                class="fa fa-remove"></i> Delete User
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="invis col-md-12" id="user-by-office">
                        <select name="user-office" id="user-lookup-office" class="form-control">
                            <option value="default" selected>Please select office</option>
                            @foreach($offices as $of)
                                <option value="{{ $of->id }}">{{ $of->abvr }} &mdash; {{ $of->officeName }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="invis col-md-12" id="edit-user">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Edit User</h4>
                                <form class="form-inline">
                                    <div class="form-group">
                                        <label for="user-edit-first">First Name</label>
                                        <input type="text" id="user-edit-first" name="user-edit-first"
                                               class="form-control input-60" placeholder="First Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="user-edit-middle">Middle Name</label>
                                        <input type="text" id="user-edit-middle" name="user-edit-middle"
                                               class="form-control input-60" placeholder="Middle Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="user-edit-last">Last Name</label>
                                        <input type="text" id="user-edit-last" name="user-edit-last"
                                               class="form-control input-60" placeholder="Last Name">
                                    </div>
                                </form>
                            </div>
                            <div>&nbsp;</div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="user-edit-email">Email</label>
                                    <input type="text" id="user-edit-email" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="user-edit-password">Password</label>
                                    <input type="text" id="user-edit-password" class="form-control" placeholder="Password">
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
                                    <div class="form-group">
                                        <select name="user-edit-user_level" id="user-edit-user_level"
                                                class="form-control">
                                            <option value="default">Please Select a Level</option>
                                            @foreach($userLevels as $ul)
                                                <option value="{{ $ul->id }}">{{ $ul->level_name }}</option>

                                            @endforeach
                                        </select>


                                    </div>
                                    <h3>Permissions</h3>
                                    <div class="col-md-12 text-right">
                                        <span data-check="all" data-type="perms" class="perm-check check-all"
                                              style="color: green;"><i class="fa fa-check-square-o"></i> All</span>&nbsp;|&nbsp;
                                        <span data-check="none" data-type="perms" class="perm-check check-none"
                                              style="color: red;"><i class="fa fa-square-o"></i> None</span>
                                    </div>
                                    <div class="col-md-4">
                                        <h4>Account</h4>
                                        <div class="col-md-12">
                                            <label>
                                                <input class="perm-type" type="checkbox" name="parms[]" value="14">
                                                Create
                                            </label>
                                        </div>
                                        <div class="col-md-12">
                                            <label>
                                                <input class="perm-type" type="checkbox" name="parms[]" value="15">
                                                Modify
                                            </label>
                                        </div>
                                        <div class="col-md-12">
                                            <label>
                                                <input class="perm-type" type="checkbox" name="parms[]" value="16"> View
                                            </label>
                                        </div>
                                        <div class="col-md-12">
                                            <label>
                                                <input class="perm-type" type="checkbox" name="parms[]" value="17">
                                                Delete
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h4>Field Activity</h4>
                                        <div class="col-md-12">
                                            <label>
                                                <input class="perm-type" type="checkbox" name="parms[]" value="20">
                                                Create
                                            </label>
                                        </div>
                                        <div class="col-md-12">
                                            <label>
                                                <input class="perm-type" type="checkbox" name="parms[]" value="21">
                                                Modify
                                            </label>
                                        </div>
                                        <div class="col-md-12">
                                            <label>
                                                <input class="perm-type" type="checkbox" name="parms[]" value="22"> View
                                            </label>
                                        </div>
                                        <div class="col-md-12">
                                            <label>
                                                <input class="perm-type" type="checkbox" name="parms[]" value="23">
                                                Delete
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h4>Inventory</h4>
                                        <div class="col-md-12">
                                            <label>
                                                <input class="perm-type" type="checkbox" name="parms[]" value="25">
                                                Create
                                            </label>
                                        </div>
                                        <div class="col-md-12">
                                            <label>
                                                <input class="perm-type" type="checkbox" name="parms[]" value="26">
                                                Modify
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
                                                <input class="perm-type" type="checkbox" name="parms[]" value="30">
                                                Modify
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
                                                <input class="perm-type" type="checkbox" name="parms[]" value="27">
                                                Admin
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div id="user-edit-exit" class="btn btn-danger alert-danger">Cancel</div>
                                <div id="user-do-edit" class="btn btn-success alert-success"><i class="fa fa-check"></i>
                                    Save
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="invis col-md-12" id="delete-user-form">
                        <div class="col-mid-12">
                            <h2><i class="fa fa-exclamation-triangle warning-sign"></i> Are you sure?</h2>
                            <h4>Delete User: <span id="delete-name"></span></h4>
                            <h4>User Name: <label id="delete-email"></label></h4>
                        </div>
                        <div class="col-md-12">
                            <div id="user-delete-working" class="invis"><h4>Working... <i class="fa fa-spinner fa-spin"></i></h4></div>
                            <div id="user-delete-success" class="invis"><h4>User Deleted!</h4></div>
                            <div id="user-delete-fail" class="invis"><h4>Error: Please try again shortly!</h4></div>
                        </div>
                        <div class="col-md-12">
                            <div id="delete-user-go" class="btn btn-warning alert-warning"><i class="fa fa-remove"></i>
                                Delete User
                            </div>
                            <div id="delete-user-exit" class="btn btn-danger alert-danger">
                                Cancel
                            </div>
                        </div>

                    </div>


                    <div class="invis col-md-12" id="office-view">

                        <h3>Users</h3>
                        <div class="row" id="office-box">

                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div id="user_new_form" class="invis">
            @include('partials.users.add-user')
        </div>

        <div id="user_levels" class="invis">
            <div class="row">
                <div class="col-md-12">
                    <h4>User Levels</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @foreach($userLevels as $ul)
                        <div class="col-md-12">{{ $ul->level_name }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12 top-mar">
        <div id="user_new" class="btn btn-default btn-sub-menu1">
            <a>
                <div class="fa fa-stack" style="color: green; left: 193px ;position: absolute; top: -1px;">
                    <i class="fa fa-circle-o fa-stack-2x"></i>
                    <i class="fa fa-plus fa-stack-1x"></i>
                </div>
                Add User</a>
        </div>
    </div>
</div>