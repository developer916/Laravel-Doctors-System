<?php
/***************************************************************
 * Service created to handle the logic behind the data migration
 * 2018-05-21
 * Trent Raber
 ****************************************************************/

namespace App\Services;

use App\MigrationModels\OldAccount;
use App\MigrationModels\OldField;
use App\MigrationModels\OldTaxDistrict;
use App\MigrationModels\OldOfficeAccess;
use App\MigrationModels\OldInventory;
use App\MigrationModels\OldMaterial;
use App\MigrationModels\OldUsers;
use App\MigrationModels\OldUserPerms;
use App\MigrationModels\OldTech;
use App\State;
use App\Salesman;
use App\TaxDistrict;
use App\Status;
use App\Office;
use App\Contact;
use App\ActAccounting;
use App\Invantory;
use App\Location;
use App\Note;
use App\ActInfo;
use App\ActTax;
use App\ActSalesman;
use App\ActStatus;
use App\ActOffice;
use App\ActType;
use App\ActTerm;
use App\Account;
use App\Technician;
use App\FieldService;
use App\FieldData;
use App\User;
use App\Term;
use Carbon\Carbon;
use DB;
use App\Material;

class DataMigrationService
{
    CONST DATA_IMPORT_START = '2013-12-31 00:00:00';

    /**
     * This method truncates all the necessary tables
     * before starting the import
     */

    public function truncateTables()
    {
        // For Accounts Data
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

        // For Fields Import
        \DB::table('field_data')->truncate();
		\DB::table('field_services')->truncate();

		// For Inventory Data
        \DB::table('invantories')->truncate();

        // For Material Data
        \DB::table('materials')->truncate();

        // For Tax Districts
        \DB::table('tax_districts')->truncate();

        // For Technicians
        \DB::table('technicians')->truncate();

        // For Users
        \DB::table('users')->truncate();
        \DB::table('permission_user')->truncate();
        \DB::table('office_user')->truncate();
    }

    /**
     * This method migrates the account data
     */

    public function migrateAccounts()
    {
        $oldAccounts = OldAccount::all();

        foreach($oldAccounts as $oldAccount)
        {
            $this->createAccountAndRelations($oldAccount);
        }
    }

    /**
     * This method migrates the field report data
     */

    public function migrateFieldData()
    {
        $count = OldField::where('ACCTDATE', '>', self::DATA_IMPORT_START)->count();

        echo "<p><strong>Records Found:".$count."</strong></p>";

        $skip = 0;
        while($skip < $count)
        {
            $this->createFieldServicesAndData($skip);

            $skip += 1000;
            echo '<p><strong>Completed:'.$skip.' and starting the next 1000</strong></p>';
        }
    }

    /**
     * This method migrates the inventory data
     */

    public function migrateInventory()
    {
        $oldInventories = OldInventory::all();

        foreach( $oldInventories as $Inventory)
        {
            $this->createInventory($Inventory);
        }
    }

    /**
     * This method migrates the materials data
     */

    public function migrateMaterials()
    {
        $Materials = OldMaterial::all();
        foreach($Materials as $Material)
        {
            $this->createMaterial($Material);
        }
    }

    /**
     * This method migrates the Tax District Data
     */

    public function migrateTaxDistricts()
    {
        $oldTaxDistricts = OldTaxDistrict::all();

        foreach ($oldTaxDistricts as $oldTaxDistrict)
        {
            $this->createTaxDistrict($oldTaxDistrict);
        }
    }

    /**
     * This method migrates the Users Data
     */

