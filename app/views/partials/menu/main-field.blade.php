<div id="fieldMenu">
    <div class="input-group">
        <input id="act_search_field" type="text" class="form-control act-search"
               placeholder="Search by Account Number or Company Name">

                                    <span class="input-group-btn">
                                        <a id='field-submit-btn' href='/account/report/field'
                                           class="btn btn-primary act-btn" type="button">View</a>
                                    </span>
        <div style="position: relative" id="autoDisplay1" class="autoDisplay"></div>


    </div><!-- /input-group -->
    <div id="tooltipFadeField" class="tooltip bottom tooltipFade" role="tooltip">
        <div class="tooltip-arrow"></div>
        <div id="auto_display_Field" class="tooltip-inner auto_display">

        </div>
    </div>
    <div class="_flex _flex_space-between">
        <div>
            <ul class="btn-list">
                <li>
                    <h4>Reports</h4>
                </li>

                <li>
                    <div class="btn btn-primary btn-sub-menu">
                        <a href="#" id="field-material">Materials / Herbicide Usage</a>
                    </div>
                </li>


            </ul>
        </div>

        {{--<div class="act_preview1">--}}
        {{--<h4>Preview</h4>--}}
        {{--<ul>--}}
        {{--<li id="act_number"><span style='color:green; margin-right: 10px;'><i class="fa fa-check-circle"></i></span><span class="data-head">Account #: </span><span class="preview-data"></span></li>--}}
        {{--<li id="act_name"><span style='color:green; margin-right: 10px;'><i class="fa fa-check-circle"></i></span><span class="data-head">Name: </span><span class="preview-data"></span></li>--}}
        {{--<li id="act_status"><span style='color:green; margin-right: 10px;'><i class="fa fa-check-circle"></i></span><span class="data-head">Status: </span><span class="preview-data"></span></li>--}}
        {{--<li id="act_last_serve"><span style='color:green; margin-right: 10px;'><i class="fa fa-check-circle"></i></span><span class="data-head">Last Service: </span><span class="preview-data"></span></li>--}}
        {{--<li id="act_address"><span style='color:green; margin-right: 10px;'><i class="fa fa-check-circle"></i></span><span class="data-head">Address: </span><span class="preview-data"></span></li>--}}
        {{--<li id="act_city"><span style='color:green; margin-right: 10px;'><i class="fa fa-check-circle"></i></span><span class="data-head">City: </span><span class="preview-data"></span></li>--}}
        {{--<li id="act_state"><span style='color:green; margin-right: 10px;'><i class="fa fa-check-circle"></i></span><span class="data-head">State: </span><span class="preview-data"></span></li>--}}
        {{--<li id="act_zip"><span style='color:green; margin-right: 10px;'><i class="fa fa-check-circle"></i></span><span class="data-head">Zip: </span><span class="preview-data"></span></li>--}}
        {{--<li id="act_contact"><span style='color:green; margin-right: 10px;'><i class="fa fa-check-circle"></i></span><span class="data-head">Contact: </span><span class="preview-data"></span></li>--}}
        {{--<li id="act_email"><span style='color:green; margin-right: 10px;'><i class="fa fa-check-circle"></i></span><span class="data-head">Email: </span><span class="preview-data"></span></li>--}}
        {{--<li id="act_phone"><span style='color:green; margin-right: 10px;'><i class="fa fa-check-circle"></i></span><span class="data-head">Phone: </span><span class="preview-data"></span></li>--}}
        {{--</ul>--}}
        {{--</div>--}}
        
    </div>

    <div class="row">
        <div class="col-md-12">
            <div id="f_a_add_field_activity" class="btn btn-default btn-sub-menu">
                <div class="fa fa-stack" style="color: green; left: 193px ;position: absolute; top: -1px;">
                    <i class="fa fa-circle-o fa-stack-2x"></i>
                    <i class="fa fa-plus fa-stack-1x"></i>
                </div>
                Add New Field Activity
            </div>
        </div>
    </div>
</div>
<div id="fieldWork" class="row">
    <div id="fieldPreview" class="invis"></div>


    <div id="fieldActivity" class="invis col-md-12">
        @include('partials.field.field-activity')
    </div>


</div>