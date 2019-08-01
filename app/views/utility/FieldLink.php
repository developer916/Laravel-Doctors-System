<?php

$startTime = date("Y-m-d H:i:s");
\DB::table('field_data')->truncate();
\DB::table('field_services')->truncate();
set_time_limit(0);
ini_set('memory_limit', '1024M');

$deadAcct = [];
$deadFieldNumber = 0;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,"https://workflow.lakedoctors.com/fieldCross.php");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec ($curl);
    echo curl_error($curl);
    curl_close ($curl);
    $test = json_decode($result);
    $accountNum = null;
    $account = null;
    $accountId = null;
    foreach($test as $t){
        if($accountNum != $t->ACCTNUM){
            $account = \App\Account::where('accountNumber', $t->ACCTNUM)->first();
            if(!$account){
                if(!in_array($t->ACCTNUM, $deadAcct) ){
                    \App\DeadAccount::create([ 'account_number' => $t->ACCTNUM]);
                    array_push($deadAcct, $t->ACCTNUM);
                }
                $deadFieldNumber++;
                continue;
            }
            $accountNum = $account->accountNumber;
            $accountId = $account->id;
        }
        $tech = \App\Technician::where('code', 'LIKE', $t->TECHCODE)->first();
        if(!$tech){
            $tech = new stdClass();
            $tech->id = 999;
        }
         $field = \App\FieldService::create([
            'account_id'  => $accountId,
            'tech_id' => $tech->id,
            'hours' => $t->MANHOURS,
            'notes' => $t->Notes,
            'service_date' => $t->ACCTDATE
        ]);

        $curl1 = curl_init();
        curl_setopt($curl1, CURLOPT_URL,"https://workflow.lakedoctors.com/fieldCross.php");
        curl_setopt($curl1, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl1, CURLOPT_POST, 1);
        curl_setopt($curl1, CURLOPT_POSTFIELDS,
            "num=$t->NUMBER");
        $result2 = curl_exec ($curl1);
        echo curl_error($curl1);
        curl_close ($curl1);
        $test1 = json_decode($result2);
        if(!is_array($test1)){
            continue;
        }
        foreach($test1 as $q){
            if(isset($q->MAT) && $q->MAT != ''){
                $mat_id = \App\Material::where('code', $q->MAT)->first();
                if(!$mat_id){
                    $mat_id = '';
                }else{
                    $mat_id = $mat_id->id;
                }
            }else{
                $mat_id = '';
            }
            if(is_null($q->QUANT)){
                $q->QUANT = 0;
            }
            if($q->QUANT == ''){
                $q->QUANT = 0;
            }
            $data = new \App\FieldData([
                'material_id' => $mat_id,
                'quantity' => $q->QUANT
            ]);
            $field->fieldData()->save($data);

        }
    }

    print "<br /><br />Good<br /><br />";
$snepp = strtotime(date("Y-m-d H:i:s")) - strtotime($startTime);
$sneppHours = floor( ($snepp / 60 ) / 60 );
$snepMin = floor( ($snepp / 60 ) % 60 );
$snepSec = $snepp % 60;

echo "Total Time:$SneppHours Hours $snepMin Minutes $snepSec Seconds<br /> DEAD ACCOUNTS ". count($deadAcct);
echo "<br /> Total Dead Field " . $deadFieldNumber;

var_dump($deadAcct);
