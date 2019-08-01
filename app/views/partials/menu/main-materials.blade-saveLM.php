<div class="input-group">
    <input id="mat-auto-lookup" type="text" class="form-control act-search disabled" placeholder="Search by Account Number or Company Name">
        <span class="input-group-btn">
            <a id='mat-edit-btn' class="btn btn-primary act-btn" type="button">Edit</a>
        </span>
    <div style="position: relative" id="autoDisplay"></div>


</div><!-- /input-group -->
<div id="mat-auto-tooltip" class="tooltip bottom" role="tooltip">
    <div class="tooltip-arrow"></div>
    <div id="mat-display" class="tooltip-inner auto_display">

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
                    <a href="#" id="invantory-report">Inventory</a>
                </div>
            </li>--}}
            <li>
                <div class="btn btn-primary btn-sub-menu">
                    <a target="_blank" href="#" id="materials-material">Materials & Herbicides Usage</a>
                </div>
            </li>
            <li>
                <div class="btn btn-primary btn-sub-menu"><a href="/account/material/ref" target="_blank">Materials Reference List</a></div>
            </li>

            <li>
                <div class="btn btn-primary btn-sub-menu"><a href="/account/report/materialCost" target="_blank">Materials Cost Chart</a> </div>
            </li>
            <li>
                <div class="btn btn-primary btn-sub-menu disabled"><a href="/account/report/materialCost" target="_blank">Fountains & Aerators</a> </div>
            </li>

        </ul>
    </div>


</div>

</div>
<div class="col-md-6">
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

    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div id="newInven" data-context="new_inv" class="btn btn-default btn-sub-menu">
            <div class="fa fa-stack" style="color: green; left: 193px ;position: absolute; top: -1px;" >
                <i class="fa fa-circle-o fa-stack-2x"></i>
                <i class="fa fa-plus fa-stack-1x"></i>
            </div>
            Add New Inventory
        </div>
    </div>
</div>

<div class="row">
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
    <div class="col-md-12">
        <div class="btn btn-default btn-sub-menu  disabled">
            <div class="fa fa-stack" style="color: green; left: 193px ;position: absolute; top: -1px;" >
                <i class="fa fa-circle-o fa-stack-2x"></i>
                <i class="fa fa-plus fa-stack-1x"></i>
            </div>
            Add New Fountain
        </div>
    </div>
</div>