    public function migrateUsers()
    {
        $oldUsers = OldUsers::all();

        $oldOfficeAccess = OldOfficeAccess::all();
        $aStates = State::all();
        $oldePerms = OldUserPerms::all();
        $allStates = [];

        foreach ($aStates as $as)
        {
            $allStates[$as->id] = $as->name;
            echo "<br>".$as->name;
        }

        foreach ($oldUsers as $ou)
        {
            $ExistingUser = User::where('email', '=', $ou->EMAIL)->first();

            if( !is_null( $ExistingUser ) )
            {
                continue;
            }

            $TempUser = $this->createTemporaryUser($ou);

            echo "list users".$TempUser->fname."-".$TempUser->oldId;

            $userPerms = $oldePerms->where('uid', $TempUser->oldId )->all();
            $userAccess = $oldOfficeAccess->where('user_id', $TempUser->oldId )->all();
            $userAccessCount = $oldOfficeAccess->where('user_id', $TempUser->oldId)->count();

            echo "count:".$userAccessCount;

            // set up new user

            $user = $this->createUser($TempUser);

            //set up office access

            $officeArray = [];

            foreach($userAccess as $ua)
            {
                $Office = Office::where('abvr', '=', $ua->office_id)->first();

                if( is_null( $Office ) )
                {
                    $officeId = 999;
                }
                else
                {
                    $officeId =$Office->id;
                }

                $officeArray[] = $officeId;
            }

            $user->offices()->attach( $officeArray );

            //set up user perms
            $permsArray = [];
            foreach($userPerms as $Perm)
            {
               $permsArray = $this->getUserPermissions($Perm, $TempUser);
            }

            $user->permissions()->attach( $permsArray );
        }
    }

    /**
     * This method migrates the Technician Data
     */

    public function migrateTechnicians()
    {
        $oldTech = OldTech::all();

        foreach($oldTech as $o)
        {
            if( is_null( $o ) ) {
                continue;
            }

            $Office = Office::where('abvr', $o->OFFICE)->select('id')->first();

            if( isset( $office->id ) && is_null( $Office->id ) )
            {
                dd($Office);
            }

            echo '<br>tech:'.$o->TECHCODE.'office:'.$o->OFFICE;

            $this->createTechnician($o, $Office);
        }
    }

    /***********************************************************************************
     * Private Class Functions
     ***********************************************************************************/

    /**
     * @param $name
     * @return string
     */

    private function fixName($name)
    {
        return ucwords(strtolower($name));
    }

    /**
     * @param $Data
     * @return Contact
     */

    private function createContact($Data)
    {
        $Contact = new Contact([
            'firstName' => $this->fixName($Data->LNAME),
            'title' => $this->fixName($Data->FNAME),
            'phone_work' => $Data->PHONE,
            'phone_cell' => $Data->MOBILE,
            'phone_fax' => $Data->FAX,
            'email' => $this->fixName($Data->EMAIL)
        ]);

        $Contact->save();

        return $Contact;
    }


    /**
     * @param $Data
     * @return Location
     */
    private function createLocation($Data)
    {
        $states = State::all();
        $state = $states->where('name', $this->fixName($Data->STATE))->first();

        $stateId = is_null($state) ? 999 : $state->id;

        $Location = new Location([
            'care_of' => $this->fixName($Data->CO),
            'address1' => $this->fixName($Data->ADDR1),
            'address2' => $this->fixName($Data->ADDR2),
            'city' => $this->fixName($Data->CITY),
            'state_id' => $stateId,
            'zipcode' => $Data->ZIP
        ]);

        $Location->save();

        return $Location;
    }

    /**
     * @param $Data
     * @return ActAccounting
     */

    private function createBudget($Data)
    {
        $Budget = new ActAccounting([
            'yearlyAmount' => $Data->YEARLYAMT,
            'billing' => $Data->BILLING,
            'budget' => $Data->BUDGET,
            'initialStart' => $Data->INITSTART,
            'initialBudget' => $Data->INITBUDGET
        ]);

        return $Budget;
    }

    /**
     * @param $Data
     * @return Note
     */

