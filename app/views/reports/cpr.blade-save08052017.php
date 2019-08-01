@extends('reports.blank')

@section('content')
    <div class="container cpr-body">
        <div class="row hidden-print">
            <div class="pull-right" style="margin-top:10px">
                <a onclick="window.print()"><i class="fa fa-print"></i> Print Report</a>
            </div>
            <div class="pull-right" style="margin-top: 4px; margin-right:20px;">
                <label for="">
                    <input type="radio" style="position: relative;top:2px;" name="reportType" id="full" checked>&nbsp; Full
                </label>
                <label for="">
                    <input type="radio" style="position: relative;top:2px;" name="reportType" id="budget">&nbsp; Budget
                </label>
            </div>
        </div>
        <div class="row cpr-head">
            <hr class="page-hr"/>
            <h2><strong>Customer Profile Report</strong></h2>
        </div>
        <div class="row">
            <div class="col-xs-3 col-md-4"><h4><strong>Account Number: {{ $act->accountNumber}}</strong></h4></div>
            <div class="col-xs-8 col-md-8"><h4><strong>Account Name: {{ strtoupper($act->actName) }}</strong></h4>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3 col-md-6">Office ID/Terr:
                <strong>{{ strtoupper($act->office->officeName->abvr) }}</strong>
            </div>
            <div class="col-xs-4 col-md-6">Care of: <strong>{{ strtoupper($act->location->care_of) ? strtoupper($act->location->care_of) : "N/A" }}</strong></div>
            @if(isset($act->salesmen->name))
            <div class="col-xs-3 col-md-6">Salesperson:
                <strong>{{ strtoupper($act->salesmen->name->abvr) ? strtoupper($act->salesmen->name->abvr) : "N/A" }}</strong>
            </div>
            @endif
            <div class="col-xs-3 col-md-6">Issue Date: {{ date('m/d/Y') }}</div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-md-6">
                <div class="col-xs-12 col-md-12 no-left-padding">
                    <h4 class="cpr-header">Contact Information</h4>
                </div>
                <div class="col-xs-12 col-md-12 no-left-padding">
                    @if(isset( $act->location->care_of ) && $act->location->care_of != '')
                        <div class="col-xs-3 col-md-2 no-left-padding">Care Of:</div>
                        <div class="col-xs-9 col-md-10 no-left-padding">{{ strtoupper($act->location->care_of) }}</div>
                    @endif
                    <div class="col-xs-3 col-md-2 no-left-padding">Address:</div>
                    <div class="col-xs-9 col-md-10 no-left-padding">{{ strtoupper($act->location->address1) }}</div>
                    @if(isset( $act->location->address2 ))
                        <div class="col-xs-3 col-md-2 no-left-padding"></div>
                        <div class="col-xs-9 col-md-10 no-left-padding">{{ strtoupper($act->location->address2) }}</div>
                    @endif

                    @if( isset( $act->location->address3 ) )
                        <div class="col-xs-2 col-md-2 no-left-padding"></div>
                        <div class="col-xs-9 col-md-10 no-left-padding">{{ strtoupper($act->location->address3) }}</div>
                    @endif
                    <div class="col-xs-3 col-md-2 no-left-padding"></div>
                    <div class="col-xs-9 col-md-10 no-left-padding">{{strtoupper($act->location->city) }} {{ strtoupper($act->location->state->abvr) }}
                        , {{ $act->location->zipcode }}</div>

                </div>
                <div class="col-xs-12 col-md-12 no-left-padding">
                    <div class="col-xs-2 col-md-2 no-left-padding">Contact:</div>
                    <div class="col-xs-10 col-md-10">
                        {{ strtoupper( $act->contact->firstName ) }}
                    </div>
                    @if($act->contact->email)
                        <div class="col-xs-2 col-md-2">Email:</div>
                        <div class="col-xs-10 col-md-10">
                            {{ strtoupper( $act->contact->email ) }}
                        </div>
                    @endif
                </div>
                <div class="col-xs-12 col-md-12 no-left-padding">
                    <h5>Phone</h5>

                    <div class="col-xs-2 col-md-1">Main:</div>
                    <div class="col-xs-10 col-md-3">{{ $act->contact->phone_work }}</div>
                    @if($act->contact->phone_cell)
                        <div class="col-xs-1 col-md-1">Mobile:</div>
                        <div class="col-xs-3 col-md-3">{{ $act->contact->phone_cell }}</div>
                    @endif
                    @if($act->contact->phone_fax )
                        <div class="col-xs-1 col-md-1">Fax:</div>
                        <div class="col-xs-3 col-md-3">{{ $act->contact->phone_fax }}</div>
                    @endif
                </div>
            </div>
            <div class="col-xs-6 col-md-6">
                <div class="col-xs-12 col-md-12 no-left-padding">
                    <h4 class="cpr-header">Tax Information</h4>
                </div>
                <div class="col-xs-12 col-md-12 no-left-padding">
                    @if(isset($act->actTax->info->percent))
                    <div class="col-xs-6 col-md-3">Sales Tax Rate:</div>
                    <div class="col-xs-6 col-md-9 no-left-padding">{{ isset($act->actTax->info->percent) ? $act->actTax->info->percent : '' }}%</div>
                    @endif
                    @if(isset($act->actTax->info))
                    <div class="col-xs-6 col-md-3">Dist:</div>
                    <div class="col-xs-6 col-md-9 no-left-padding">{{ strtoupper( $act->actTax->info->id_code ) }} &mdash; {{ strtoupper(strtolower($act->actTax->info->name)) }}</div>
                    @endif
                    <div class="col-xs-6 col-md-3">Type:</div>
                    <div class="col-xs-6 col-md-9 no-left-padding">{{ strtoupper( ( isset($act->actType->info->name) ? $act->actType->info->name : '' ) )  }}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <h4 class="cpr-header">Site Contact Information</h4>
            </div>
            <div class="col-xs-6 col-md-6">
                <div class="col-xs-3 col-md-2">Site:</div>
                <div class="col-xs-9 col-md-10 no-left-padding">
                    {{ strtoupper( $act->note->otherType ) }}
                </div>
                @if($act->note->notes_phone)
                    <div class="col-xs-3 col-md-2">Phone:</div>
                    <div class="col-xs-9 col-md-10 no-left-padding">
                        {{ $act->note->notes_phone }}
                    </div>
                @endif
                @if($act->note->notes_email)
                    <div class="col-xs-2 col-md-2">Email:</div>
                    <div class="col-xs-10 col-md-10 no-left-padding">
                        {{ strtoupper( $act->note->notes_email ) }}
                    </div>
                @endif
            </div>
            <div class="col-xs-6 col-md-6">
                @if($act->note->notes_contact)
                    <div class="col-xs-3 col-md-2">Site Contact:</div>
                    <div class="col-xs-9 col-md-10 no-left-padding">
                        {{ strtoupper( $act->note->notes_contact ) }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-12">
                <h4 class="cpr-header">Status</h4>
            </div>
            <div class="col-xs-4 col-md-4">
                <div class="col-xs-4 col-md-3 no-left-padding">Terms</div>
                <div class="col-xs-8 col-md-9 no-left-padding">
                    {{ strtoupper( ( isset( $act->actTerms->term->name) ? $act->actTerms->term->name:'') ) }}
                </div>
                <div class="col-xs-4 col-md-3 no-left-padding no-right-padding"><strong>Start Date</strong></div>
                <div class="col-xs-8 col-md-9 no-left-padding">
                    <strong> {{ date( 'm/d/Y', strtotime($act->actInfo->date_begin)) }}</strong>
                </div>
                @if($act->actInfo->date_end)
                    <div class="col-xs-4 col-md-3 no-left-padding no-right-padding"><strong>Exp. Date</strong></div>
                    <div class="col-xs-8 col-md-9 no-left-padding">
                        <strong>{{ date( 'm/d/Y', strtotime($act->actInfo->date_end)) }}</strong>
                    </div>
                @endif
            </div>
            <div class="col-xs-4 col-md-4">
                <div class="col-xs-6 col-md-3 no-left-padding no-right-padding">Customer Since:</div>
                <div class="col-xs-6 col-md-9 no-left-padding">
                    {{ date( 'm/d/Y', strtotime($act->actInfo->date_since)) }}
                </div>
                <div class="col-xs-6 col-md-3 no-left-padding no-right-padding">Account Status:</div>
                <div class="col-xs-6 col-md-9 no-left-padding">
                    {{ ($act->actStatus->name->code == "AC"? "ACTIVE" : strtoupper($act->actStatus->name->code) ) }}
                </div>
                @if($act->actStatus->name->code == "CH")
                <div class="col-xs-12 no-left-padding">Combined with #{{ $act->note->combine }}</div>
                @endif
                @if($act->actStatus->status_date)
                    <div class="col-xs-6 col-md-3 no-left-padding no-right-padding">Account Status Date:</div>
                    <div class="col-xs-6 col-md-9 no-left-padding">
                        {{ date( 'm/d/Y', strtotime($act->actStatus->status_date)) }}
                    </div>
                @else
                    <div class="col-xs-4 col-md-4"> &nbsp;</div>
                    <div class="col-xs-8 col-md-8 no-left-padding">
                        &nbsp;
                    </div>
                @endif
                <div class="col-xs-4 col-md-3 no-left-padding">Type</div>
                <div class="col-xs-8 col-md-9 no-left-padding">
                    {{ strtoupper( $act->actType->info->name ) }}
                </div>
                @if( $act->actStatus->act_freq['freq_id'] && ( $act->actType->info->name == 'Bi-Monthly' || $act->actType->info->name == 'Quarterly' || $act->actType->info->name == 'Other' ) )
                <div class="col-xs-4 col-md-3">{{ $act->actType->info->name }} Frequency:</div>
                <div class="col-xs-8 col-md-9 no-left-padding">
                    {{ ($act->actType->info->name == 'Other' ? strtoupper($act->actType->info->name) : strtoupper( $act->actStatus->act_freq['freq_msg'] ) ) }}
<!--                    {{ ($act->actType->info->name == 'Other' ? strtoupper($act->actStatus->act_other) : strtoupper( $act->actStatus->act_freq['freq_msg'] ) ) }}-->
                </div>
                @endif
            </div>
            <div class="col-xs-4 col-md-4">
                @if($act->actTax->exemptNumber)
                    <div class="col-xs-4 col-md-4">Tax Exempt:</div>
                    <div class="col-md-8 no-left-padding">
                        {{ $act->actTax->exemptNumber }}
                    </div>
                @else
                    <div class="col-xs-4 col-md-4"></div>
                    <div class="col-xs-8 col-md-8 no-left-padding">

                    </div>
                @endif
                @if($act->actInfo->po_number)
                    <div class="col-md-3">Customer PO:</div>
                    <div class="col-md-9 no-left-padding">
                        {{ strtoupper( $act->actInfo->po_number ) }}
                    </div>
                @endif
                @if(false)
                    <div class="col-md-4">Current Status:</div>
                    <div class="col-md-8 no-left-padding">
                        No Idea
                    </div>
                @endif
                <div class="col-xs-8 col-md-3">Autorenew:</div>
                <div class="col-xs-4 col-md-9 no-left-padding">
                    <strong>{{ strtoupper( $act->actType->automatic ) }}</strong>
                </div>
                <div class="col-xs-8 col-md-3">Commission:</div>
                <div class="col-xs-4 col-md-9 no-left-padding">
                    <strong>{{ strtoupper( $act->actType->commission) }}</strong>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-12">
                <h4 class="cpr-header">Billing</h4>
            </div>
            <div class="col-xs-6 col-md-6">
                <div class="full-report">
                    <div class="col-xs-6 col-md-4 no-left-padding no-right-padding">
                        <strong>Current Contract Amount:</strong>
                    </div>
                    <div class="col-xs-6 col-md-8">
                        <strong style="width: 50%; text-align: right; position: relative;">{{ $act->accounting->yearlyAmount }}</strong>
                    </div>

                    <div class="col-xs-6 col-md-4 no-left-padding no-right-padding"><strong>Current Billing
                            Amount:</strong></div>
                    <div class="col-xs-6 col-md-8">
                        <strong style="width: 50%; text-align: right; position: relative;">{{ $act->accounting->billing }}</strong>
                    </div>
                </div>

                <div class="col-xs-6 col-md-4 no-left-padding no-right-padding"><strong>Herbicide Budget:</strong></div>
                <div class="col-xs-6 col-md-8">
                    <strong style="width: 50%; text-align: right; position: relative;">{{ $act->accounting->budget }}</strong>
                </div>

            </div>
            <div class="col-xs-6 col-md-6">


                <div class="full-report">
                    <div class="col-xs-6 col-md-3 no-left-padding no-right-padding"><strong>Initial Start:</strong>
                    </div>
                    <div class="col-xs-6 col-md-9">
                        <strong> {{ $act->accounting->initialStart }}</strong>
                    </div>
                </div>

                <div class="col-xs-6 col-md-3 no-left-padding no-right-padding"><strong>Initial Budget:</strong></div>
                <div class="col-xs-6 col-md-9">
                    <strong>{{ $act->accounting->initialBudget }}</strong>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-12">
                <h4 class="cpr-header">Services</h4>
            </div>
            @if( $act->actServiceTrue )
                @foreach($act->actService as $at)
                    <div class="col-xs-6 col-md-6">
                        @foreach($at as $as)
                            <div class="col-xs-12 col-md-12">
                                <strong>{{ strtoupper( $as  ) }}</strong>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @else
                <div class="col-xs-12 col-md-12">
                    @foreach($act->actService as $as)
                        <div class="col-xs-12 col-md-12">
                            <strong>{{ strtoupper( $as->name ) }}</strong>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="row">
            @if($act->actInfo->permit)
                <div class="col-xs-4">
                    <div class="col-xs-3 col-md-3">Permit #:</div>
                    <div class="col-xs-8 col-md-8">{{ strtoupper( $act->actInfo->permit ) }}</div>
                </div>

            @endif
            @if($act->actInfo->permit_expire)
                <div class="col-xs-4">
                    <div class="col-xs-3 col-md-3">Expires:</div>
                    <div class="col-xs-8 col-md-8">{{ date( 'm/d/Y', strtotime( $act->actInfo->permit_expire )) }}</div>
                </div>

            @endif
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <h4 class="cpr-header">Notes</h4>
            </div>
            <div class="col-xs-12 col-md-12">
                <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden-print"
                     style="background-color:inherit; border: none;">
                </div>
                <div id="cprNotes1" class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 visible-print1"
                     style="background-color:inherit;border:none">
                    {!!html_entity_decode(nl2br(e($act->note->notes)))!!}
                </div>
            </div>
        </div>
        <hr class="cpr-footer">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <strong style="vertical-align: middle;"><h4><i style="color:red" class="fa fa-asterisk"></i><span> Technician is responsible for reviewing ALL CONTENTS of field file for important information before treatment.</span></h4></strong>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="<?php echo asset('/js/cpr.backend.js'); ?>" type="text/javascript"></script>
@endsection