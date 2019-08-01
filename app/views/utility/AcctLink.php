<?php
use App\Account;
use App\ActAccounting;
use App\ActOffice;
use App\ActInfo;
use App\ActStatus;
use App\ActTax;
use App\ActTerm;
use App\ActType;
use App\Status;
use App\State;
use App\Contact;
use App\Note;
use App\Location;
use App\Salesman;
use App\ActSalesman;
use App\Office;
use App\Term;
use App\Type;
use App\TaxDistrict;

$startTime = date("Y-m-d H:i:s");
set_time_limit(0);
ini_set('memory_limit', '512M');
\DB::table('accounts')->truncate();
\DB::table('locations')->truncate();
\DB::table('contacts')->truncate();
\DB::table('act_accountings')->truncate();
\DB::table('act_notes')->truncate();
\DB::table('act_info')->truncate();
\DB::table('account_service')->truncate();
\DB::table('act_combines')->truncate();
\DB::table('act_offices')->truncate();
\DB::table('act_salesmen')->truncate();
\DB::table('act_taxes')->truncate();
\DB::table('act_terms')->truncate();
\DB::table('act_types')->truncate();
\DB::table('act_status')->truncate();
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://workflow.lakedoctors.com/actCross.php");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($curl);
echo curl_error($curl);
curl_close($curl);
$test = json_decode($result);
foreach ($test as $t) {
//    switch($t[1]){
//        case "Alabama":
//            //
//            $stateCode = 1;
//            break;
//        case "Florida":
//            //
//            $stateCode = 10;
//            break;
//        case "Georgia":
//            //
//            $stateCode = 11;
//            break;
//        case "Kentucky":
//            //
//            $stateCode = 18;
//            break;
//        case "Ohio":
//            //
//            $stateCode = 36;
//            break;
//        case "North Carolina":
//            //
//            $stateCode = 34;
//            break;
//        case "South Carolina":
//            //
//            $stateCode = 42;
//            break;
//    }
    $stateId = State::where('name', 'LIKE', $t->STATE)->first();
    if (!$stateId) {
        $stateId = new stdClass();
        $stateId->id = 999;
    }
    $location = Location::create([
        'care_of' => fixName($t->CO),
        'address1' => fixName($t->ADDR1),
        'address2' => fixName($t->ADDR2),
        'city' => fixName($t->CITY),
        'state_id' => $stateId->id,
        'zipcode' => $t->ZIP
    ]);
    $contact = Contact::create([
        'firstName' => fixName($t->LNAME),
        'title' => fixName($t->FNAME),
        'phoneWork' => $t->PHONE,
        'phoneCell' => $t->MOBILE,
        'phoneFax' => $t->FAX,
        'email' => fixName($t->EMAIL)
    ]);
    $budget = new ActAccounting([
        'yearlyAmount' => $t->YEARLYAMT,
        'billing' => $t->BILLING,
        'budget' => $t->BUDGET,
        'initialStart' => $t->INITSTART,
        'initialBudget' => $t->INITBUDGET
    ]);
    $actNotes = new Note([
        'notes' => $t->NOTES,
        'otherType' => fixName($t->SITE),
        'notes_phone' => $t->NOTEPHONE,
        'notes_contact' => fixName($t->CONTACT),
        'notes_email' => fixName($t->URL)
    ]);

    $actInfo = new ActInfo([
        'date_since' => date('Y-m-d', strtotime($t->TIMESTAMP)),
        'date_begin' => date('Y-m-d', strtotime($t->BEGDATE)),
        'date_end' => date('Y-m-d', strtotime($t->EXPDATE)),
        'po_number' => $t->PONUM,
        'permit' => $t->PERMIT,
        'permit_expire' => date('Y-m-d', strtotime($t->PERMITEXP)),
    ]);

    switch (fixName($t->TAXSTATE)) {
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
        default:
            $stateCode = 999;
            break;
    }
    $taxDistrict = TaxDistrict::where('id_code', $t->DISTRICT)->first();
    if(!$taxDistrict){
        $taxDistrict = 999;
    }else{
        $taxDistrict = $taxDistrict->id;
    }
    $actTax = new ActTax([
        'taxState' => $stateCode,
        'taxDistrict' => $taxDistrict,
        'exemptNumber' => $t->EXEMPT,
    ]);
    switch ($t->SALESMAN) {
        case 'MAB':
            //
            $salesDude = 1;
            break;
        case 'KPL':
            //
            $salesDude = 2;
            break;
        case 'FJS':
            //
            $salesDude = 3;
            break;
        case 'MAS':
            //
            $salesDude = 4;
            break;
        case 'SMF':
            //
            $salesDude = 5;
            break;
        case 'MTS':
            //
            $salesDude = 6;
            break;
        case 'KES':
            //
            $salesDude = 7;
            break;
        case 'MMZ':
            //
            $salesDude = 8;
            break;
        case 'JJW':
            //
            $salesDude = 9;
            break;
        case 'KCB':
            //
            $salesDude = 10;
            break;
    }
    $salesman = new ActSalesman([
        'salesmen_id' => $salesDude
    ]);

    switch ($t->PTERMS) {
        case "NET 10 DAY":
        case "NET 10 DAYS":
            //
            $terms = 1;
            break;
        case "NET 20 DAYS":
            //
            $terms = 2;
            break;
        case "NET 30 DAYS":
            //
            $terms = 3;
            break;
        case "NET 35 DAYS":
            //
            $terms = 4;
            break;
        case "NET 45 DAYS":
            //
            $terms = 6;
            break;
        case "NET 60 DAYS":
            //
            $terms = 7;
            break;
        case "C.O.D. Cashiers Ck":
            //
            $terms = 9;
            break;
        default:
            //
            $terms = 999;
            break;
    }
    $termsS = new ActTerm([
        'term_id' => $terms
    ]);

    switch ($t->STATUS) {
        case 'CB':
            //
            $statusCode = 1;
            break;
        case 'CC':
            //
            $statusCode = 2;
            break;
        case 'CD':
            //
            $statusCode = 3;
            break;
        case 'CE':
            //
            $statusCode = 4;
            break;
        case 'CF':
            //
            $statusCode = 5;
            break;
        case 'CG':
            //
            $statusCode = 6;
            break;
        case 'CH':
            //
            $statusCode = 7;
            break;
        case 'CI':
            //
            $statusCode = 8;
            break;
        case 'CJ':
            //
            $statusCode = 9;
            break;
        case 'CK':
            //
            $statusCode = 10;
            break;
        case 'CL':
            //
            $statusCode = 11;
            break;
        case 'CM':
            //
            $statusCode = 12;
            break;
        case 'CN':
            //
            $statusCode = 13;
            break;
        case 'CP':
            //
            $statusCode = 14;
            break;
        case 'CQ':
            //
            $statusCode = 15;
            break;
        case 'CV':
            //
            $statusCode = 16;
            break;
        case 'CW':
            //
            $statusCode = 17;
            break;
        case 'CZ':
            //
            $statusCode = 18;
            break;
        case 'NP':
            //
            $statusCode = 19;
            break;
        case 'EX':
            //
            $statusCode = 20;
            break;
        case 'OH':
            //
            $statusCode = 21;
            break;
        case 'CX':
            //
            $statusCode = 22;
            break;
        case 'CR':
            //
            $statusCode = 23;
            break;
        default:
            $statusCode = 0;
            break;
    }

    switch ($t->CLIPTYPE) {
        case 2:
            //
            $statusFreq = 1;
            break;
        case 3:
            //
            $statusFreq = 2;
            break;
        case 4:
            //
            $statusFreq = 3;
            break;
        case 5:
            //
            $statusFreq = 4;
            break;
        case 6:
            //
            $statusFreq = 5;
            break;
        case 7:
            //
            $statusFreq = 6;
            break;
        case 8:
            //
            $statusFreq = 7;
            break;
        case 9:
            //
            $statusFreq = 8;
            break;
        case 10:
            //
            $statusFreq = 9;
            break;
        case 11:
            //
            $statusFreq = 10;
            break;
        case 12:
            //
            $statusFreq = 11;
            break;
        case 13:
            //
            $statusFreq = 12;
            break;
        case 15:
            //
            $statusFreq = 13;
            break;
        case 16:
            //
            $statusFreq = 14;
            break;
        case 17:
            //
            $statusFreq = 15;
            break;
        case 18:
            //
            $statusFreq = 16;
            break;
        case 19:
            //
            $statusFreq = 17;
            break;
        case 20:
            //
            $statusFreq = 18;
            break;
        case 21:
            //
            $statusFreq = 19;
            break;
        case 22:
            //
            $statusFreq = 20;
            break;
        case 23:
            //
            $statusFreq = 21;
            break;
        case 24:
            //
            $statusFreq = 22;
            break;
        case 25:
            //
            $statusFreq = 23;
            break;
        case 26:
            //
            $statusFreq = 24;
            break;
        default:
            $statusFreq = 999;
    }

    $actStatus = new ActStatus([
        'status_id' => $statusCode,
        'act_freq' => $statusFreq,
        'act_other' => fixName($t->TYPE_OTHER),
        'statusDate' => date('Y-m-d', strtotime($t->STATUS_DATE))
    ]);
    switch($t->OFFICE){
        case 'FM':
            //
            $office = 1;
            break;
        case 'FT':
            //
            $office = 2;
            break;
        case 'JX':
            //
            $office = 3;
            break;
        case 'KY':
            //
            $office = 4;
            break;
        case 'LR':
            //
            $office = 5;
            break;
        case 'OH':
            //
            $office = 6;
            break;
        case 'SA':
            //
            $office = 7;
            break;
        case 'WS':
            //
            $office = 8;
            break;
        case 'SC':
            //
            $office = 9;
            break;
        case 'NV':
            //
            $office = 10;
            break;
        case 'NOH':
            //
            $office = 11;
            break;
        default:
            $office = 999;
            break;
    }
    $actOffice = new ActOffice( [ 'office_id' => $office ]);
    switch ($t->ACCTTYPE) {

        case '12 MONTH':
            //
            $type = 1;
            break;
        case 'QUARTERLY':
            //
            $type = 2;
            break;
        case 'BIMONTHLY':
            //
            $type = 3;
            break;
        case 'BIANNUAL':
            //
            $type = 4;
            break;
        case 'FISH BARRIER':
            //
            $type = 5;
            break;
        case 'FISH/TGC':
            //
            $type = 6;
            break;
        case 'FOUNTAIN':
            //
            $type = 7;
            break;
        case 'MAJOR APPLICATION':
            //
            $type = 8;
            break;
        case 'PHYSICAL REMOVAL':
            //
            $type = 9;
            break;
        case 'PLANTING':
            //
            $type = 10;
            break;
        case 'CLARIFICATION':
            //
            $type = 11;
            break;
        case 'AERATION':
            //
            $type = 12;
            break;
        case 'FOUNTAIN CLEANING':
            //
            $type = 13;
            break;
        case 'FOUNTAIN REMOVAL':
            //
            $type = 14;
            break;
        case 'MONITORING':
            //
            $type = 15;
            break;
        default:
            //
            $type = 999;
            break;

            }
            $actType = new ActType([
                'types_id' => $type,
                'automatic' => $t->nonautomatic,
                'commission' => $t->NONCOMMISSION
            ]);


            $account = Account::create([
                'accountNumber' => $t->ACCTNUM,
                'actName' => fixName($t->ACCTNAME),
                'location_id' => $location->id,
                'contact_id' => $contact->id
            ]);
            $account->accounting()->save($budget);
            $account->note()->save($actNotes);
            $account->actInfo()->save($actInfo);
            $account->actTax()->save($actTax);
            $account->salesmen()->save($salesman);
            $account->actTerms()->save($termsS);
            $account->actStatus()->save($actStatus);
            $account->actType()->save($actType);
            $account->office()->save($actOffice);

    $preService = explode(',', $t->SERVICES);
    $cleanServices = [];
    if(count($preService) > 1 || (count($preService) == 1 && $preService[0] != '') ){
        foreach($preService as $s){
            if($s != 0){
                switch( $s ){
                    case '18':
                        //
                        $clean = 1;
                        break;
                    case '19':
                        //
                        $clean = 2;
                        break;
                    case '21':
                        //
                        $clean = 3;
                        break;
                    case '9':
                        //
                        $clean = 14;
                        break;
                    case '10':
                        //
                        $clean = 15;
                        break;
                    case '11':
                        //
                        $clean = 16;
                        break;
                    case '6':
                        //
                        $clean = 4;
                        break;
                    case '15':
                        //
                        $clean = 17;
                        break;
                    case '2':
                        //
                        $clean = 7;
                        break;
                    case '12':
                        //
                        $clean = 18;
                        break;
                    case '3':
                        //
                        $clean = 8;
                        break;
                    case '13':
                        //
                        $clean = 19;
                        break;
                    case '4':
                        //
                        $clean = 9;
                        break;
                    case '20':
                        //
                        $clean = 20;
                        break;
                    case '17':
                        //
                        $clean = 10;
                        break;
                    case '8':
                        //
                        $clean = 21;
                        break;
                    case '5':
                        //
                        $clean = 11;
                        break;
                    case '23':
                        //
                        $clean = 22;
                        break;
                    case '14':
                        //
                        $clean = 12;
                        break;
                    case '7':
                        //
                        $clean = 23;
                        break;
                    case '1':
                        //
                        $clean = 13;
                        break;
                }
                array_push($cleanServices, $clean);
            }
        }
        $account->actService()->attach($cleanServices);
    }
//    \DB::table('account_service')->where('service_id', 0)->delete();

            unset ($stateId);
            unset ($location);
            unset ($contact);
            unset ($account);
            unset ($budget);
            unset ($actNotes);
            unset ($actInfo);
            unset ($actTax);
            unset ($salesman);
            unset ($termsS);
            unset ($terms);
            unset ($statusCode);
            unset ($statusFreq);
            unset ($actStatus);
            unset ($office);
            unset ($actOffice);
            unset ($actType);
            unset ($type);
            unset ($t);
    }


    echo "Good<br />";
    $snepp = strtotime(date("Y-m-d H:i:s")) - strtotime($startTime);
    $snepMin = floor($snepp / 60);
    $snepSec = $snepp % 60;
    echo "Total Time: $snepMin Minutes $snepSec Seconds";
    function fixName($name)
    {
        return ucwords(strtolower($name));
    }