    private function createAccountNotes($Data)
    {
        $ActNotes = new Note([
            'notes' => $Data->NOTES,
            'combine' => ($Data->STATUS_COMBINE != ''? $Data->STATUS_COMBINE : null),
            'otherType' => $this->fixName($Data->SITE),
            'notes_phone' => $Data->NOTEPHONE,
            'notes_contact' => $this->fixName($Data->CONTACT),
            'notes_email' => $this->fixName($Data->URL)
        ]);

        return $ActNotes;
    }

    /**
     * @param $Data
     * @return ActInfo
     */

    private function createAccountInfo($Data)
    {
        $ActInfo = new ActInfo([
            'date_since' => date('Y-m-d', strtotime($Data->TIMESTAMP)),
            'date_begin' => date('Y-m-d', strtotime($Data->BEGDATE)),
            'date_end' => date('Y-m-d', strtotime($Data->EXPDATE)),
            'po_number' => $Data->PONUM,
            'permit' => $Data->PERMIT,
            'permit_expire' => date('Y-m-d', strtotime($Data->PERMITEXP)),
        ]);

        return $ActInfo;
    }

    /**
     * @param $Data
     * @return ActTax
     */

    private function createAccountTaxDistrict($Data)
    {
        $taxDistrictId = taxDistrict::where('old_id', $Data->DISTRICT)->first();

        if(!is_null($taxDistrictId)) {
            $stateCode = $taxDistrictId->state_id;
            $taxDistrictId = $taxDistrictId->id;
        } else {
            $stateCode = null;
        }

        $ActTax = new ActTax([
            'taxState' => $stateCode,
            'taxDistrict' => $taxDistrictId,
            'exemptNumber' => $Data->EXEMPT,

        ]);

        return $ActTax;
    }

    /**
     * @param $Data
     * @return ActSalesman
     */

    private function createAccountSalesman($Data)
    {
        $SalesPeople = Salesman::all();

        $AccountSalesmanId = $SalesPeople->where('abvr', $Data->SALESMAN)->first();
        $AccountSalesmanId = is_null($AccountSalesmanId) ? null : $AccountSalesmanId->id;


        $Salesmen = new ActSalesman([
            'salesmen_id' => $AccountSalesmanId
        ]);

        return $Salesmen;
    }

    /**
     * @param $Data
     * @return ActTerm
     */

    private function createAccountTerms($Data)
    {
        $oldTerms = strtolower($Data->PTERMS);
        if( $oldTerms == 'net 10 day')
        {
            $oldTerms .= 's';
        }
        else if( $oldTerms == 'c.o.d. cashiers ck')
        {
            $oldTerms .= '.';
        }

        $Term = Term::whereRaw('lower(name) = ?', [$oldTerms])->first();

        if( is_null( $Term ) )
        {
            $termsId = 999;
        }
        else
        {
            $termsId = $Term->id;
        }

        $Terms = new ActTerm([
            'term_id' => $termsId
        ]);

        return $Terms;
    }

    /**
     * @param $Data
     * @return ActStatus
     */

    private function createAccountStatus($Data)
    {
        $ActStatus = new ActStatus([
            'status_id' => $this->getStatusId($Data),
            'act_freq' => $this->getFrequency($Data),
            'act_other' => $this->fixName($Data->TYPE_OTHER),
            'status_date' => date('Y-m-d', strtotime($Data->STATUS_DATE))
        ]);

        return $ActStatus;
    }

    /**
     * @param $Data
     * @param $Location
     * @param $Contact
     * @return Account
     */

    private function createAccount($Data, $Location, $Contact)
    {
        $Account = Account::create([
            'accountNumber' => $Data->ACCTNUM,
            'actName' => $this->fixName($Data->ACCTNAME),
            'location_id' => $Location->id,
            'contact_id' => $Contact->id
        ]);

        return $Account;
    }

    /**
     * @param $oldAccount
     */

