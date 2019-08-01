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
                <label for="">
                    <input type="radio" style="position: relative;top:2px;" name="reportType" id="dual">&nbsp; Both
                </label>
            </div>
        </div>
        @foreach($acts as $act)
        <div class="print-page">
        <div class="row cpr-head"  >
        <hr class="page-hr"/>
    <div class="row  pull-right col-xs-4 col-md-4" style="font-size: 16pt;" >
        
        <strong></strong>
        
    </div>
     </div>   

    <div class="row">
        <div class="col-xs-12 col-md-12"  style="font-size: 10pt;"><strong>Account Name: {{ strtoupper($act->actName) }}</strong>
        <p><strong>Account Number: {{ $act->accountNumber}}</strong></div>
    </div>
    <div class="row"   style="font-size: 10pt;">
        <div class="col-xs-6 col-md-6">Office ID/Terr:
            <strong>{{ strtoupper($act->officeName->abvr) }}</strong>
        </div>
        @if(isset($act->salesman->abvr))
        <div class="col-xs-6 col-md-6">Salesperson:
            <strong>{{ strtoupper($act->salesman->abvr) ? strtoupper($act->salesman->abvr) : "N/A" }}</strong>
        </div>
        @endif
        <div class="col-xs-6 col-md-6">Issue Date: {{ date('m/d/Y') }}</div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-md-6">
            <div class="col-xs-12 col-md-12 no-left-padding">
                <h4 class="cpr-header" style="font-size: 10pt;">Contact Information</h4>
                
            </div>
            <div class="col-xs-12 col-md-12 no-left-padding" style="font-size: 12px;" >
                @if(isset( $act->location->care_of ) && $act->location->care_of != '')
                    <div class="col-xs-12 col-md-12 no-left-padding">Care Of:<strong>&nbsp;{{ strtoupper($act->location->care_of) }}</strong></div>
                @endif
                <div class="col-xs-12 col-md-12 no-left-padding">Address:&nbsp;{{ strtoupper($act->location->address1) }}</div>
                @if( $act->location->address2 )
                    <div class="col-xs-12 col-md-12 no-left-padding">{{ strtoupper($act->location->address2) }}</div>
                @endif

                <div class="col-xs-12 col-md-12 no-left-padding">{{strtoupper($act->location->city) }} {{ strtoupper($act->location->state->abvr) }}
                    , {{ $act->location->zipcode }}</div>

                @if( isset( $act->location->address3 ) )
                    <div class="col-xs-12 col-md-12 no-left-padding">&nbsp;{{ strtoupper($act->location->address3) }}</div>
                @endif
            </div>
            <div class="col-xs-12 col-md-12 no-left-padding"  style="font-size: 12px;">
                <div class="col-xs-12 col-md-12 no-left-padding">Contact:&nbsp;
                    {{ strtoupper( $act->contact->firstName ) }}
                <br />
                @if($act->contact->title)
                    Title: {{strtoupper( $act->contact->title )}}
                    <br/>
                @endif
                @if($act->contact->email)
                    Email:&nbsp;{{ strtoupper( $act->contact->email ) }}                    
                @endif
                </div>
            </div>
            <div class="col-xs-12 col-md-12 no-left-padding"  style="font-size: 12px;">
            <h5 style="font-size: 12px;">Phone</h5>

                <div class="col-xs-4 col-md-4">
                    Main:&nbsp;{{ App\Helpers\PhoneNumberHelper::getNumber($act->contact->phone_work) }}
                    @if( !is_null(App\Helpers\PhoneNumberHelper::getExtension($act->contact->phone_work)) )
                        <br>
                        Ext: {{ App\Helpers\PhoneNumberHelper::getExtension($act->contact->phone_work) }}
                    @endif    
                </div>
                @if($act->contact->phone_cell)
                    <div class="col-xs-4 col-md-4">Mobile:&nbsp;{{ App\Helpers\PhoneNumberHelper::getNumber($act->contact->phone_cell) }}</div>
                @else
                    <div class="col-xs-4 col-md-4">Mobile:&nbsp;</div>
                @endif
                @if($act->contact->phone_fax )
                    <div class="col-xs-4 col-md-4">Fax:&nbsp;{{ App\Helpers\PhoneNumberHelper::getNumber($act->contact->phone_fax) }}</div>
                 @else   
                    <div class="col-xs-4 col-md-4">Fax:&nbsp;</div>
                @endif
            </div>
        </div>
        <div class="col-xs-6 col-md-6">
            <div class="col-xs-12 col-md-12 no-left-padding">
                <h4 class="cpr-header" style="font-size: 10pt;">Tax Information</h4>
                
            </div>
            <div class="col-xs-12 col-md-12 no-left-padding"  style="font-size: 12px;">
                @if(isset($act->actTax->info->percent))
                <div class="col-xs-12 col-md-12">Sales Tax Rate:&nbsp;{{ isset($act->actTax->info->percent) ? $act->actTax->info->percent : '' }}%</div>
                @endif
                @if(isset($act->actTax->info))
                <div class="col-xs-12 col-md-12">Dist:&nbsp;{{ strtoupper( $act->actTax->info->id_code ) }} &mdash; {{ strtoupper(strtolower($act->actTax->info->name)) }}</div>
                @endif
                <div class="col-xs-12 col-md-12">Type:&nbsp;{{ strtoupper( ( isset($act->actType->info->name) ? $act->actType->info->name : '' ) )  }}</div>
            @if($act->actInfo->po_number)
                <div class="col-md-12">Customer PO:&nbsp;
                    {{ strtoupper( $act->actInfo->po_number ) }}
                </div>
            @else
                <div class="col-md-12">Customer PO:&nbsp;
                </div>
            @endif
            @if($act->actTax->exemptNumber)
                <div class="col-xs-12 col-md-12">Tax Exempt:&nbsp;
                    {{ $act->actTax->exemptNumber }}
                </div>
            @else
                <div class="col-xs-12 col-md-12">Tax Exempt: NO
                </div>
            @endif



                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12" >
            <h4 class="cpr-header" style="font-size: 10pt;">Site Contact Information</h4>
             
        </div>
        <div class="col-xs-6 col-md-6"  style="font-size: 12px;">
            <div class="col-xs-12 col-md-12">Site:&nbsp;
                {{ strtoupper( $act->note->otherType ) }}
            </div>
            @if($act->note->notes_phone)
                <div class="col-xs-12 col-md-12">Phone:&nbsp;
                    {{ App\Helpers\PhoneNumberHelper::getNumber($act->note->notes_phone) }}
                    @if(!is_null(App\Helpers\PhoneNumberHelper::getExtension($act->note->notes_phone)))
                        <br/>
                        Ext: {{ App\Helpers\PhoneNumberHelper::getExtension($act->note->notes_phone) }}
                    @endif    
                </div>
            @endif
           @if($act->note->notes_email)
                <div class="col-xs-12 col-md-12">Email:&nbsp;
                    {{ strtoupper( $act->note->notes_email ) }}
                </div>
            @endif
        </div>
        <div class="col-xs-6 col-md-6"   style="font-size: 12px;">
            @if($act->note->notes_contact)
                <div class="col-xs-12 col-md-12">Site Contact:&nbsp;
                    {{ strtoupper( $act->note->notes_contact ) }}
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <h4 class="cpr-header" style="font-size: 10pt;">Status</h4>
             
        </div>
        <div class="col-xs-3 col-md-3"  style="font-size: 12px;">
            <div class="col-xs-12 col-md-12 no-left-padding">Terms&nbsp;
                {{ strtoupper( ( isset( $act->actTerms->term->name) ? $act->actTerms->term->name:'') ) }}
            </div>
            <div class="col-xs-12 col-md-12 no-left-padding no-right-padding"><strong>Start Date</strong>&nbsp;
                <strong> {{ date( 'm/d/Y', strtotime($act->actInfo->date_begin)) }}</strong>
            </div>
            @if($act->actInfo->date_end)
                <div class="col-xs-12 col-md-12 no-left-padding no-right-padding"><strong>Exp. Date</strong>&nbsp;
                    <strong>{{ date( 'm/d/Y', strtotime($act->actInfo->date_end)) }}</strong>
                </div>
            @else
                <div class="col-xs-12 col-md-12 no-left-padding no-right-padding"><strong>Exp. Date</strong>&nbsp;
                </div>
            @endif
            <div class="col-xs-12 col-md-12 no-left-padding">Type&nbsp;
            @if(isset($act->actType->info))    
                {{ strtoupper( $act->actType->info->name ) }}
            @endif
            </div>

        </div>
        <div class="col-xs-3 col-md-3"  style="font-size: 12px;">
            <div class="col-xs-12 col-md-12 no-left-padding no-right-padding">Customer Since:&nbsp;
                {{ date( 'm/d/Y', strtotime($act->actInfo->date_since)) }}
            </div>
            <div class="col-xs-12 col-md-12 no-left-padding no-right-padding">Account Status:&nbsp;
                {{ ($act->actStatus->name->code == "AC"? "ACTIVE" : strtoupper($act->actStatus->name->code) ) }}
            </div>
            @if($act->actStatus->name->code == "CH")
            <div class="col-xs-12 no-left-padding">Combined with #{{ $act->note->combine }}</div>
            @endif
            @if($act->actStatus->status_date)
                <div class="col-xs-12 col-md-12 no-left-padding no-right-padding">Account Status Date:&nbsp;
                    {{ date( 'm/d/Y', strtotime($act->actStatus->status_date)) }}
                </div>
            @else
                <div class="col-xs-12 col-md-12 no-left-padding no-right-padding">Account Status Date:&nbsp;
                    
                </div>
            @endif
            


         </div>
        <div class="col-xs-4 col-md-4"  style="font-size: 12px;">


            @if(false)
                <div class="col-md-12">Current Status:&nbsp;
                    No Idea
                </div>
            @endif
            <div class="col-xs-12 col-md-12">Autorenew:&nbsp;
                <strong>{{ $act->actType->automatic ? 'N' : 'Y' }}</strong>
            </div>
            <div class="col-xs-12 col-md-12">Commission:&nbsp;
                <strong>{{ $act->actType->commission ? 'N' : 'Y' }}</strong>
            </div>
        </div>



    </div>

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <h4 class="cpr-header" style="font-size: 10pt;">Billing</h4>
             
        </div>
        <div class="col-xs-6 col-md-6"  style="font-size: 12px;">
            <div class="full-report">
                <div class="col-xs-12 col-md-12 no-left-padding no-right-padding">
                    <strong>Current Contract Amount:</strong>
                &nbsp;
                    <strong style="width: 50%; text-align: right; position: relative;">{{ $act->accounting->yearlyAmount }}</strong>
                </div>

                <div class="col-xs-12 col-md-12 no-left-padding no-right-padding"><strong>Current Billing
                        Amount:</strong>&nbsp;
                    <strong style="width: 50%; text-align: right; position: relative;">{{ $act->accounting->billing }}</strong>
                </div>
            </div>

            <div class="col-xs-12 col-md-12 no-left-padding no-right-padding"><strong>Herbicide Budget:</strong>&nbsp;
                <strong style="width: 50%; text-align: right; position: relative;">{{ $act->accounting->budget }}</strong>
            </div>

        </div>
        <div class="col-xs-6 col-md-6"  style="font-size: 12px;">


            <div class="full-report">
                <div class="col-xs-12 col-md-12 no-left-padding no-right-padding"><strong>Initial Start:</strong>
                &nbsp;
                    <strong> {{ $act->accounting->initialStart }}</strong>
                </div>
            </div>

            <div class="col-xs-12 col-md-12 no-left-padding no-right-padding"><strong>Initial Budget:</strong>&nbsp;
                <strong>{{ $act->accounting->initialBudget }}</strong>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <h4 class="cpr-header" style="font-size: 10pt;">Services</h4>
             
        </div>
        @if( $act->actServiceTrue )
            @foreach($act->actService as $at)
                <div class="col-xs-6 col-md-6"  style="font-size: 12px;">
                    @foreach($at as $as)
                        <div class="col-xs-12 col-md-12">
                            <strong>{{ strtoupper( $as  ) }}</strong>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @else
            <div class="col-xs-12 col-md-12"  style="font-size: 12px;">
                @foreach($act->actService as $as)
                    <div class="col-xs-12 col-md-12">
                        <strong>{{ strtoupper( $as->name ) }}</strong>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <div class="row"  style="font-size: 12px;">
        @if($act->actInfo->permit)
            <div class="col-xs-4">
                <div class="col-xs-4 col-md-4">Permit #:&nbsp;{{ strtoupper( $act->actInfo->permit ) }}</div>
            </div>

        @endif
        @if($act->actInfo->permit_expire)
            <div class="col-xs-4">
                <div class="col-xs-4 col-md-4">Expires:&nbsp;{{ date( 'm/d/Y', strtotime( $act->actInfo->permit_expire )) }}</div>
            </div>

        @endif
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <h4 class="cpr-header" style="font-size: 10pt;">Notes</h4>
             
        </div>
        <div class="col-xs-12 col-md-12"  style="font-size: 12px;">
            <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden-print"
                 style="background-color:inherit; border: none;">
            </div>
            <div id="cprNotes1" class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 visible-print1"
                 style="background-color:inherit;border:none">
                 <?php echo str_replace(array("\r\n", "\n\r", "\r", "\n"),'<p>',$act->note->notes) ?>
            </div>
        </div>
    </div>
    <hr class="cpr-footer"  style="font-size: 12px;">
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <strong style="vertical-align: middle;"><h4 style="font-size: 10pt;"><i style="color:red" class="fa fa-asterisk"></i><span> Technician is responsible for reviewing ALL CONTENTS of field file for important information before treatment.</span></h4></strong>
        </div>
    </div>

    </div>

