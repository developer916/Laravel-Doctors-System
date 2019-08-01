<div class="input-group">
    <input id="act_search" type="text" class="form-control act-search" placeholder="Search by Account Number or Company Name">
    <span class="input-group-btn">
        <a id='account-submit-btn' href='/account' class="btn btn-primary act-btn" type="button">View</a>
    </span>
    <div style="position:relative" id="autoDisplay" class="autoDisplay"></div>
</div><!-- /input-group -->
<div id="tooltipFade" class="tooltip bottom tooltipFade" role="tooltip">
    <div class="tooltip-arrow"></div>
    <div id="auto_display" class="tooltip-inner auto_display"></div>
</div>
<div class="row">
    {{--<div class="_flex _flex_space-between">--}}
    <div class="col-md-5">
        @if(isset($me['19']) && $me['19'] )
            <ul class="btn-list">
                <li>
                    <h4>Reports</h4>
                </li>
                <li>
                    <div class="btn btn-primary btn-sub-menu">
                        <a href="#" id="account-field">Field Activity</a>
                    </div>
                </li>
                <li>
                    <div class="btn btn-primary btn-sub-menu">
                        <a target="_blank" href="#" id="account-material">Materials Usage</a>
                    </div>
                </li>
                <li>
                    <div id="act_exp" class="btn btn-primary btn-sub-menu">Account Expiration</div>
                </li>
                <li>
                    <div id="act_car" class="btn btn-primary btn-sub-menu">Customer Activity</div>
                </li>
                <li>
                    <div id="act_cnc" class="btn btn-primary btn-sub-menu">Cancel and Complete</div>
                </li>
                <li>
                    <div id="act_bio" class="btn btn-primary btn-sub-menu">Treatment / Biologist</div>
                </li>
                <li>
                    <div class="btn btn-primary btn-sub-menu">
                        <a target="_blank" href="#" id="account-cpr">Customer Profile</a>
                    </div>
                </li>
                <li>
                    <div id="act_co" class="btn btn-primary btn-sub-menu">Care Of</div>
                </li>
                <li>
                    <div id="act_ref" class="btn btn-primary btn-sub-menu">Account Reference List</div>
                </li>
            </ul>
        @endif
    </div>
    <div class="no-left-padding col-md-7">
        <div class="act_status">
            <h4>Account Statistics</h4>
            <ul class="btn-list">
                <li><strong>Total Accounts:</strong> {{ $actCount }}</li>
                <li><strong>Total Active:</strong> {{ $actActive }}</li>
                <li><strong>Total Inactive</strong> {{ $actInactive }}</li>
            </ul>
        </div>
        <div class="act_preview">
            <h4>Preview</h4>
            <ul>
                <li id="act_number"><span style='margin-right:10px'><i class="status-ok fa fa-check-circle"></i></span>
                    <span class="data-head">Account #: </span><span class="preview-data"></span>
                </li>
                <li id="act_name"><span style='margin-right:10px'><i class="status-ok fa fa-check-circle"></i></span>
                    <span class="data-head">Name: </span>
                    <span class="preview-data"></span>
                </li>
                <li id="act_status">
                    <span id="act_preview_inactive" style='margin-right:10px'><i class="status-bad fa fa-remove"></i></span>
                    <span id="act_preview_active" style='margin-right:10px'><i class="status-ok fa fa-check-circle"></i></span>
                    <span class="data-head">Status: </span><span class="preview-data"></span>
                </li>
                <li id="act_last_serve"><span style='margin-right:10px'>
                    <i class="status-ok fa fa-check-circle"></i></span><span class="data-head">Last Service: </span>
                    <span class="preview-data"></span>
                </li>
                <li id="act_co"><span style='margin-right:10px'>
                    <i class="status-ok fa fa-check-circle"></i></span><span class="data-head">Care Of: </span>
                    <span class="preview-data"></span>
                </li>
                <li id="act_address"><span style='margin-right:10px'>
                    <i class="status-ok fa fa-check-circle"></i></span><span class="data-head">Address: </span>
                    <span class="preview-data"></span>
                </li>
                <li id="act_city"><span style='margin-right:10px'>
                    <i class="status-ok fa fa-check-circle"></i></span><span class="data-head">City: </span>
                    <span class="preview-data"></span>
                </li>
                <li id="act_state"><span style='margin-right:10px'>
                    <i class="status-ok fa fa-check-circle"></i></span><span class="data-head">State: </span>
                    <span class="preview-data"></span>
                </li>
                <li id="act_zip"><span style='margin-right:10px'>
                    <i class="status-ok fa fa-check-circle"></i></span><span class="data-head">Zip: </span>
                    <span class="preview-data"></span>
                </li>
                <li id="act_contact"><span style='margin-right:10px'>
                    <i class="status-ok fa fa-check-circle"></i></span><span class="data-head">Contact: </span>
                    <span class="preview-data"></span>
                </li>
                <li id="act_email"><span style='margin-right:10px'>
                    <i class="status-ok fa fa-check-circle"></i></span><span class="data-head">Email: </span>
                    <span class="preview-data"></span>
                </li>
                <li id="act_phone"><span style='margin-right:10px'>
                    <i class="status-ok fa fa-check-circle"></i></span><span class="data-head">Phone: </span>
                    <span class="preview-data"></span>
                </li>
            </ul>
        </div>
        <div class="act_car">
            @include('partials.reports.pop-up-car')
        </div>
        <div class="act_exp">
            @include('partials.reports.pop-up-exp')
        </div>
        <div class="act_co">
            <h4>Care Of Report</h4>
            <form target="_blank" id="act_co_report" role="form" method="post" action="{{ route('act_co') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="col-md-12 margin-b-5">
                    <select id="office_id" name="office_id" class="form-control resetSelect" id="office">
                        <option value="default" selected>Select office</option>
                        <option value="default">All offices</option>
                        @foreach($offices as $off)
                            <option value="{{ $off->id }}">{{ $off->abvr }} &mdash; {{ $off->officeName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 margin-b-5">
                    <button class="btn btn-success alert-success" id="run_co_report" type="submit">Run Report</button>
                    <button class="btn btn-danger alert-danger" id="cancel_co_report" type="button">Cancel</button>
                </div>
            </form>
        </div>
        <div class="act_cnc invis">
            <h4>Cancel and Complete Report</h4>
            <form target="_blank" id="act_co_report" role="form" method="post" action="{{ route('act_cnc') }}">
                <div class="col-md-12 margin-b-5">
                    <input id="status_start" type="text" name="statusStart" class="form-control resetInput" placeholder="Begin Status Date"
                           value="">
                </div>
                <div class="col-md-12 margin-b-5">
                    <input id="status_end" type="text" name="statusEnd" class="form-control resetInput"
                           placeholder="End Status Date" value="">
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="col-md-12 margin-b-5">
                    <select id="id" name="id" class="form-control resetSelect" id="office">
                        <option value="default" selected>Select office</option>
                        <option value="all" selected>All offices</option>
                        @foreach($offices as $off)
                            <option value="{{ $off->id }}">{{ $off->abvr }} &mdash; {{ $off->officeName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 margin-b-5">
                    <button class="btn btn-success alert-success" id="run_cnc_report" type="submit">Run Report</button>
                    <button class="btn btn-danger alert-danger" id="cancel_cnc_report" type="button">Cancel</button>
                </div>
            </form>
        </div>
        <div class="act_bio invis">
            <h4>Treatment / Biologist Report</h4>
            <form target="_blank" id="act_bio_report" role="form" method="post" action="{{ route('act_bio') }}">
                <div class="col-md-12 margin-b-5">
                    <input id="account_bio" type="text" name="actId" class="form-control resetInput" placeholder="Account Number"
                           value="">
                </div>
                <div class="col-md-12 margin-b-5">
                    <select id="id" name="id" class="form-control resetSelect" id="office">
                        <option value="default" selected>Select office</option>
                        @foreach($offices as $off)
                            <option value="{{ $off->id }}">{{ $off->abvr }} &mdash; {{ $off->officeName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 margin-b-5">
                    <select id="tech" name="tech" class="form-control resetSelect" id="tech">
                        <option value="default" selected>Select salesman</option>
                        @foreach($salesman as $sales)
                            <option value="{{ $sales->id }}">{{ $sales->code }} &mdash; {{ $sales->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 margin-b-5">
                    <input id="status_start" type="text" name="statusStart" class="form-control resetInput" placeholder="Begin Status Date"
                           value="">
                </div>
                <div class="col-md-12 margin-b-5">
                    <input id="status_end" type="text" name="statusEnd" class="form-control resetInput"
                           placeholder="End Status Date" value="">
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="col-md-12 margin-b-5 ">
                    <button class="btn btn-success alert-success" id="run_bio_report" type="submit">Run Report</button>
                    <button class="btn btn-danger alert-danger" id="cancel_bio_report" type="button">Cancel</button>
                </div>
            </form>
        </div>
        <div class="act_ref">
            @include('partials.reports.pop-up-ref')
        </div>
    </div>
</div>

@if(isset($me['14']) && $me['14'] )
    <div class="row">
        <div class="col-md-12">
            <div class="btn btn-default btn-sub-menu">
                <a href="/account/add">
                    <div class="fa fa-stack" style="color: green; left: 193px ;position: absolute; top: -1px;">
                        <i class="fa fa-circle-o fa-stack-2x"></i>
                        <i class="fa fa-plus fa-stack-1x"></i>
                    </div>
                    Add Account</a>
            </div>
        </div>
    </div>
@endif