    public function createAccountAndRelations($oldAccount)
    {
        $Contact = $this->createContact($oldAccount);

        $Location = $this->createLocation($oldAccount);

        $Budget = $this->createBudget($oldAccount);

        $AccountNotes = $this->createAccountNotes($oldAccount);

        $AccountInfo = $this->createAccountInfo($oldAccount);

        $AccountTaxDistrict = $this->createAccountTaxDistrict($oldAccount);

        $AccountSalesman = $this->createAccountSalesman($oldAccount);

        $AccountTerms = $this->createAccountTerms($oldAccount);


        $AccountStatus =$this->createAccountStatus($oldAccount);

        $AccountOffice = $this->createAccountOffice($oldAccount);

        $AccountType = $this->createAccountType($oldAccount);


        $Account = $this->createAccount($oldAccount, $Contact, $Location);

        $Account->accounting()->save($Budget);
        $Account->note()->save($AccountNotes);
        $Account->actInfo()->save($AccountInfo);
        $Account->actTax()->save($AccountTaxDistrict);
        $Account->salesmen()->save($AccountSalesman);
        $Account->actTerms()->save($AccountTerms);
        $Account->actStatus()->save($AccountStatus);
        $Account->actType()->save($AccountType);

        if(!is_null($AccountOffice))
        {
            $Account->office()->save($AccountOffice);
        }

        $services = explode(',', $oldAccount->SERVICES);

        foreach($services as $service)
        {

            if($service != "")
            {
                $Account->actService()->attach($this->getServiceType($service));
            }
        }
    }

    /**
     * @param $Data
     * @return int|mixed
     */

    private function getStatusId($Data)
    {
        $statuses = Status::all();
        $statusId = $statuses->where('code', $Data->STATUS)->first();

        $statusId = is_null($statusId) ? 1 : $statusId->id;

        return $statusId;
    }

    /**
     * @param $Data
     * @return ActOffice|null
     */

    private function createAccountOffice($Data)
    {
        $offices = Office::all();

        $officeId = $offices->where('abvr', $Data->OFFICE)->first();

        if(!is_null($officeId))
        {
            $officeId = $officeId->id;
            $ActOffice = new ActOffice( [ 'office_id' => $officeId ]);
        }
        else {
            $ActOffice = null;
        }

        return $ActOffice;
    }

    /**
     * @param $Data
     * @return ActType
     */

    private function createAccountType($Data)
    {
        $ActType = new ActType([
            'types_id' => $this->getAccountTypeId($Data),
            'automatic' => $Data->nonautomatic,
            'commission' => $Data->NONCOMMISSION
        ]);

        return $ActType;
    }


    /**
     * @param $Account
     * @param $Data
     * @return FieldService
     */

