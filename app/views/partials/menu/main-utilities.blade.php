<div class="row">
    <div id="utilityMenu">
        <div id="menuList" class="col-md-5 util-normal">
            <div>
                <ul class="btn-list">
                    <li>
                        <h4>Update Website</h4>
                    </li>
                    <li>
                        <div id="utility_salesmen" data-context="salesmenTab" class="btn btn-primary btn-sub-menu">
                            <a>Manage Salesmen</a>
                        </div>
                    </li>
                    <li>
                        <div id="tax_disctricts" data-context="edit-tax-districts" class="btn btn-primary btn-sub-menu">
                            <a>Tax Districts</a>
                        </div>
                    </li>
                    <li>
                        <h4>Purge and Backup</h4>
                    </li>
                    <li>
                        <div id="purge_status" data-context="purge-status" class="btn btn-primary btn-sub-menu"><a>Purge
                                by Status</a></div>
                    </li>
                    <li>
                        <div id="purge_date" data-context="purge-date" class="btn btn-primary btn-sub-menu"><a>Purge by
                                Date</a></div>
                    </li>
                    <li>
                        <div id="global_exp" data-context="global-exp" class="btn btn-primary btn-sub-menu">Global
                            Expiration
                        </div>
                    </li>
                    {{--<li>--}}
                    {{--<div class="btn btn-primary btn-sub-menu">Customer Profile</div>--}}
                    {{--</li>--}}

                </ul>
            </div>

        </div>
        <div class="col-md-12 util-normal">
            <div id="previewTab" class="col-md-12 no-left-padding"></div>
            <div id="edit-tax-districts" class="col-md-12 invis no-left-padding">
                @include('partials.utilities.edit-tax-districts')
            </div>
            <div id="salesmenTab" class="invis col-md-12 no-left-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div id="salesman-shadow">
                            <span><i class="fa fa-spin fa-spinner fa-2x"></i> Processing Request</span>
                        </div>
                        <h4>Add/Remove Salesmen</h4>
                        <div id="remove-salesman" class="col-md-10">
                            <ul id="util-salesmen-list" class="list-unstyled">

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 25px;">
                    <div id="add-salesman-view" class="col-md-12 invis">
                        <form class="form-inline">
                            <div class="form-group">
                                <input type="text" class="form-control" name="abvr" id="salesman-abvr"
                                       placeholder="Abvr">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" id="salesman-name"
                                       placeholder="Salesman Name">
                            </div>
                            <div class="form-group">
                                <span id="add-salesman-add" class="btn btn-success"><i
                                            class="fa fa-check"></i> Add</span>
                                <span id="add-salesman-cancel" class="btn btn-danger"><i class="fa fa-remove"></i> Cancel</span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row" style="margin-top: 25px;">
                    <div class="col-md-8">
                        <div id="add-salesman" class="btn btn-default btn-sub-menu">
                            <a>
                                <div class="fa fa-stack"
                                     style="color: green; left: 193px ;position: absolute; top: -1px;">
                                    <i class="fa fa-circle-o fa-stack-2x"></i>
                                    <i class="fa fa-plus fa-stack-1x"></i>
                                </div>
                                Add Salesman</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div id="utility-back" class="btn btn-primary">
                            <i class="fa fa-arrow-left"></i>
                            Back
                        </div>
                    </div>
                </div>
            </div>
            <div id="purge-status" class="col-md-12 invis no-left-padding">
                <h4>Purge Account by Status</h4>
                <p>This will delete any "C" status accounts expiring <strong><i>before</i></strong> the date below.
                    (Data will still be recoverable up to X years)</p>
                <div class="col-md-12 margin-b-5">
                    <input id="purge_service_status" type="text" name="purge-service-status"
                           class="form-control resetInput utilityFormClear"
                           placeholder="Purge data older than mm/dd/yyyy" value="">
                </div>
                <div id="purge_status_preview" class="col-md-12 invis utilityHides">
                    <h4>Purge Info</h4>
                    <label>We found <strong id="purge_status_count"></strong> data items to purge</label>
                </div>
                <div id="purge_tatus_reject" class="col-md-12 invis utilityHides">
                    <h4>No data found</h4>
                    <p>Please try another status</p>
                </div>
                <div class="purge-status-processing blue invis purge-errors">
                    <span><i class="fa fa-spin fa-spinner fa-2x"></i> Processing Purge</span>
                </div>
                <div class="purge-status-fetching blue invis purge-errors">
                    <span><i class="fa fa-spin fa-spinner fa-2x"></i> Fetching Information</span>
                </div>
                <div id="purge_status_complete" class=" green invis purge-errors">
                    <span><i class="fa fa-check"></i> Purge Complete</span>
                </div>
                <div id="purge_status_bad" class="red invis purge-errors">
                    <span><i class="fa fa-remove"></i> Purge Failed</span>
                </div>

                <div id="purge_status_ctrls" class="col-md-12 margin-b-5 margin-t-10 invis">
                    <button class="btn btn-success alert-success" id="run_purge_status" type="submit">Run Purge</button>
                    <button class="btn btn-danger alert-danger" id="cancel_purge_status" type="button">Cancel</button>
                </div>
                <div class="col-md-12">
                    <div id="purge-status-back" class="btn btn-primary alert-primary showMeLater">
                        <i class="fa fa-arrow-left"></i> Back
                    </div>
                </div>
            </div>
            <div id="purge-date" class="col-md-12 invis no-left-padding">
                <h4>Purge Field Data by date</h4>
                <p>This will delete any field services and data <strong><i>before</i></strong> the date below. (Data
                    will still be recoverable up to X years)</p>
                <div class="col-md-12 margin-b-5">
                    <input id="purge_service_date" type="text" name="purge-service-date"
                           class="form-control resetInput utilityFormClear"
                           placeholder="Purge data older than mm/dd/yyyy" value="">
                </div>
                <div id="purge_preview" class="col-md-12 invis utilityHides">
                    <h4>Purge Info</h4>
                    <label>We found <strong id="purge_count"></strong> data items to purge</label>
                </div>
                <div id="purge_reject" class="col-md-12 invis utilityHides">
                    <h4>No data found</h4>
                    <p>Please try another date</p>
                </div>
                <div class="purge-date-processing blue invis purge-errors">
                    <span><i class="fa fa-spin fa-spinner fa-2x"></i> Processing Purge</span>
                </div>
                <div class="purge-date-fetching blue invis purge-errors">
                    <span><i class="fa fa-spin fa-spinner fa-2x"></i> Fetching Information</span>
                </div>
                <div id="purge_complete" class=" green invis purge-errors">
                    <span><i class="fa fa-check"></i> Purge Complete</span>
                </div>
                <div id="purge_bad" class="red invis purge-errors">
                    <span><i class="fa fa-remove"></i> Purge Failed</span>
                </div>

                <div id="purge_ctrls" class="col-md-12 margin-b-5 margin-t-10 invis">
                    <button class="btn btn-success alert-success" id="run_purge_date" type="submit">Run Purge</button>
                    <button class="btn btn-danger alert-danger" id="cancel_purge_date" type="button">Cancel</button>
                </div>
                <div class="col-md-12">
                    <div id="purge-date-back" class="btn btn-primary alert-primary showMeLater">
                        <i class="fa fa-arrow-left"></i> Back
                    </div>
                </div>
            </div>
            <div id="global-exp" class="col-md-12 invis no-left-padding">
                <div id="global-exp-form-group">
                    <h4>Global Expiration by Date</h4>
                    <div class="col-md-12 margin-b-5">
                        <input id="global_exp_date" type="text" name="global_exp_date" class="form-control resetInput"
                               placeholder="Expiration Date mm/dd/yyyy" value="">
                    </div>
                    <div class=" col-md-12 global-exp-date red invis purge-errors" style="margin:2% 0">
                        <span><i class="fa fa-remove"></i> Oops! You forgot the date.</span>
                    </div>
                    <div class="col-md-12 margin-b-5">
                        <select id="global_exp_office" name="global_exp_office" class="form-control resetSelect" class="office">
                            <option value="default" selected>Select office</option>
                            @foreach($offices as $off)
                                <option value="{{ $off->id }}">{{ $off->abvr }} &mdash; {{ $off->officeName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 margin-b-5">
                        <select id="global_exp_salesman" name="global_exp_salesman" class="form-control resetSelect" class="salesman">
                            <option value="default" selected>Select salesman</option>
                            @foreach($salesman as $sales)
                                <option value="{{ $sales->id }}">{{ $sales->abvr }} &mdash; {{ $sales->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="global-date-range col-md-12" style="padding-left: 12px; padding-right: 0">
                        <button class="btn btn-info alert-info" id="global_exp_last_month" type="submit">Last Month
                        </button>
                        <button class="btn btn-info alert-info" id="global_exp_this_month" type="submit">This Month
                        </button>
                        <button class="btn btn-info alert-info" id="global_exp_next_month" type="submit">Next Month
                        </button>
                    </div>

                    <div id="global_exp_ctrls" class="col-md-12 margin-b-5 margin-t-10">
                        <button class="btn btn-success alert-success disabled" id="global_exp_lookup" type="button">List
                            Accounts
                        </button>
                        <button class="btn btn-danger alert-danger" id="cancel_global_exp" type="button">Cancel</button>
                    </div>
                    <div id="global_exp_reject" class="col-md-12 utilityHides invis">
                        <h4>No data found</h4>
                        <p>Please try another date</p>
                    </div>
                    <div class="global-exp-processing blue invis purge-errors">
                        <span><i class="fa fa-spin fa-spinner fa-2x"></i> Processing Request</span>
                    </div>
                    <div class="global-exp-fetching blue invis purge-errors">
                        <span><i class="fa fa-spin fa-spinner fa-2x"></i> Fetching Information</span>
                    </div>
                    <br>
                    <div class="col-md-12" style="margin-top: 15px;">
                        <div id="global-exp-back" class="btn btn-primary alert-primary showMeLater">
                            <i class="fa fa-arrow-left"></i> Back
                        </div>
                    </div>
                </div>
                <div id="global-exp-show-group" class="invis">
                    <div id="global_exp_preview" class="col-md-12" style="overflow: auto; max-height: 650px; min-height:350px;">
                        <h4>Global expiration by date change</h4>
                        <label>Expiration Date <strong id="global_show_date"></strong> </label><br>
                        <label>We found <strong id="global_show_amount"></strong> accounts that will expire on your
                            date.</label>
                        <form class="form-inline">
                            <div class="col-md-12">
                                <div class="col-md-12 pull-right">
                                    <div class="radio pull-right">
                                        <label class="radio-inline">
                                            <input type="radio" name="global-exp-radio-sort" id="global-exp-raio-sort1" value="salesman">
                                            Salesmen
                                        </label>
                                    </div>
                                    <div class="radio pull-right" style="margin-right:7px">
                                        <label class="radio-inline">
                                            <input type="radio" name="global-exp-radio-sort" id="global-exp-raio-sort2" value="account"
                                                   checked>
                                            Account #
                                        </label>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </form>
                        <table class="table table-fixed">
                            <thead>
                                <tr>
                                    <th style="width:8%">Acct #</th>
                                    <th style="width:14%">Account Name</th>
                                    <th style="width:12%">Begin</th>
                                    <th style="width:12%">Expiration</th>
                                    <th style="width:12%">Annual</th>
                                    <th style="width:11%">Billing</th>
                                    <th style="width:8%">Budget</th>
                                    <th style="width:8%">Salesman</th>
                                    <th style="width:6%">Office</th>
                                    <th style="width:7%">NC</th>
                                </tr>
                            </thead>
                            <tbody id="global-table-body"></tbody>
                        </table>
                        <br>
                        <form target="_blank" id="car-report" role="form" method="post" action="{{ route('pall') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" id="attachments" name="attachments">
                        Report Type: <select id="type" name="type">
                                        <option value="">Type --</option>
                                        <option value="full" selected="">Full Customer Profile</option>
                                        <option value="budget">Budget Customer Profile</option>
                                        <option value="both">Full+Budget Customer Profile</option>
                                        <option value="spreadsheet">Spreadsheet List</option>
                                     </select> &nbsp;&nbsp;&nbsp;  
                        <input type="text" placeholder="email@email.com" name="email">&nbsp;&nbsp;&nbsp;
                        <a onclick="$('#loading').css('display', 'block'); $('#export').attr('value', 1); $('#fieldform').submit()" class="btn btn-primary"><span>Export to Email</span></a>    &nbsp;&nbsp;&nbsp;
                            <button class="btn btn-primary" id="run_cpr" type="submit">Print All</button>
                        </form>
                        <br>
                        <br>
                        <center><span id="loading" style="display:none"><i class="fa fa-spin fa-spinner fa-1x"></i> This may take a few moments...</span></center>
                        <br>
                        <br>
                    </div>
                    <br>
                    <div class="global-exp-processing blue invis purge-errors">
                        <span><i class="fa fa-spin fa-spinner fa-2x"></i> Processing Request</span>
                    </div>
                    <div class="global-exp-complete green invis purge-errors">
                        <span><i class="fa fa-check"></i> Update Complete</span>
                    </div>
                    <div class="global-exp-bad red invis purge-errors">
                        <span><i class="fa fa-remove"></i> Update Failed</span>
                    </div>
                    <div class="col-md-12">
                        <div id="global-exp-show-back" class="btn btn-primary alert-primary">
                            <i class="fa fa-arrow-left"></i> Back to Form
                        </div>
                        <div id="global-exp-save" class="btn btn-success alert-success pull-right">
                            <i class="fa fa-check"></i> Save
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 util-extend"></div>
    </div>
</div>