<div class="dual-report print-page">
    <div class="row cpr-head"  >
        <hr class="page-hr"/>
    <div class="row  pull-right col-xs-4 col-md-4" style="font-size: 16pt;" >
        
        <strong></strong>
        
    </div>
     </div>   

    <div class="row">
        <div class="col-xs-12 col-md-12"  style="font-size: 10pt;"><strong>Account Name: {{ strtoupper($act->actName) }}</strong>
        <p><strong>Account Number: {{ $act->accountNumber}}</strong></div>
    </div>
    <div class="row"   style="font-size: 10pt;">
        <div class="col-xs-6 col-md-6">Office ID/Terr:
            <strong>{{ strtoupper($act->officeName->abvr) }}</strong>
        </div>
        @if(isset($act->salesman->abvr))
        <div class="col-xs-6 col-md-6">Salesperson:
            <strong>{{ strtoupper($act->salesman->abvr) ? strtoupper($act->salesman->abvr) : "N/A" }}</strong>
        </div>
        @endif
        <div class="col-xs-6 col-md-6">Issue Date: {{ date('m/d/Y') }}</div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-md-6">
            <div class="col-xs-12 col-md-12 no-left-padding">
                <h4 class="cpr-header" style="font-size: 10pt;">Contact Information</h4>
                
            </div>
            <div class="col-xs-12 col-md-12 no-left-padding" style="font-size: 12px;" >
                @if(isset( $act->location->care_of ) && $act->location->care_of != '')
                    <div class="col-xs-12 col-md-12 no-left-padding">Care Of:<strong>&nbsp;{{ strtoupper($act->location->care_of) }}</strong></div>
                @endif
                <div class="col-xs-12 col-md-12 no-left-padding">Address:&nbsp;{{ strtoupper($act->location->address1) }}</div>
                @if( $act->location->address2 )
                    <div class="col-xs-12 col-md-12 no-left-padding">{{ strtoupper($act->location->address2) }}</div>
                @endif

                <div class="col-xs-12 col-md-12 no-left-padding">{{strtoupper($act->location->city) }} {{ strtoupper($act->location->state->abrv) }}
                    , {{ $act->location->zipcode }}</div>

                @if( isset( $act->location->address3 ) )
                    <div class="col-xs-12 col-md-12 no-left-padding">&nbsp;{{ strtoupper($act->location->address3) }}</div>
                @endif
            </div>
            <div class="col-xs-12 col-md-12 no-left-padding"  style="font-size: 12px;">
                <div class="col-xs-12 col-md-12 no-left-padding">Contact:&nbsp;
                    {{ strtoupper( $act->contact->firstName ) }}
                <br />
                @if($act->contact->title)
                    Title: {{strtoupper( $act->contact->title )}}
                    <br/>
                @endif
                @if($act->contact->email)
                     Email:&nbsp;{{ strtoupper( $act->contact->email ) }}
                    
                @endif
                </div>
            </div>
            <div class="col-xs-12 col-md-12 no-left-padding"  style="font-size: 12px;">
            <h5 style="font-size: 12px;">Phone</h5>

                <div class="col-xs-4 col-md-4">
                    Main:&nbsp;{{ App\Helpers\PhoneNumberHelper::getNumber($act->contact->phone_work) }}
                    @if( !is_null(App\Helpers\PhoneNumberHelper::getExtension($act->contact->phone_work)) )
                        <br>
                        Ext: {{ App\Helpers\PhoneNumberHelper::getExtension($act->contact->phone_work) }}
                    @endif    
                </div>
                @if($act->contact->phone_cell)
                    <div class="col-xs-4 col-md-4">Mobile:&nbsp;{{  App\Helpers\PhoneNumberHelper::getNumber($act->contact->phone_cell) }}</div>
                @else
                    <div class="col-xs-4 col-md-4">Mobile:&nbsp;</div>
                @endif
                @if($act->contact->phone_fax )
                    <div class="col-xs-4 col-md-4">Fax:&nbsp;{{ App\Helpers\PhoneNumberHelper::getNumber($act->contact->phone_fax) }}</div>
                 @else
                    <div class="col-xs-4 col-md-4">Fax:&nbsp;</div>
                @endif
            </div>
        </div>
        <div class="col-xs-6 col-md-6">
            <div class="col-xs-12 col-md-12 no-left-padding">
                <h4 class="cpr-header" style="font-size: 10pt;">Tax Information</h4>
                
            </div>
            <div class="col-xs-12 col-md-12 no-left-padding"  style="font-size: 12px;">
                @if(isset($act->actTax->info->percent))
                <div class="col-xs-12 col-md-12">Sales Tax Rate:&nbsp;{{ isset($act->actTax->info->percent) ? $act->actTax->info->percent : '' }}%</div>
                @endif
                @if(isset($act->actTax->info))
                <div class="col-xs-12 col-md-12">Dist:&nbsp;{{ strtoupper( $act->actTax->info->id_code ) }} &mdash; {{ strtoupper(strtolower($act->actTax->info->name)) }}</div>
                @endif
                <div class="col-xs-12 col-md-12">Type:&nbsp;{{ strtoupper( ( isset($act->actType->info->name) ? $act->actType->info->name : '' ) )  }}</div>
            @if($act->actInfo->po_number)
                <div class="col-md-12">Customer PO:&nbsp;
                    {{ strtoupper( $act->actInfo->po_number ) }}
                </div>
            @else
                <div class="col-md-12">Customer PO:&nbsp;
                </div>
            @endif
            @if($act->actTax->exemptNumber)
                <div class="col-xs-12 col-md-12">Tax Exempt:&nbsp;
                    {{ $act->actTax->exemptNumber }}
                </div>
            @else
                <div class="col-xs-12 col-md-12">Tax Exempt: NO
                </div>
            @endif



                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12" >
            <h4 class="cpr-header" style="font-size: 10pt;">Site Contact Information</h4>
             
        </div>
        <div class="col-xs-6 col-md-6"  style="font-size: 12px;">
            <div class="col-xs-12 col-md-12">Site:&nbsp;
                {{ strtoupper( $act->note->otherType ) }}
            </div>
            @if($act->note->notes_phone)
                <div class="col-xs-12 col-md-12">Phone:&nbsp;
                    {{ App\Helpers\PhoneNumberHelper::getNumber($act->note->notes_phone) }}
                    @if( !is_null(App\Helpers\PhoneNumberHelper::getExtension($act->note->notes_phone)) )
                        <br/>
                        Ext: {{ App\Helpers\PhoneNumberHelper::getExtension($act->note->notes_phone) }}
                    @endif    
                </div>
            @endif
            @if($act->note->notes_email)
                <div class="col-xs-12 col-md-12">Email:&nbsp;
                    {{ strtoupper( $act->note->notes_email ) }}
                </div>
            @endif
        </div>
        <div class="col-xs-6 col-md-6"   style="font-size: 12px;">
            @if($act->note->notes_contact)
                <div class="col-xs-12 col-md-12">Site Contact:&nbsp;
                    {{ strtoupper( $act->note->notes_contact ) }}
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <h4 class="cpr-header" style="font-size: 10pt;">Status</h4>
             
        </div>
        <div class="col-xs-3 col-md-3"  style="font-size: 12px;">
            <div class="col-xs-12 col-md-12 no-left-padding">Terms&nbsp;
                {{ strtoupper( ( isset( $act->actTerms->term->name) ? $act->actTerms->term->name:'') ) }}
            </div>
            <div class="col-xs-12 col-md-12 no-left-padding no-right-padding"><strong>Start Date</strong>&nbsp;
                <strong> {{ date( 'm/d/Y', strtotime($act->actInfo->date_begin)) }}</strong>
            </div>
            @if($act->actInfo->date_end)
                <div class="col-xs-12 col-md-12 no-left-padding no-right-padding"><strong>Exp. Date</strong>&nbsp;
                    <strong>{{ date( 'm/d/Y', strtotime($act->actInfo->date_end)) }}</strong>
                </div>
            @else
                <div class="col-xs-12 col-md-12 no-left-padding no-right-padding"><strong>Exp. Date</strong>&nbsp;
                </div>
            @endif
            <div class="col-xs-12 col-md-12 no-left-padding">Type&nbsp;
            @if(isset($act->actType->info))    
                {{ strtoupper( $act->actType->info->name ) }}
            @endif
            </div>

        </div>
        <div class="col-xs-3 col-md-3"  style="font-size: 12px;">
            <div class="col-xs-12 col-md-12 no-left-padding no-right-padding">Customer Since:&nbsp;
                {{ date( 'm/d/Y', strtotime($act->actInfo->date_since)) }}
            </div>
            <div class="col-xs-12 col-md-12 no-left-padding no-right-padding">Account Status:&nbsp;
                {{ ($act->actStatus->name->code == "AC"? "ACTIVE" : strtoupper($act->actStatus->name->code) ) }}
            </div>
            @if($act->actStatus->name->code == "CH")
            <div class="col-xs-12 no-left-padding">Combined with #{{ $act->note->combine }}</div>
            @endif
            @if($act->actStatus->status_date)
                <div class="col-xs-12 col-md-12 no-left-padding no-right-padding">Account Status Date:&nbsp;
                    {{ date( 'm/d/Y', strtotime($act->actStatus->status_date)) }}
                </div>
            @else
                <div class="col-xs-12 col-md-12 no-left-padding no-right-padding">Account Status Date:&nbsp;
                    
                </div>
            @endif
            


         </div>
        <div class="col-xs-4 col-md-4"  style="font-size: 12px;">


            @if(false)
                <div class="col-md-12">Current Status:&nbsp;
                    No Idea
                </div>
            @endif
            <div class="col-xs-12 col-md-12">Autorenew:&nbsp;
                <strong>{{ $act->actType->automatic ? 'N' : 'Y'  }}</strong>
            </div>
            <div class="col-xs-12 col-md-12">Commission:&nbsp;
                <strong>{{ $act->actType->commission ? 'N' : 'Y' }}</strong>
            </div>
        </div>



    </div>

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <h4 class="cpr-header" style="font-size: 10pt;">Billing</h4>
             
        </div>
        <div class="col-xs-6 col-md-6"  style="font-size: 12px;">

            <div class="col-xs-12 col-md-12 no-left-padding no-right-padding"><strong>Herbicide Budget:</strong>&nbsp;
                <strong style="width: 50%; text-align: right; position: relative;">{{ $act->accounting->budget }}</strong>
            </div>

        </div>
        <div class="col-xs-6 col-md-6"  style="font-size: 12px;">

            <div class="col-xs-12 col-md-12 no-left-padding no-right-padding"><strong>Initial Budget:</strong>&nbsp;
                <strong>{{ $act->accounting->initialBudget }}</strong>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <h4 class="cpr-header" style="font-size: 10pt;">Services</h4>
             
        </div>
        @if( $act->actServiceTrue )
            @foreach($act->actService as $at)
                <div class="col-xs-6 col-md-6"  style="font-size: 12px;">
                    @foreach($at as $as)
                        <div class="col-xs-12 col-md-12">
                            <strong>{{ strtoupper( $as  ) }}</strong>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @else
            <div class="col-xs-12 col-md-12"  style="font-size: 12px;">
                @foreach($act->actService as $as)
                    <div class="col-xs-12 col-md-12">
                        <strong>{{ strtoupper( $as->name ) }}</strong>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <div class="row"  style="font-size: 12px;">
        @if($act->actInfo->permit)
            <div class="col-xs-4">
                <div class="col-xs-4 col-md-4">Permit #:&nbsp;{{ strtoupper( $act->actInfo->permit ) }}</div>
            </div>

        @endif
        @if($act->actInfo->permit_expire)
            <div class="col-xs-4">
                <div class="col-xs-4 col-md-4">Expires:&nbsp;{{ date( 'm/d/Y', strtotime( $act->actInfo->permit_expire )) }}</div>
            </div>

        @endif
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <h4 class="cpr-header" style="font-size: 10pt;">Notes</h4>
             
        </div>
        <div class="col-xs-12 col-md-12"  style="font-size: 12px;">
            <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden-print"
                 style="background-color:inherit; border: none;">
            </div>
            <div id="cprNotes1" class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 visible-print1"
                 style="background-color:inherit;border:none">
                 <?php echo str_replace(array("\r\n", "\n\r", "\r", "\n"),'<p>',$act->note->notes) ?>
            </div>
        </div>
    </div>
    <hr class="cpr-footer">
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <strong style="vertical-align: middle;"><h4 style="font-size: 10pt;"><i style="color:red" class="fa fa-asterisk"></i><span> Technician is responsible for reviewing ALL CONTENTS of field file for important information before treatment.</span></h4></strong>
        </div>
     </div>
</div>

        @endforeach
    </div>
</div>
@endsection

@section('scripts')
    <script src="<?php echo asset('/js/cpr.backend.js'); ?>" type="text/javascript"></script>
@endsection