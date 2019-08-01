@if( Auth::user()->level == \App\UserLevel::ADMIN_LEVEL_ID ||
     Auth::user()->level == \App\UserLevel::AFRW_LEVEL_ID ||
     Auth::user()->is_super_admin)
    <div class="form-group col-md-5">
        <select name="offices-select" class="form-control">
            <option value="">All offices --</option>
            @foreach($offices as $office)
                <option value="{{ $office->id }}">{{ $office->officeName }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-5">
        <select name="months-select" class="form-control">
            <option value="">No inventories found</option>
        </select>
    </div>

    <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">

    <a class="btn btn-primary edit-inventory" type="button">Edit</a>

    <hr>
@endif

<div class="clearfix"></div>

<div class="input-group">
    <input id="mat-auto-lookup" type="text" class="form-control act-search disabled" placeholder="Search by Material Name">
        <span class="input-group-btn">
            <a id='mat-edit-btn' class="btn btn-primary act-btn" type="button">Edit</a>
        </span>
    <div style="position: relative" id="autoDisplay"></div>


</div><!-- /input-group -->
<div id="mat-auto-tooltip" class="tooltip bottom tooltipFade" role="tooltip">
    <div class="tooltip-arrow"></div>
    <div id="mat-display" class="tooltip-inner auto_display" style="overflow-y: scroll;">

    </div>
</div>
<div class="col-md-6">
<div class="_flex _flex_space-between">
    <div>
        <ul class="btn-list">
            <li>
                <h4>Reports</h4>
            </li>
            {{--<li>
                <div class="btn btn-primary btn-sub-menu">
                    <a target="_blank" href="#" id="invantory-report">Inventory</a>
                </div>
            </li>--}}
            <li> 
                <div class="btn btn-primary btn-sub-menu" id="invReport" data-context="inv_rep">
                    Inventory Report     </div>
            </li>
            <li>
                <div class="btn btn-primary btn-sub-menu"><a href="/account/material/ref" target="_blank">Materials Reference List</a></div>
            </li>

            <li>
                <div class="btn btn-primary btn-sub-menu"><a href="/account/report/materialCost" target="_blank">Materials Cost Chart</a> </div>
            </li>

        </ul>
    </div>


</div>


    <div class="col-md-12">
        <div id="newInven" data-context="new_inv" class="btn btn-default btn-sub-menu">
            <div class="fa fa-stack" style="color: green; left: 193px ;position: absolute; top: -1px;" >
                <i class="fa fa-circle-o fa-stack-2x"></i>
                <i class="fa fa-plus fa-stack-1x"></i>
            </div>
            Add New Inventory
        </div>
    </div>

    <div class="col-md-12">
        <div id="newMat"  data-context="new_mat" class="btn btn-default btn-sub-menu">
            <div class="fa fa-stack" style="color: green; left: 193px ;position: absolute; top: -1px;" >
                <i class="fa fa-circle-o fa-stack-2x"></i>
                <i class="fa fa-plus fa-stack-1x"></i>
            </div>
            Add New Material
        </div>
    </div>


</div>
<div class="row">

 
<div class="col-md-6">

  <div class="col-md-12">
    <div id="inv_showcase">
        <div id="inv_prev" class="">
            @include('partials.inventory.preview-material')
        </div>
        <div id="new_inv" class="invis">
            @include('partials.inventory.add_inventory')
        </div>
        <div id="new_mat" class="invis">
            @include('partials.inventory.add-material')
        </div>
        <div id="new_edit" class="invis">
            @include('partials.inventory.edit-material')
        </div>

        <div id="inv_rep" class="invis">
            @include('partials.reports.pop-up-inventory')
        </div>
    </div>
</div>
</div>
</div>