    private function createFieldService($Account, $Data)
    {
        $now = Carbon::now();

        $technician = Technician::where('code', strtoupper($Data->TECHCODE))->first();

        $technicianId = is_null($technician) ? null : $technician->id;

        $Field = new FieldService([
            'account_id'  => $Account->id,
            'tech_id' => $technicianId,
            'hours' => $Data->MANHOURS,
            'notes' => $Data->Notes,
            'service_date' => $Data->ACCTDATE,
            'old_number' => $Data->ACCTNUM,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $Field->save();

        return $Field;
    }

    /**
     * This method migrates the Field Services and Field Data
     * @param $skip
     */

    private function createFieldServicesAndData($skip)
    {
        $OldFieldRows = OldField::where('ACCTDATE', '>', '2013-12-31 00:00:00')->orderBy('ACCTNUM', 'DESC')->skip($skip)->take(1000)->get();

        foreach($OldFieldRows as $OldFieldData)
        {
            $Account = Account::where('accountNumber', $OldFieldData->ACCTNUM)->first();

            if(!is_null($Account))
            {
                $Field =$this->createFieldService($Account, $OldFieldData);

                foreach($OldFieldData->datas as $Data)
                {
                    $this->createFieldData($Data, $Field);
                }
            }
        }
    }


    /**
     * @param $Data
     * @param $Field
     */

    private function createFieldData($Data, $Field)
    {
        $Material = Material::where('code', $Data->MAT)->first();

        if(!is_null($Material))
        {
            $oldNumber = 999;

            if( !is_null( $Data->ACCTNUM ) )
            {
                $oldNumber = $Data->ACCTNUM;
            }

            $FieldData = new FieldData( [
                'material_id' => $Material->id,
                'quantity'=> $Data->QUANT,
                'old_number'=> $oldNumber,
                'field_service_id' => $Field->id
            ]);

            $FieldData->save();
        }
    }

    /**
     * @param $Data
     */

    function createInventory($Data)
    {
        $Office = Office::where('abvr', $Data->OFFICE)->first();

        if(!isset($Office->id))
        {
            dd('Dead Office Id', $Office, $Data);
        }

        if($Data->MAT == "ALG1")
        {
            $Data->MAT = 'ALG7';
        }

        if($Data->MAT == "AQ-SK")
        {
            $Data->MAT = 'AQSK';
        }

        if($Data->MAT == "AQCLR")
        {
            $Data->MAT = 'AQCL';
        }

        if($Data->MAT == "GREEN CLEAN PRO 50#")
        {
            $Data->MAT = 'GRCL';
        }

        if($Data->MAT == 'GREEN CLEAN LIQ')
        {
            $Data->Mat = 'GCLN';
        }


        $Material = Material::where('code', $Data->MAT)->first();

        if(!isset($matId->id))
        {
            //dd('dead mat', $matId, 'something else ', $Data->MAT, ' material O ', $Data);

            $matId = 999;
        }
        else
        {
            $matId = $Material->id;
        }

        $Inventory = new Invantory([
            'office_id' => $Office->id,
            'mat_id' => $matId,
            'begin_amount' => $Data->BEGINV,
            'end_amount' => $Data->ENDINV,
            'trans' => $Data->TRANS,
            'purchased_amount' => $Data->PURCHMO,
            'month' => date('Y-m-d',strtotime($Data->MONTH)),
            'cost' => $Data->COST
        ]);

        $Inventory->save();
    }

    /**
     * @param $Data
     */

    private function createMaterial($Data)
    {
        $Material = new Material([
            'code' => $Data->CODE ,
            'name' => $Data->NAME ,
            'primary' => $Data->PRIMARY ,
            'secondary' => $Data->SECONDARY ,
            'units' => $Data->UNITS ,
            'cost' => $Data->COST,
            'created_at' => date('Y-md H:i:s', strtotime($Data->DATE)),
            'updated_at' => date('Y-md H:i:s', strtotime($Data->DATE))
        ]);

        $Material->save();
    }

    /**
     * @param $Data
     */

    private function createTaxDistrict($Data)
    {
        $stateId = State::where('name', $Data->state)->first()->id;

        TaxDistrict::create([
            'name' => $Data->name,
            'id_code' => ( $Data->idcode < 10 ? '0'.$Data->idcode : $Data->idcode ),
            'percent' => $Data->percent,
            'state_id' => $stateId,
            'old_id' => $Data->id
        ]);
    }

    /**
     * @param $Data
     * @return User
     */

    private function createUser($Data)
    {
        $User = new User([
            'first_name' => $this->fixName( $Data->fname ),
            'middle_name' => $this->fixName( $Data->mname ),
            'last_name' => $this->fixName( $Data->lname ),
            'email' => $Data->email,
            'is_super_admin' => $Data->superAdmin,
            'level' => $Data->userLevel,
            'password' => 'WeLoveSantoDesignGroup'
        ]);

        $User->save();

        return $User;
    }

    /**
     * @param $Data
     * @return \stdClass
     */

    private function createTemporaryUser($Data)
    {
        $TempUser = new \stdClass();
        $TempUser->oldId = $Data->ID;
        $TempUser->email = $Data->EMAIL;
        $TempUser->fname = $Data->FNAME;
        $TempUser->mname = $Data->MNAME;
        $TempUser->lname = $Data->LNAME;
        $TempUser->city  = $Data->CITY;
        $TempUser->state = $Data->STATE;

        if ($Data->superadmin == 1)
        {
            $TempUser->userLevel = 1;
        }
        else
        {
            if ($Data->LEVEL == 1)
            {
                $TempUser->userLevel = 2;
            }
            else
            {
                $TempUser->userLevel = $Data->LEVEL;
            }
        }

        $TempUser->superAdmin = $Data->superadmin;

        return $TempUser;
    }

    /**
     * @param $Data
     * @param $Office
     */

    private function createTechnician($Data, $Office)
    {
        $Technician = new Technician([
            'code' => $Data->TECHCODE ,
            'name' => $Data->NAME ,
            'office' => $Office->id,
            'rate' => $Data->RATE ,
            'active' => $Data->ACTIVE
        ]);

        $Technician->save();
    }

    /**
     * @param $Data
     * @param $TempUser
     * @return array
     */

    private function getUserPermissions($Data, $TempUser)
    {
        $ids = [];

        if($Data->act_cre == 1)
        {
            $ids[] = 14;
        }

        if($Data->act_mod == 1)
        {
            $ids[] = 15;
        }

        if($Data->act_del == 1)
        {
            $ids[] = 17;
        }

        if($Data->act_view == 1)
        {
            $ids[] = 16;
        }

        if($Data->rep_over == 1)
        {
            $ids[] = 18;
        }

        if($Data->rep_view == 1)
        {
            $ids[] = 19;
        }

        if($Data->field_over == 1)
        {
            $ids[] = 21;
        }

        if($Data->field_input == 1)
        {
            $ids[] = 22;
        }

        if($Data->field_view == 1)
        {
            $ids[] = 23;
        }

        if($TempUser->userLevel == 1)
        {
            $ids[] = 27;
        }

        return $ids;
    }

    /**
     * @param $Data
     * @return int
     */

    private function getAccountTypeId($Data)
    {
        switch ($Data->ACCTTYPE) {

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

        return $type;
    }

    /**
     * @param $service
     * @return int
     */

    private function getServiceType($service)
    {
        $serviceType = 0;

        switch( $service ){
            case '18':
                //
                $serviceType = 1;
                break;
            case '19':
                //
                $serviceType = 2;
                break;
            case '21':
                //
                $serviceType = 3;
                break;
            case '9':
                //
                $serviceType = 14;
                break;
            case '10':
                //
                $serviceType = 15;
                break;
            case '11':
                //
                $serviceType = 16;
                break;
            case '6':
                //
                $serviceType = 4;
                break;
            case '15':
                //
                $serviceType = 17;
                break;
            case '2':
                //
                $serviceType = 7;
                break;
            case '12':
                //
                $serviceType = 18;
                break;
            case '3':
                //
                $serviceType = 8;
                break;
            case '13':
                //
                $serviceType = 19;
                break;
            case '4':
                //
                $serviceType = 9;
                break;
            case '20':
                //
                $serviceType = 20;
                break;
            case '17':
                //
                $serviceType = 10;
                break;
            case '8':
                //
                $serviceType = 21;
                break;
            case '5':
                //
                $serviceType = 11;
                break;
            case '23':
                //
                $serviceType = 22;
                break;
            case '14':
                //
                $serviceType = 12;
                break;
            case '7':
                //
                $serviceType = 23;
                break;
            case '1':
                //
                $serviceType = 13;
                break;
        }

        return $serviceType;
    }

    /**
     * @param $Data
     * @return int
     */

    private function getFrequency($Data)
    {
        switch ($Data->CLIPTYPE) {
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
                $statusFreq = 0;
        }

        return $statusFreq;
    }
}
