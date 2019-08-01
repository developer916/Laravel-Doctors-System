<?php

	namespace App\Http\Controllers;

	use App\ActSalesman;
	use App\Helpers\PhoneNumberHelper;
	use App\Technician;
	use Crypt;
	use App\Contact;
	use App\Http\Requests;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;

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
	use App\Note;
	use App\Location;
	use App\Salesman;
	use App\Office;
	use App\Term;
	use App\Type;
	use App\TaxDistrict;

	class AccountsController extends Controller
	{

		public function __construct()
		{
			$my_id = \Auth::user()->id;
			$me = \App\User::where('id', $my_id)->with('permissions')->first();
			$me['sa'] = $me->is_super_admin;
//		dd($me);
			$this->perms = [];
			foreach ($me->permissions as $p) {
				$this->perms[ $p->id ] = true;
			}
			$this->perms['sa'] = ($me->is_super_admin ? true : false);
		}

		/**
		 * Display a listing of the resource.
		 *
		 * @return Response
		 */
		public function index()
		{
			//
			$data['me'] = $this->perms;

			return view('account.account', $data)
				->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
		}

		public function global_exp(Request $request)
		{
			//user supplied date
			$dateIn = $request->input('date');
			//temp for account ids from date
			$account_ids = [];
			//temp for account ids from office
			$act_office_ids = [];
			//check var for correct date type entered
			$checkDate = strpos($dateIn, '/');
			//return bool for bad date error
			$badDate = false;
			//all offices for code and name
			$offices = \App\Office::all();
			$offices_ids = [];
			foreach ($offices as $off) {
				$offices_ids[] = $off->id;
			}
			//all salesmen for abvr and name
			$salesmen = \App\Salesman::all();
			$salesmen_ids = [];
			foreach ($salesmen as $sm) {
				$salesmen_ids[] = $sm->id;
			}
            
			//Temp acct var
			$temp = [];
			//hack for salesmen sort
			$temp2 = [];

			//validate
			if ($checkDate > -1) {
				$splode = explode('/', $dateIn);
				if (count($splode) < 3) {
					$badDate = true;
				} else {
					if (!checkdate($splode[0], $splode[1], $splode[2])) {
						$badDate = true;
					}
				}
			} else {
				$badDate = true;
			}
			if ($badDate) {
				return ['status' => 'bad date'];
			}

			//get accounts based on dates
			$date = strtotime($splode[2] . '-' . $splode[0] . '-' . $splode[1]);
			$account_info = \App\ActInfo::where('date_end', date('Y-m-d', $date))->get();
			foreach ($account_info as $ai) {
				$account_ids[] = $ai->id;
				$account_sids[] = $ai->id;
			}
			unset($account_info);
            
            //user supplied salesman
            if ($request->input('sales') != 'default') {
				$actSales = \App\ActSalesman::where('salesmen_id', $request->input('sales'))->whereIn('account_id', $account_sids)->get();
			}
            if (isset($actSales) && count($actSales) > 0) {
				foreach ($actSales as $as) {
					$act_sales_ids[] = $as->account_id;
				}
				$act_sids = array_intersect($account_sids, $act_sales_ids);
			} else {
				$act_sids = $account_sids;
			}
			unset($actSales, $act_sales_ids, $account_sids);

			//get accounts based on offices
			if ($request->input('office') != 'default') {
				$actOffices = \App\ActOffice::where('office_id', $request->input('office'))->whereIn('account_id', $account_ids)->get();
			}
			if (isset($actOffices) && count($actOffices) > 0) {
				foreach ($actOffices as $ao) {
					$act_office_ids[] = $ao->account_id;
				}
				$act_ids = array_intersect($account_ids, $act_office_ids);
			} else {
				$act_ids = $account_ids;
			}
			unset($actOffices, $act_office_ids, $account_ids);
            
			$accounts = \App\Account::with('actInfo')
				->with('accounting')
				->whereHas('actType', function ($q) {
					$q->where('automatic', 0);
				})
				->with('salesmen')
                ->whereIn('id', $act_sids)
				->with('office')
				->with('actStatus')
//				->whereNotIn('code',['CE','OH','EX','NP','OH'])
//				->where('substring(code,1,1)','<>','C')
				->whereIn('id', $act_ids)
				->orderBy('actName','ASC')
				->chunk(100, function ($account) use (&$temp, &$temp2, $salesmen, $offices, $salesmen_ids, $offices_ids) {
					foreach ($account as $act) {
						if ($act->actStatus->status_id != 0 && $act->actStatus->status_id != 1 ) {continue;} ;
						$tmp = new \stdClass();
						$tmp->id = $act->id;
						$tmp->actNum = $act->accountNumber;
						$tmp->actName = $act->actName;
						$tmp->actBegin = date("m/d/Y", strtotime(date("m/d/Y", strtotime($act->actInfo->date_begin)) . " + 365 day"));
						$tmp->actEnd = date("m/d/Y", strtotime(date("m/d/Y", strtotime($act->actInfo->date_end)) . " + 365 day"));
						$tmp->actAnnual = $act->accounting->yearlyAmount;
						$tmp->actBilling = $act->accounting->billing;
						$tmp->actBudget = $act->accounting->budget;
                        $tmp->actType = ($act->actType->commission == 0 ? "" : "NC");
                        
						if (isset($act->salesmen) && isset($act->salesmen->salesmen_id) && in_array($act->salesmen->salesmen_id, $salesmen_ids)) {
							$tmp->salesman = $salesmen->find($act->salesmen->salesmen_id)->abvr;
						} else {
							$tmp->salesman = 'Orphan';
						}
                        
						if (isset($act->office) && isset($act->office->office_id) && in_array($act->office->office_id, $offices_ids)) {
							$tmp->actOffice = $offices->find($act->office->office_id)->abvr;
						} else {
							$tmp->actOffice = 'Orphan';
						}
						$temp[ $tmp->actNum ] = $tmp;
						$temp2[] = $tmp;
					}
				});
            usort($temp, function ($a, $b) {
				if ($a->actName === $b->actName) {
					return 0;
				}
				return ($a->actName < $b->actName) ? -1 : 1;
			});
			usort($temp2, function ($a, $b) {
				if ($a->actName === $b->actName) {
					return 0;
				}
				return ($a->actName < $b->actName) ? -1 : 1;
			});
			unset($act_ids);
			if (count($temp) < 1) {
				return ['status' => 'no data'];
			}

			return ['status' => 'good', 'accounts' => $temp, 'accounts2' => $temp2, 'count' => count($temp)];
		}

		public function global_exp_update(Request $request){
			$data = $request->input('data');
			$data['date_begin'] = date('Y-m-d', strtotime($data['date_begin']));
			$data['date_end'] = date('Y-m-d', strtotime($data['date_end']));
			$act = \App\Account::with('actInfo')->with('accounting')->find($data['id']);
			$act->actInfo->update(	$data );
			$act->actInfo->save();
			$act->accounting->update($data);
			$act->accounting->save();
			return ['status' => 'good'];
		}

		public function getAccount($id){
            $return['act'] = Account::where('accountNumber', $id)->firstOrFail();
			$ls = \App\FieldService::where('account_id', $return['act']->accountNumber)->orderBy('service_date', 'desc')->first();
            $combineAcct = \App\Note::where('account_id', $return['act']->id)->pluck('combine');
            
			// (isset($combineAcct) ? $combineAcct : '')
			if (empty($ls)) {
				$act1 = \App\Account::where('accountNumber', $id)->select('id')->first()->id;
				$ls = \App\FieldService::where('account_id', $act1)->orderby('service_date', 'DESC')->first();
	
			}

			if (isset($ls) && isset($ls->service_date)) {
				$return['lastService'] = date('m/d/Y', strtotime($ls->service_date));
			} else {
				$return['lastService'] = 'No Service on File';
			}
			$return['status'] = Account::find($return['act']->id)->actStatus;
			$statusName = Status::findOrFail($return['status']->status_id);
			$return['statBool'] = $this->isAccountActive($return['status']->status_id);

			$return['status']->statusName = $statusName['code'];

			if( array_key_exists( 'name', $statusName ) )
			{
				$return[ 'status' ]->statusName .= '&nbsp;&mdash;&nbsp;' . $statusName['name'] . $combineAcct;
			}

			$return['info'] = Account::find($return['act']->id)->actInfo;
			$return['accounting'] = Account::find($return['act']->id)->accounting;
			$return['location'] = Location::find($return['act']->location_id);
			$stateName = State::select('name')->findOrFail($return['location']->state_id);
			$return['location']->state = $stateName['name'];
			$return['contact'] = Contact::find($return['act']->contact_id);
			$return['wide'] = true;
			$return['bc'] = 'Account View ' . $return['act']->accountNumber;
			$return['me'] = $this->perms;
			$return['offices'] = \App\Office::orderBy('officeName', 'ASC')->get();
			$return['tech'] = \App\Technician::orderBy('code', 'ASC')->get();

//luiz add
			$return['salesman'] = \App\Salesman::orderBy('abvr', 'ASC')->get();


			return view('account.account', $return)
				->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
		}

		public function isAccountActive($iStatusId)
		{
			if( $iStatusId == 0 || $iStatusId == 1 )
			{
				return true;
			}	

			return false;
		}

		public function editAccount($id)
		{

			//Bad name but holds menu away from edit screens.
			$return['addAccount'] = false;
			/*
			 * DO THIS Product::with( 'urls','prices' )->where('user_id', '=', $id)->get(); Its in the With
			 */

			$return['act'] = Account::where('accountNumber', $id)->with('actService')->first();
			$return['services'] = [];
			foreach ($return['act']->actService as $as) {
				$return['services'][ $as->id ] = true;
			}
			if (!isset($return['act']->id)) {
				return response()->view('errors.' . '404');
			}
			$return['actstatus'] = Account::find($return['act']->id)->actStatus;
//        $return['actstatus']->statusDate = $this->fixDate($return['actstatus']->statusDate);
			$return['actType'] = Account::find($return['act']->id)->actType;
			$return['actOffice'] = Account::find($return['act']->id)->office;
			$return['actSalesmen'] = Account::find($return['act']->id)->salesmen;
			$return['actNote'] = Account::find($return['act']->id)->note;
			$statusName = Status::where('id', $return['actstatus']->status_id)->firstOrFail();
			$return['actstatus']->statusName = $statusName['code'] . '&nbsp;&mdash;&nbsp;' . $statusName['name'];
			$return['info'] = Account::find($return['act']->id)->actInfo;
//        dd($return['info']);
//        $return['info']->permit_expire = $this->fixDate( $return['info']->permit_expire );
			$return['accounting'] = Account::find($return['act']->id)->accounting;
			$return['location'] = Location::find($return['act']->location_id);
			$stateName = State::where('id', $return['location']->state_id)->select('name')->firstOrFail();
			$return['location']->state = $stateName['name'];
       
			$return['actTax'] = Account::find($return['act']->id)->actTax;
			$return['actTerm'] = Account::find($return['act']->id)->actTerms;
			$return['contact'] = Contact::find($return['act']->contact_id);
			$return['states'] = State::all(['id', 'abvr', 'name']);
			$return['office'] = Office::orderBy('officeName', 'ASC')->get();
			$return['salesman'] = Salesman::all(['id', 'abvr', 'name']);
			$return['terms'] = Term::all();
			$return['offices'] = \App\Office::orderBy('officeName', 'ASC')->orderBy('officeName', 'ASC')->get();
			$return['tech'] = \App\Technician::orderBy('code', 'ASC')->get();

			// Trent Raber
			// Dragonfly Research Group
			// 2018-03-21
			// Moved the status logic into a method
			$return['status'] = $this->buildStatusOptions();

			//TODO: Fix this with config from Utilities...?...?...?
			$stateSeeds = [1, 10, 11, 18, 36, 34, 42];
//        $stateId = TaxDistrict::select('state_id')->distinct()->get();
			$return ['taxDistricts'] = TaxDistrict::where('state_id', $return['actTax']->taxState)->orderBy('id_code', 'ASC')->get();
//        foreach ($stateId as $s) {
//            array_push($stateSeeds, $s['state_id']);
//        }
			$return['taxStates'] = [];
			$stateNames = State::select('id', 'name')->whereIn('id', $stateSeeds)->get();
			foreach ($stateNames as $sn) {
				$return['taxStates'][ $sn['id'] ] = $sn['name'];
			}

			$return['status']['types'] = Type::select('id', 'name')->get();
			$return['status']['fbm'] = config('lookup_act_status.fq-bm');
			$return['status']['fqt'] = config('lookup_act_status.fq-qt');
			$return['bc'] = 'Account Edit';
			$return['wide'] = true;
            
            $return['phone_work']     = PhoneNumberHelper::getNumber($return['contact']->phone_work);
            $return['phone_work'] = $return['contact']->phone_work;
//            dd($return['phone_work']);
            $return['phone_work_ext'] = PhoneNumberHelper::getExtension($return['contact']->phone_work);


			return view('account.edit', $return)
				->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
		}

		public function addAccount()
		{
			$return['addAccount'] = true;
			$return['states'] = State::orderBy('abvr', 'ASC')->select(['id', 'abvr', 'name'])->get();
			$return['office'] = Office::orderBy('abvr', 'ASC')->select(['id', 'abvr', 'officeName'])->get();
			$return['offices'] = Office::orderBy('abvr', 'ASC')->select(['id', 'abvr', 'officeName'])->get();
			$return['tech'] = Technician::all();
			$return['salesman'] = Salesman::orderBy('abvr', 'ASC')->select(['id', 'abvr', 'name'])->get();
			$return['terms'] = Term::all();

			// Trent Raber
			// Dragonfly Research Group
			// 2018-03-21
			// Moved the status logic into a method
			$return['status'] = $this->buildStatusOptions();

			$return['status']['types'] = Type::select('id', 'name')->get();
			$return['status']['fbm'] = config('lookup_act_status.fq-bm');
			$return['status']['fqt'] = config('lookup_act_status.fq-qt');
			$return['bc'] = 'Add Account';

			$stateSeeds = [1, 10, 11, 18, 36, 34, 42];
			$stateId = TaxDistrict::select('state_id')->distinct()->get();
//		dd($stateId);
			//TODO: Fix this with some selections on Utilitys Panel or something
//        foreach ($stateId as $s) {
//            array_push($stateSeeds, $s['state_id']);
//        }
			$return['taxStates'] = [];
			$stateNames = State::select('id', 'name')->whereIn('id', $stateSeeds)->get();
			foreach ($stateNames as $sn) {
				$return['taxStates'][ $sn['id'] ] = $sn['name'];
			}

			return view('account.add', $return)
				->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
		}

		/**
		 * Builds the status options for the drop down
		 *
		 * @return String
		 */
		public function buildStatusOptions()
		{
			$data = [];
			$data['status'] = [];

			foreach (Status::orderBy('code', 'ASC')->get() as $s)
			{
				if(  $s['id'] == 0 )
				{
					continue;
				}

				$data['status'][ $s['id'] ] = $s['code'];
				if( $s['name'] != '' ) 
				{
					$data['status'][ $s['id'] ] .= ' &mdash; ' . $s['name'];
				}	
			}

			return $data;
		}

		/**
		 * Show the form for creating a new resource.
		 *
		 * @return Response
		 */
		public function create()
		{
			//
			$ipt = \Input::all();
			unset($ipt['_token']);
			//location
			$location = new Location([
				'care_of'  => $ipt['co'],
				'address1' => $ipt['address_1'],
				'address2' => $ipt['address_2'],
				'address3' => $ipt['address_3'],
				'city'     => $ipt['city'],
				'state_id' => $ipt['state'],
				'zipcode'  => $ipt['zip']
			]);
			$location->save();
			unset($ipt['co']);
			unset($ipt['address_1']);
			unset($ipt['address_2']);
			unset($ipt['address_3']);
			unset($ipt['city']);
			unset($ipt['state']);
			unset($ipt['zip']);

			$ipt['contact_phone'] = $this->stripPhone($ipt['contact_phone']);
			$ipt['contact_fax'] = $this->stripPhone($ipt['contact_fax']);
			$ipt['contact_mobile'] = $this->stripPhone($ipt['contact_mobile']);
			$ipt['notes_sec_phone'] = $this->stripPhone($ipt['notes_sec_phone']);

			//contact
			$contact = new Contact([
				'firstName'  => $ipt['contact_name'], //FIX ME
				'title'      => $ipt['contact_title'],
				'phone_work' => $ipt['contact_phone'],
				'phone_fax'  => $ipt['contact_fax'],
				'phone_cell' => $ipt['contact_mobile'],
				'email'      => $ipt['contact_email']
			]);
			$contact->save();
			unset($ipt['contact_name']);
			unset($ipt['contact_title']);
			unset($ipt['contact_phone']);
			unset($ipt['contact_fax']);
			unset($ipt['contact_mobile']);
			unset($ipt['contact_email']);

			//budget
			$budget = new ActAccounting([
				'yearlyAmount'  => $ipt['budget_contract'],
				'billing'       => $ipt['budget_billing'],
				'budget'        => $ipt['budget_budge'],
				'initialStart'  => $ipt['budget_start'],
				'initialBudget' => $ipt['budget_init']
			]);
			unset($ipt['budget_contract']);
			unset($ipt['budget_billing']);
			unset($ipt['budget_budge']);
			unset($ipt['budget_start']);
			unset($ipt['budget_init']);

			$actOffice = new ActOffice(['office_id' => $ipt['office_office']]);
			unset($ipt['office_office']);

            // TODO: Grab from notes
			$actNotes = new Note([
				'notes'         => $ipt['notes_note'],
				'combine'       => (isset($ipt['combine_with']) && $ipt['combine_with'] != '' ? $ipt['combine_with'] : null),
				'otherType'     => $ipt['notes_site_add'],
				'notes_phone'   => $ipt['notes_sec_phone'],
				'notes_contact' => $ipt['notes_contact'],
				'notes_email'   => $ipt['notes_email'],
			]);
			unset($ipt['notes_note']);
			unset($ipt['notes_site_add']);
			unset($ipt['notes_sec_phone']);
			unset($ipt['notes_contact']);
			unset($ipt['notes_email']);
			$actInfo = new ActInfo([
				'date_since'    => date('Y-m-d', strtotime($ipt['date_since'])),
				'date_begin'    => date('Y-m-d', strtotime($ipt['date_begin'])),
				'date_end'      => date('Y-m-d', strtotime($ipt['date_end'])),
				'po_number'     => $ipt['salesman_po'],
				'permit'        => $ipt['notes_permit'],
				'permit_expire' => date('Y-m-d', strtotime($ipt['notes_expire'])),
			]);
			unset($ipt['date_since']);
			unset($ipt['date_begin']);
			unset($ipt['date_end']);
			unset($ipt['notes_permit']);
			unset($ipt['notes_expire']);
			unset($ipt['salesman_po']);


			$actTax = new ActTax([
				'taxState'     => $ipt['taxstate'],
				'taxDistrict'  => $ipt['dist'],
				'exemptNumber' => $ipt['salesman_exempt'],
			]);
			unset($ipt['taxstate']);
			unset($ipt['dist']);
			unset($ipt['salesman_exempt']);
			$salesman = new ActSalesman([
				'salesmen_id' => $ipt['salesman_salesman']
			]);
			unset($ipt['salesman_salesman']);

			$terms = new ActTerm([
				'term_id' => $ipt['budget_terms']
			]);
			unset($ipt['budget_terms']);

			$actStatus = new ActStatus([
				'status_id'   => $ipt['act_status'],
				'act_freq'    => $ipt['status_freq'],
				'act_other'   => $ipt['status_other'],
				'status_date' => date('Y-m-d', strtotime($ipt['status_date']))
			]);
//        unset($ipt['act_status']);
			unset($ipt['status_freq']);
			unset($ipt['status_other']);
			unset($ipt['status_date']);
			$automatic = (isset($ipt['note_auto']) ? 1 : 0);
			$commission = (isset($ipt['note_comm']) ? 1 : 0);
			$actType = new ActType([
				'types_id'   => $ipt['status_type'],
				'automatic'  => $automatic,
				'commission' => $commission
			]);
			unset($ipt['note_auto']);
			unset($ipt['note_comm']);
//        unset($ipt['status_type']);

			$user = new Account();

			$user->actName = $ipt['company_name'];
			$user->location_id = $location->id;
			$user->contact_id = $contact->id;
			unset($ipt['company_name']);


			//no chance for race, grab and save
			$maxId = Account::withTrashed()->max('accountNumber');
			$user->accountNumber = ++$maxId;
			$user->save();

			$user->accounting()->save($budget);
			$user->note()->save($actNotes);
			$user->office()->save($actOffice);
			$user->actTax()->save($actTax);
			$user->salesmen()->save($salesman);
			$user->actTerms()->save($terms);
			$user->actStatus()->save($actStatus);
			$user->actInfo()->save($actInfo);
			$user->actType()->save($actType);

			if (isset($ipt['act_services'])) {
				$user->actService()->attach($ipt['act_services']);
			}

			$userId = $user->accountNumber;

			return \Redirect::route('account', ['id' => $userId]);
		}

		/**
		 * Store a newly created resource in storage.
		 *
		 * @return Response
		 */
		public function store()
		{
			//
		}

		/**
		 * Display the specified resource.
		 *
		 * @param  int $id
		 *
		 * @return Response
		 */
		public function show($id = null)
		{
			//
			$allAct['act'] = Account::where('id', '=', 1)->get();
			$allAct['roe'] = Account::find(1)->actStatus;
			$allAct['id'] = $allAct['act'][0]->actName;
			dd($allAct);
		}

		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param  int $id
		 *
		 * @return Response
		 */
		public function edit($id)
		{
			//
			$ipt = \Input::all();
//        dd($ipt);
			$act = Account::with('actInfo')
				->with('accounting')
				->with('actTerms')
				->with('actStatus')
				->with('actType')
				->with('office')
				->with('actTax')
				->with('salesmen')
				->with('note')
				->find($id);
			$act->update(['actName' => $ipt['company_name']]);

			$actId = $act->accountNumber;
			$location = Location::find($act->location_id);
			$contact = Contact::find($act->contact_id);

			$actInfo = [
				'permit'        => $ipt['notes_permit'],
				'date_since'    => date('Y-m-d', strtotime($ipt['date_since'])),
				'date_begin'    => date('Y-m-d', strtotime($ipt['date_begin'])),
				'date_end'      => date('Y-m-d', strtotime($ipt['date_end'])),
				'permit_expire' => date('Y-m-d', strtotime($ipt['notes_expire'])),
				'po_number'     => $ipt['salesman_po'],
			];
			$act->actInfo->update($actInfo);
			$locationChange = [
				'care_of'  => $ipt['co'],
				'address1' => $ipt['address_1'],
				'address2' => $ipt['address_2'],
				'address3' => $ipt['address_3'],
				'city'     => $ipt['city'],
				'state_id' => $ipt['state'],
				'zipcode'  => $ipt['zip'],
			];
			$location->update($locationChange);

			$ipt['contact_phone'] = $this->stripPhone($ipt['contact_phone']);
			$ipt['contact_fax'] = $this->stripPhone($ipt['contact_fax']);
			$ipt['contact_mobile'] = $this->stripPhone($ipt['contact_mobile']);
			$ipt['notes_sec_phone'] = $this->stripPhone($ipt['notes_sec_phone']);
			$contactChange = [
				'firstName'  => $ipt['contact_name'],
				'title'      => $ipt['contact_title'],
				'phone_work' => $ipt['contact_phone'],
				'phone_cell' => $ipt['contact_mobile'],
				'phone_fax'  => $ipt['contact_fax'],
				'email'      => $ipt['contact_email'],
			];
			$contact->update($contactChange);

			$actAccountingChange = [
				'budget'        => $ipt['budget_budge'],
				'yearlyAmount'  => $ipt['budget_contract'],
				'billing'       => $ipt['budget_billing'],
				'initialStart'  => $ipt['budget_start'],
				'initialBudget' => $ipt['budget_init'],
			];
			$act->accounting->update($actAccountingChange);

			$termsChange = [
				'term_id' => $ipt['budget_terms']
			];
			$act->actTerms->update($termsChange);

			$statusChange = [
				'status_id'   => $ipt['act_status'],
				'act_freq'    => $ipt['status_freq'],
				'act_other'   => $ipt['status_other'],
				'status_date' => date('Y-m-d', strtotime($ipt['status_date'])),
			];
			$act->actStatus->update($statusChange);

			$typeChange = [
				'types_id'   => $ipt['status_type'],
				'automatic'  => (isset($ipt['note_auto']) ? 1 : 0),
				'commission' => (isset($ipt['note_comm']) ? 1 : 0)
			];
			$act->actType->update($typeChange);

			$officeCHange = [
				'office_id' => $ipt['office_office']
			];
			$act->office->update($officeCHange);

			if( isset( $ipt['salesman_salesman']) && $ipt['salesman_salesman'] != '')
			{
				$salesmanChange = [
					'salesmen_id' => $ipt['salesman_salesman']
				];

				$act->salesmen->update($salesmanChange);
			}	


			$taxChange = [
				'taxState'     => $ipt['taxstate'],
				'taxDistrict'  => $ipt['dist'],
				'exemptNumber' => $ipt['salesman_exempt'],
			];
			$act->actTax->update($taxChange);

			$noteChange = [
				'notes'         => $ipt['notes_note'],
				'combine'       => (isset($ipt['combine_with']) && $ipt['combine_with'] != '' ? $ipt['combine_with'] : null),
				'otherType'     => $ipt['notes_site_add'],
				'notes_phone'   => $ipt['notes_sec_phone'],
				'notes_contact' => $ipt['notes_contact'],
				'notes_email'   => $ipt['notes_email'],
			];
			$act->note->update($noteChange);
			$act->actService()->sync($ipt['act_services']);

			return \Redirect::route('account', ['id' => $act->accountNumber]);
		}

		/**
		 * Update the specified resource in storage.
		 *
		 * @param  int $id
		 *
		 * @return Response
		 */
		public function update($id)
		{
			//
		}

		/**
		 * @param $id
		 * @return \Illuminate\Http\RedirectResponse
		 */
		public function destroy($id)
		{
			Account::findOrFail($id)->delete();

			return redirect( route('dash') )->with( 'success', 'Account Successfully Removed' );
		}


		private function stripPhone($value){
			$value = trim($value);
			$value = str_replace(['(', ')', '-', ' '], '', $value);

			return $value;
		}

		public function fixDate($value){
//        dd($value);
//        dd($value != '1970-01-01' && $value != '0000-00-00');
			if ($value != '1970-01-01' && $value != '0000-00-00' && strtotime($value) > strtotime('2000/01/01')) {
//            dd('FUCKING FAIL');
				return date('m/d/Y', strtotime($value));
			}else {
				return '';
			}
		}
	}
