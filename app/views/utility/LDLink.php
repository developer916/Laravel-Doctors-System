<?php
use App\TaxDistrict;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,"https://workflow.lakedoctors.com/cross.php");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec ($curl);
    echo curl_error($curl);
    curl_close ($curl);
    $test = json_decode($result);
dd($test);
\DB::table('tax_districts')->truncate();
foreach($test as $t){
    switch($t[1]){
        case "Alabama":
            //
            $stateCode = 1;
            break;
        case "Florida":
            //
            $stateCode = 10;
            break;
        case "Georgia":
            //
            $stateCode = 11;
            break;
        case "Kentucky":
            //
            $stateCode = 18;
            break;
        case "Ohio":
            //
            $stateCode = 36;
            break;
        case "North Carolina":
            //
            $stateCode = 34;
            break;
        case "South Carolina":
            //
            $stateCode = 42;
            break;
    }
    TaxDistrict::create([
        'name'          => $t[0],
        'state_id'      => $stateCode,
        'id_code'       => $t[2],
        'percent'       => $t[3]
    ]);
}
//dd($test);
    print "Good";