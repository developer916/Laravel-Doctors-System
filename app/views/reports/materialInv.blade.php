@extends('masters.printReport')

@section('title')
    Lake Doctors Inventory Report
@endsection

@section('content')
    <div class="container" >
        <div class="col-md-10 edit-box">
            <div class="col-md-6">
                <h4>Inventory Report</h4>
            </div>
            <div class="col-md-6">
                 <div class="pull-right" style="position: relative; top: 5px;">
                <a onclick="window.print()"><i class="fa fa-print"></i> Print Report</a>

                </div>           
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            
            <table id="mat-table" class="table table-striped" style="font-size: 8px;">
                <thead>
                <tr>
                    <th align="right">MAT CODE</th>
                    <th align="right">MAT NAME</th>
                    <th align="right">UNIT<br>OF<br>MEAS</th>
                    <th align="right">STD<br>COST</th>
                    <th align="right">BEG<br>INVEN</th>
                   <th align="right">PURCH<br>FOR<br>MONTH</th>
                    <th align="right">TOTAL<br>AVAIL</th>
                    <th align="right">END<br>INVEN</th>
                    <th align="right">QTY<br>USED</th>
                    <th align="right">END<br>INVEN<br>COST</th>
                    <th align="right">QTY<br>USED<br>COST</th>
                    <th align="right">PURCH<br>COST<br>MONTH</th>
                    <th align="right">BEG<br>INV<br>COST</th>
                    <? if (!$_GET['DATE_FROM'] or $_GET['DATE_FROM'] != $_GET['DATE_TO']) { ?>
                     <th align="right">DATE</th>
                        <? } ?>                
                     <th align="right">OFFICE</th>
                </tr>
                </thead>
                <tbody class="mat-code">
               <?PHP
                $endinv_total = 0;
                $used_total =0;
                $purchmo_total = 0;
                $beginv_total = 0;
                $pmo_total = 0; 
                ?>
                @foreach ($material3 as $rep)

                <?PHP
                
                $endinv_total += $rep->cost*$rep->end_amount;
                $used_total += $rep->cost*($rep->begin_amount + $rep->purchased_amount + $rep->trans - $rep->end_amount);
                $purchmo_total += $rep->cost*$rep->purchased_amount;
                $beginv_total += $rep->cost*$rep->begin_amount;
                $pmo_total += $rep->purchased_amount;
                ?>


                    <tr>
                        <td>{{ $rep->code }}</td>
                        <td>{{ $rep->name }}</td>
                        <td>{{ $rep->units }}</td>
                        <td>{{ $rep->cost }}</td>
                        <td>{{ $rep->begin_amount}}</td>
                        <td>{{ $rep->purchased_amount }}</td>
                        <td>{{ number_format($rep->begin_amount + $rep->purchased_amount + $rep->trans,2)}}</td>
                        <td>{{ number_format($rep->begin_amount + $rep->purchased_amount + $rep->trans - $rep->end_amount , 2)}}</td>
                        <td>{{ $rep->end_amount}}</td>
                        <td>{{ number_format($rep->cost * $rep->end_amount,2)}}</td>
                        <td>{{ number_format(($rep->begin_amount + $rep->purchased_amount + $rep->trans - $rep->end_amount)*$rep->cost , 2)}}</td>
                        <td>{{ number_format($rep->cost * $rep->purchased_amount,2)}}</td>
                        <td>{{ number_format($rep->cost * $rep->begin_amount,2)}}</td>


                        <td>{{ date('m/d/Y', strtotime($rep->month) ) }}</td>
                        <td>{{ $rep->abvr }}</td>
                    </tr>

                @endforeach

                    <tr>
                        <td align="right">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="right">&nbsp;</td>
                        <td align="right">&nbsp;</td>
                     
                        <td align="right"><span class="special">Total</span></td>
                        <td align="right"><?=number_format($pmo_total, 2)?></td>       
                        <td align="right">&nbsp;</td>
                        <td align="right">&nbsp;</td>
                        <td align="right">&nbsp;</td>
                        <td align="right">$<?=number_format($endinv_total, 2)?></td>
                        <td align="right">$<?=number_format($used_total, 2)?></td>
                        <td align="right">$<?=number_format($purchmo_total, 2)?></td>
                        <td align="right">$<?=number_format($beginv_total, 2)?></td>
                        <td align="right">&nbsp;</td>
                        <td align="right">&nbsp;</td>
                    </tr>

                </tbody>
                </thead>
 
 


                <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="<?php echo asset('/js/material-ref.report.module.js'); ?>" type="text/javascript"></script>
@endsection