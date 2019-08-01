<div class="row">
    <div class="col-md-4">
        <ul class="btn-list">
            <li>
                <h4>Reports</h4>
            </li>

            <li>
                <div class="btn btn-primary ">
                    <a href="/technicians" id="account-field">Technician Management</a>
                </div>
            </li>


        </ul>
    </div>
    <div class="col-md-8">
    <div id="tech-preview-panel" class="tech_preview tech-panel">
        <h4>Preview</h4>
        <ul>
            <li id="act_name"><span style='color:green; margin-right: 10px;'>
                    <i class="fa fa-check-circle"></i></span>
                <span class="data-head">Active:</span><span
                        class="preview-data">{{ $active }}</span></li>
            <li id="act_status"><span style='color:green; margin-right: 10px;'><i class="fa fa-check-circle"></i></span><span
                        class="data-head">InActive: </span><span class="preview-data">{{ $inactive }}</span></li>
            <li id="act_last_serve"><span style='color:green; margin-right: 10px;'><i
                            class="fa fa-check-circle"></i></span><span
                        class="data-head">Total Hours for {{ date('M') }}: </span><span
                        class="preview-data">{{ number_format($monthHours, 2) }}</span></li>
            <li id="act_address">
                <span style='color:green; margin-right: 10px;'>
                    <i class="fa fa-check-circle"></i>
                </span>
                <span class="data-head">Total Man Hours: </span>
                <span
                        class="preview-data">{{ number_format($totalHours, 2) }}</span>
            </li>

        </ul>
    </div>
    <div id="tech-add-panel" class="tech_add invis tech-panel">
        @include('partials.tech.tech-add')
    </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="tech-add-btn" class="btn btn-default btn-sub-menu">
            <div class="fa fa-stack" style="color: green; left: 193px ;position: absolute; top: -1px;">
                <i class="fa fa-circle-o fa-stack-2x"></i>
                <i class="fa fa-plus fa-stack-1x"></i>
            </div>
            Add Technician
        </div>
    </div>
</div>