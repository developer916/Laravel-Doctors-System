<?php namespace App\Http\Controllers;

use App\Account;
use App\ActInfo;
use App\Note;
use App\ActOffice;
use App\Office;
use App\Http\Requests;
use Crypt;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ReportsController extends Controller
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
	public function index(){
		//
	}
	
	public function reference(){
        set_time_limit(0);
		ini_set('memory_limit', '3.5G');
		\DB::enableQueryLog();
        $ipt = \Input::all();
        
		$tmp = [];
		$status = \App\Status::all();
		$offices = \App\Office::all();
        $offices_ids = [];
		foreach ($offices as $off) {
            $offices_ids[] = $off->id;
		}
        
        $contacts = \App\Contact::all();
        $salesmen = \App\Salesman::all();
        $salesmen_ids = [];
		foreach ($salesmen as $sal) {
			$salesmen_ids[] = $sal->id;
		}
        
        $act = Account::with('actStatus')->with('office')->with('actInfo')->with('accounting')->with('salesmen');
        
        if (isset($ipt['exp_office']) && $ipt['exp_office'] != 'default') {
            $act = $act->whereHas('office', function ($query) use ($ipt) {
				$query->where('office_id', $ipt['exp_office']);
			});
        }
        if (isset($ipt['exp_sales']) && $ipt['exp_sales'] != 'default') {
            $act = $act->whereHas('salesmen', function ($query) use ($ipt) {
				$query->where('id', $ipt['exp_sales']);
			});
        }
        
//        if ($request->input('sales') != 'default') {
//				$actSales = \App\ActSalesman::where('salesmen_id', $request->input('sales'))->whereIn('account_id', $account_sids)->get();
//			}
        
        
        if (isset($ipt['exp_sort']) && $ipt['exp_sort'] != '') {
            $expSort = $ipt['exp_sort'];
            $act = $act->orderBy($expSort, 'ASC');
        }
        
		$act = $act->chunk(5, function ($act) use (&$tmp, $status, $offices, $salesmen, $salesmen_ids) {
			foreach ($act as $a) {
				$temp = new \stdClass();
				$temp->actNum = $a->accountNumber;
				$temp->actName = $a->actName;
				$contact = \App\Contact::find($a->location_id);
                if (isset($a->salesmen) && isset($a->salesmen->salesmen_id) && in_array($a->salesmen->salesmen_id, $salesmen_ids)) {
					$temp->salesman = $salesmen->find($a->salesmen->salesmen_id)->abvr;
				} else {
					$temp->salesman = 'Orphan';
				}
				$temp->email = $contact->email;
				if (isset($a->office) && isset($a->office->office_id))
					$temp->office = $offices->find($a->office->office_id)->abvr;
				else
					$temp->office = 'Orphan';
				$temp->status = ($status->find($a->actStatus->status_id)->code == 'AC' ? 'Active' : $status->find($a->actStatus->status_id)->code);
				$temp->budget = $a->accounting->budget;
				$temp->exp = date('m/d/Y', strtotime($a->actInfo->date_end));
				$tmp[] = $temp;
            }
        });
		$data['act'] = $tmp;
		
		return view('reports.act_ref', $data)
			->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
	}
	
	public function getFieldActivity($id){
		$return['bc'] = 'Field Activity: ' . $id;
		$return['id'] = $id;
		$return['tech'] = \App\Technician::orderby('code', 'ASC')->get();
		$return['techList'] = [];
		foreach ($return['tech'] as $tk) {
			$return['techList'][ $tk->id ] = $tk->code . ' &mdash; ' . $tk->name;
		}
        
		$return['mats'] = \App\Material::all();
        
        $return['lastService'] = \App\FieldService::where('old_number', $id)->orderby('service_date', 'DESC')->first();
        if (empty($return['lastService'])) {
            $return['lastService'] = \App\FieldService::where('account_id', $id)->orderby('service_date', 'DESC')->first();
        }
        
		if (!empty($return['lastService'])) {
            $return['lastService']->techName = \App\Technician::where('id', $return['lastService']->tech_id)->first();
            $act = \App\Account::where('accountNumber', $return['lastService']->account_id)->with('actStatus')->first();
		    $return['act'] = $act;
            $return['field'] = \App\FieldService::where('old_number', $return['lastService']->old_number)->with('fieldData')->orderby('service_date', 'DESC')->get();
            $return['fieldCount'] = count($return['field']);
            $return['act']->actStatus->Name = \App\Status::where('id', $return['act']->actStatus->status_id)->first();
        } else {
            $return['lastService'] = new \stdClass();
            $return['lastService']->techName = new \stdClass();
            $return['lastService']->tech_id = 0;
            $return['lastService']->hours = 'N/A';
            $return['lastService']->service_date = 'N/A';
            $return['lastService']->techName->code = 'N/A';
            $return['lastService']->techName->name = 'N/A';
            $return['act'] = new \stdClass();
            $return['act']->actStatus = new \stdClass();
            $return['field'] = \App\FieldService::where('old_number', '161616')->with('fieldData')->orderby('service_date', 'DESC')->get();
            $return['fieldCount'] = 0;
            $return['act']->actName = 'N/A';
            $return['act']->actStatus->Name = new \stdClass();
            $return['act']->actStatus->Name->code = 'N/A';
            $return['act']->actStatus->Name->name = 'N/A';
            $return['act']->actStatus->status_id = 0;
        }
		
		$return['me'] = $this->perms;
		//dd($return['field']);
		return view('reports.fieldActivity', $return)
			->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
	}
	
	public function getMaterialUsageAct($id){
		$act = config('lookup_accounts.accounts');
		$return['report'] = config('lookup_accounts.field_act');
		$return['bc'] = 'Material Usage Report';
		$return['wide'] = true;
		$return['total'] = 0;
//        $return['id'] = $id;
		foreach ($return['report'] as $a):
			foreach ($a as $key => $val):
				if ($key == 'cost') {
					$return['total'] += floatval($val);
				}
			endforeach;
		endforeach;
		
		return view('reports.materialUsage', $return)
			->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
	}
	
	public function getMaterialRef(){
		$return['report'] = \App\Material::orderBy('code', 'ASC')->get();
		$return['report2'] = \App\Material::orderBy('name', 'ASC')->get();
		$return['bc'] = 'Material Reference List';
		$return['wide'] = true;
		$return['total'] = 0;
		
		return view('reports.materialRef', $return)
			->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
	}
	
	public function getMaterialGraph(){
		$return['report'] = config('lookup_mats.mats');
		$return['bc'] = 'Material Reference List';
		$return['wide'] = true;
		$return['total'] = 0;
		
		return view('reports.materialCost', $return)
			->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
	}
	
	public function printCpr($id){
		$return['id'] = $id;
		$return['act'] = Account::where('accountNumber', $id)
			->with('office')
			->with('accounting')
			->with('note')
			->with('actStatus')
			->with('salesmen')
			->with('actTerms')
			->with('actInfo')
			->with('actType')
			->with('actTax')
			->with('actService')
			->first();
		$return['act']->actType->automatic = ($return['act']->actType->automatic == 0 ? "Y" : "N");
		$return['act']->actType->commission = ($return['act']->actType->commission == 0 ? "Y" : "N");
		$actCount = count($return['act']->actService);
		$appCount = \App\Service::count();
		$appHalf = intval($appCount / 2);
		$tempArr = [];
		$return['act']->actServiceTrue = false;
		if ($actCount > $appHalf) {
			$i = 0;
			foreach ($return['act']->actService as $as) {
				if ($i % 2 != 0) {
					$tempArr[0][] = $as->name;
				} else {
					$tempArr[1][] = $as->name;
				}
				$i++;
			}
			$return['act']->actService = $tempArr;
			$return['act']->actServiceTrue = true;
		}

//        $return['act']->actTax->taxDistrict = 368;
		$return['act']['location'] = \App\Location::where('id', $return['act']->location_id)->first();
		$return['act']['location']->state = \App\State::where('id', $return['act']['location']->state_id)->select('abvr')->first();
//        dd($return['act']['location']);

		$return['act']->office->officeName = \App\Office::where('id', $return['act']->office->office_id)->select('officeName', 'abvr')->first();
		$return['act']['contact'] = \App\Contact::find($return['act']->contact_id);
//        $return['act']['contact'] = \App\Contact::where('id', $return['act']->contact_id)->first();
        //dd($return['act']);
		$return['act']->salesmen->name = \App\Salesman::where('id', $return['act']->salesmen->salesmen_id)->select('abvr', 'name')->first();
        
//        $return['act']['contact']->phoneWork = $this->fixPhone( $return['act']['contact']->phoneWork );
//        $return['act']['contact']->phoneFax = $this->fixPhone( $return['act']['contact']->phoneFax );
//        $return['act']['contact']->phoneCell = $this->fixPhone( $return['act']['contact']->phoneCell );

//        $return['act']['note']->notes_phone = $this->fixPhone( $return['act']['note']->notes_phone );
		$return['act']->actType->info = \App\Type::where('id', $return['act']->actType->types_id)->select('name')->first();
		
		$return['act']->actTax->info = \App\TaxDistrict::where('id', $return['act']->actTax->taxDistrict)->select('name', 'id_code', 'percent')->first();
//        dd($return['act']->actTax);
		
		
		$return['act']->actTerms->term = \App\Term::where('id', $return['act']->actTerms->term_id)->select('name')->first();
		$return['act']->actStatus->name = \App\Status::where('id', $return['act']->actStatus->status_id)->select('code')->first();
//        $return['act']->actStatus->statusDate = $this->fixDates($return['act']->actStatus->statusDate);
		$return['act']->accounting->budget = number_format($return['act']->accounting->budget, 2);
		$return['act']->accounting->yearlyAmount = number_format($return['act']->accounting->yearlyAmount, 2);
		$return['act']->accounting->billing = number_format($return['act']->accounting->billing, 2);
		$return['act']->accounting->initialStart = number_format($return['act']->accounting->initialStart, 2);
		$return['act']->accounting->initialBudget = number_format($return['act']->accounting->initialBudget, 2);
		
		return view('reports.cpr', $return)
			->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
	}
    
    public function printAll($id = null){
		set_time_limit(0);
		ini_set('memory_limit', '3.5G');
        
		$allStatus = \App\Status::all(['id', 'code', 'name']);
		$ipt = \Input::all();

        $act_list = explode(',', $ipt['attachments']);
        
//        $id_list = [5,9,13]; 
//
//        $data_list = DB::table('table') ->whereIn('id', $id_list)->get();
//        
//        $models = Model::whereIn('id', [1, 2, 3])->get();
//        $models = Model::findMany([1, 2, 3]);
        
		$return['id'] = $id;
		$return['act'] = Account::whereIn('accountNumber', $act_list)
			->with('office')
			->with('accounting')
			->with('note')
			->with('actStatus')
			->with('salesmen')
			->with('actTerms')
			->with('actInfo')
			->with('actType')
			->with('actTax')
			->with('actService')
			->get();
        foreach ($return['act'] as $act) {
            $actStats = new \stdClass();
            $actStats->automatic = ($act->actType->automatic == 0 ? "Y" : "N");
            $actStats->commission = ($act->actType->commission == 0 ? "Y" : "N");
            $actCount = count($act->actService);
            $appCount = \App\Service::count();
            $appHalf = intval($appCount / 2);
            $tempArr = [];
            $actStats->actServiceTrue = false;
            if ($actCount > $appHalf) {
                $i = 0;
                foreach ($act->actService as $as) {
                    if ($i % 2 != 0) {
                        $tempArr[0][] = $as->name;
                    } else {
                        $tempArr[1][] = $as->name;
                    }
                    $i++;
                }
                $actStats->actService = $tempArr;
                $actStats->actServiceTrue = true;
            }

            $actStats->location = \App\Location::where('id', $act->location_id)->first();
            //$actStats->state = \App\State::where('id', $act->location->state_id)->select('abvr')->first();
            //$actStats->officeName = \App\Office::where('id', $act->office->office_id)->select('officeName', 'abvr')->first();
            $actStats->officeName = "Temp";
            $actStats->contact = \App\Contact::find($act->contact_id);
            $actStats->care_of = "Temp";
            $actStats->salesman = \App\Salesman::where('id', $act->salesmen->salesmen_id)->select('abvr', 'name')->first();
            $actStats->actType = \App\Type::where('id', $act->actType->types_id)->select('name')->first();
            $actStats->actTax = \App\TaxDistrict::where('id', $act->actTax->taxDistrict)->select('name', 'id_code', 'percent')->first();
            $actStats->actTerms = \App\Term::where('id', $act->actTerms->term_id)->select('name')->first();
            $actStats->actStatus = \App\Status::where('id', $act->actStatus->status_id)->select('code')->first();
            $actStats->accountingBudget = number_format($act->accounting->budget, 2);
            $actStats->accountingYearlyAmount = number_format($act->accounting->yearlyAmount, 2);
            $actStats->accountingBilling = number_format($act->accounting->billing, 2);
            $actStats->accountingInitialStart = number_format($act->accounting->initialStart, 2);
            $actStats->accountingInitialBudget = number_format($act->accounting->initialBudget, 2);
            $return['acts'] = $actStats;
        }
        
//        dd($return['acts']);
		
		return view('reports.allcpr', $return)
			->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
    }
	
	public function getCpr($id){
		
	}
	
	public function printCar($id = null){
		set_time_limit(0);
		ini_set('memory_limit', '3.5G');
		\DB::enableQueryLog();
//        $office_id = (isset($ipt['id']) ? $ipt['id'] : null);
//		$begin = (isset($ipt['statusStart']) ? $ipt['statusStart'] : null);
//		$end = (isset($ipt['statusEnd']) ? $ipt['statusEnd'] : null);
//		$tech_id = (isset($ipt['tech']) && $ipt['tech'] != 'default' ? $ipt['tech'] : null);
//		$acct = (isset($ipt['actId']) ? $ipt['actId'] : null);
//		//dd($ipt, 'office_id ' . $office_id, 'Begin ' . $begin, 'end ' . $end, 'tech_id ' . $tech_id, 'acct ' . $acct);
//		unset($ipt);
//		$act_ids = [];
//		$office = \App\Office::where('id', $office_id)->first();
//		$act_offices = \App\ActOffice::where('office_id', $office_id)->get();
//		
//		foreach ($act_offices as $ao) {
//			$act_ids[] = $ao->account_id;
//		}
//		$accounts = \App\Account::whereIn('id', $act_ids)->orderBy('accountNumber', 'ASC')->get();
//		$act_ids = [];
//		foreach ($accounts as $ao) {
//			$act_ids[] = $ao->id;
//		}
//		
//		$act_status = \App\FieldService::whereIn('account_id', $act_ids);
//		// TODO: This is the correct date format, but tech id is screwed up
//		if ($begin && !$end) {
//			$act_status->where('service_date', '>', date('Y-m-d', strtotime($begin)));
//		}
//		if (!$begin && $end) {
//			$act_status->where('service_date', '<', date('Y-m-d', strtotime($end)));
//		}
//		if ($begin && $end) {
//			$act_status->whereBetween('service_date', [date('Y-m-d', strtotime($begin)), date('Y-m-d', strtotime($end))]);
//		}
//		if ($tech_id) {
//			$act_status->where('tech_id', $tech_id);
//		}
//		$act_status = $act_status->get();
//        
        
        
        
		$allStatus = \App\Status::all(['id', 'code', 'name']);
		$ipt = \Input::all();

		if (is_null($id)) {
			$act = $ipt['accountNumber'];
			$tmp = explode(',', $ipt['accountNumber']);
		} else {
			$act = $id;
		}
        
        $begin = (isset($ipt['serviceStart']) ? $ipt['serviceStart'] : null);
		$end = (isset($ipt['serviceEnd']) ? $ipt['serviceEnd'] : null);
		
		$act = Account::orderBy('accountNumber', 'asc')->with('actStatus')->with('field')->with('accounting')->get();

		if (isset($ipt['accountNumber']) && $ipt['accountNumber'] != '') {
			$act->where('accountNumber', $ipt['accountNumber']);
		}
        
        if ($begin && !$end) {
            $act->whereHas('field', function ($query) use ($ipt) {
				$query->where('service_date', '>=', date('Y-m-d', strtotime($ipt['serviceStart'])));
			});
		}
		if (!$begin && $end) {
            $act->whereHas('field', function ($query) use ($ipt) {
				$query->where('service_date', '<=', date('Y-m-d', strtotime($ipt['serviceEnd'])));
			});
		}
		if ($begin && $end) {
             $act->whereHas('field', function ($query) use ($ipt) {
				$query->whereBetween('service_date', [date('Y-m-d', strtotime($ipt['serviceStart'])), date('Y-m-d', strtotime($ipt['serviceEnd']))]);
			});
		}
        if (isset($ipt['startDate']) && $ipt['startDate'] != '') {
			$act->whereHas('actInfo', function ($query) use ($ipt) {
				$query->where('date_begin', '>=', date('Y-m-d', strtotime($ipt['startDate'])));
			});
		}
		if (isset($ipt['endDate']) && $ipt['endDate'] != '') {
			$act->whereHas('actInfo', function ($query) use ($ipt) {
				$query->where('date_end', '<=', date('Y-m-d', strtotime($ipt['endDate'])));
			});
		}
		if (isset($ipt['office']) && $ipt['office'] != 'default') {
			$act->whereHas('office', function ($query) use ($ipt) {
				$query->where('office_id', $ipt['office']);
			});
		}
		if (isset($ipt['tech']) && $ipt['tech'] != 'default') {
			$act->whereHas('field', function ($query) use ($ipt) {
				$query->where('tech_id', $ipt['tech']);
			});
		}
		
		//$return['act'] = $act->with('field')->with('accounting')->get();
		$return['act'] = $act;

		$accts = [];

		$summary = new \stdClass();
		$actFacts = [];
		$summary->actNum = ($act ? $act : 'No account Number');
		$renewStart = (isset($ipt['startDate']) && $ipt['startDate'] != '' ? $ipt['startDate'] : 'Up to');
		$renewEnd = (isset($ipt['endDate']) && $ipt['endDate'] != '' ? $ipt['endDate'] : 'Till now');
		if ($renewStart != 'Up to' || $renewEnd != 'Till now') {
			$renew = $renewStart . ' - ' . $renewEnd;
		} else {
			$renew = 'No Renew dates set.';
		}
		$treatStart = (isset($ipt['startDate']) && $ipt['serviceStart'] != '' ? $ipt['serviceStart'] : 'Up to');
		$treatEnd = (isset($ipt['serviceEnd']) && $ipt['serviceEnd'] != '' ? $ipt['serviceEnd'] : 'Till now');
		
		if ($treatStart != 'Up to' || $treatEnd != 'Till now') {
			$treatDate = $treatStart . ' - ' . $treatEnd;
		} else {
			$treatDate = 'No Treatment dates set.';
		}
		$summary->renewDate = $renew;
		$summary->treatDate = $treatDate;
		$summary->office = (isset($ipt['office']) && $ipt['office'] != 'default' ? $ipt['office'] : 'No office selected');
		$summary->tech = (isset($ipt['tech']) && $ipt['tech'] != 'default' ? $ipt['tech'] : 'No technician selected');
		$summary->altCost = 0;
		$return['status'] = $allStatus;
		$return['summary'] = $summary;
        
		foreach ($return['act'] as $a) {
			$actStats = new \stdClass();
			$actStats->id = $a->accountNumber;
			$actStats->fieldCount = count($a->field);
			$actHours = [];
			$hours = 0;
			$costTotal = 0;
			$d1 = new \DateTime("2075-01-01");
			$d2 = new \DateTime("2008-01-01");
			foreach ($a->field as $f) {
                $f->data = \App\FieldData::where('old_number', $f->old_number)->get();
				$fieldChem = 0;
				foreach ($f->data as $key => $fd) {
					$sst = new \stdClass();
					$sst->qty = number_format((float)$fd->quantity, 2);
					$sst->mat = \App\Material::select('code', 'name', 'units', 'cost')->where('id', $fd->material_id)->first();
					if ($sst->mat) {
                        // TODO: Material Cost is not right
						$sst->cost = $sst->mat->cost;
						$sst->name = $sst->mat->name;
						$sst->units = $sst->mat->units;
						$sst->code = $sst->mat->code;
                        
                        $foo = $sst->cost * $sst->qty;
						$sst->matTotal = number_format((float)$foo, 2, '.', '');
						$costTotal += round($sst->cost * $sst->qty, 2);
						$fieldChem += round($sst->cost * $sst->qty, 2);
					} else {
						$sst->cost = '';
						$sst->name = 'No Info';
						$sst->units = '';
						$sst->code = '';
						$sst->matTotal = '';
					}
					unset($sst->mat);
					$f->data[ $key ] = $sst;
				}
				$actHours[] = $f->hours;
				$hours += $f->hours;
				$sDate = new \DateTime($f->service_date);
				if ($sDate < $d1) {
					$d1 = $sDate;
				}
				if ($sDate > $d2) {
					$d2 = $sDate;
				}
				$tech = \App\Technician::select('code')->where('id', $f->tech_id)->first();
                if(!empty($tech)){
				    $f->tech = $tech->code;
                }
				$f->chemTotal = $fieldChem;
				$actStats->fieldServe[] = $f;
			}
			$noMonths = $d1->diff($d2)->m + ($d1->diff($d2)->y * 12);
            
			$actStats->totalMonths = ($noMonths > 1 ? $noMonths : 1);
			$actStats->lower = $d1;
			$actStats->higher = $d2;
			$actStats->costTotal = $costTotal;
			$actStats->totalHours = $hours;
			$actStats->contractBillingAmount = $a->accounting->billing;
			$actStats->monthlyChemBudget = $a->accounting->budget;
			
			$actStats->avgChem = ($actStats->totalMonths != 0 ? $costTotal / $actStats->totalMonths : 0);
			$actStats->avgHours = ($actStats->fieldCount > 0 ? $hours / $actStats->fieldCount : 'none');
			$actStats->chemVar = $actStats->avgChem - $actStats->monthlyChemBudget;
			
            $actStats->hoursLIst = $actHours;
			if ($actStats->totalMonths == 0) {
				$actStats->altCost = 0;
			} else {
				$actStats->altCost = number_format(($actStats->costTotal + ($actStats->totalHours * 80)) / $actStats->totalMonths, 2);
			}
            
			$return['actStats'] = $actStats;
		}
        //dd($return);
		return view('reports.car', $return)
			->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
	}
    
    public function getExp(){
        set_time_limit(0);
		ini_set('memory_limit', '3.5G');
		\DB::enableQueryLog();
        $ipt = \Input::all();
        
		$tmp = [];
		$status = \App\Status::all();
		$offices = \App\Office::all();
		$contacts = \App\Contact::all();
		$notes = \App\Note::all();
        $sales = \App\ActSalesman::all();
		$act = Account::with('actStatus')->with('office')->with('actInfo')->with('accounting')->with('salesmen')->with('note');
        
        if (isset($ipt['exp_beg']) && $ipt['exp_beg'] != '') {
			$act = $act->whereHas('actInfo', function ($query) use ($ipt) {
				$query->where('date_begin', '>=', date('Y-m-d', strtotime($ipt['exp_beg'])));
			});
		}
		if (isset($ipt['exp_end']) && $ipt['exp_end'] != '') {
			$act = $act->whereHas('actInfo', function ($query) use ($ipt) {
				$query->where('date_end', '<=', date('Y-m-d', strtotime($ipt['exp_end'])));
			});
		}
        
        if (isset($ipt['exp_office']) && $ipt['exp_office'] != 'default') {
            $act = $act->whereHas('office', function ($query) use ($ipt) {
				$query->where('office_id', $ipt['exp_office']);
			});
        }
        if (isset($ipt['exp_sales']) && $ipt['exp_sales'] != 'default') {
            $act = $act->whereHas('salesmen', function ($query) use ($ipt) {
				$query->where('salesmen_id', $ipt['exp_sales']);
			});
        }
        if (isset($ipt['exp_type']) && $ipt['exp_type'] != '') {
            $expType =  $ipt['exp_type'];
        }
        if (isset($ipt['exp_sort']) && $ipt['exp_sort'] != '') {
            $expSort = $ipt['exp_sort'];
            $act = $act->orderBy($expSort, 'ASC');
        }
        
        $act = $act->chunk(5, function ($act) use (&$tmp, $status, $offices, $sales, $notes) {
            foreach ($act as $a) {
				$temp = new \stdClass();
				$temp->actNum = $a->accountNumber;
				$temp->actName = $a->actName;
				$contact = \App\Location::find($a->location_id);
                $temp->care_of = $contact->care_of;
				$temp->address1 = $contact->address1;
				$temp->address2 = $contact->address2;
				$temp->address3 = $contact->address3;
				$temp->city = $contact->city;
                    
                if (isset($a->salesmen) && isset($a->salesmen->salesmen_id)){
					$temp->sales = \App\Salesman::where('id', $a->salesmen->salesmen_id)->pluck('abvr');
                } else {
					$temp->sales = 'N/A';
                }
                // TODO: pluck is awesome
				$temp->contact = \App\Note::where('id', $a->location_id)->pluck('notes_contact');
				$temp->contact2 = \App\Contact::where('id', $a->location_id)->pluck('firstName');
				$temp->phone2 = \App\Contact::where('id', $a->location_id)->pluck('phone_work');
				$temp->title = \App\Contact::where('id', $a->location_id)->pluck('title');
				$temp->phone = \App\Note::where('id', $a->location_id)->pluck('notes_phone');
                $temp->state = \App\State::where('id', $a->location_id)->pluck('abvr');                    
                $temp->zipcode = $contact->zipcode;
				
                if (isset($a->office) && isset($a->office->office_id))
					$temp->office = $offices->find($a->office->office_id)->abvr;
				else {
				    $temp->office = 'Orphan';
                }
                
				$temp->status = ($status->find($a->actStatus->status_id)->code == 'AC' ? 'Active' : $status->find($a->actStatus->status_id)->code);
				$temp->budget = $a->accounting->budget;
				$temp->begin = date('m/d/Y', strtotime($a->actInfo->date_begin));
				$temp->exp = date('m/d/Y', strtotime($a->actInfo->date_end));
                $tmp[] = $temp;
            }
        });
		$data['act'] = $tmp;

		return view('reports.exp', $data)
			->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
	}
	
	public function accountCo(){
        set_time_limit(0);
		ini_set('memory_limit', '3.5G');
		$ipt = \Input::all();
		$off = \App\Office::all();
		$status = \App\Status::all();
		//dd($ipt);
		if (isset($ipt['office_id']) && ($ipt['office_id'] != 'default' || $ipt['office_id'] == 'all')) {
			$truthy = true;
			$office_id = $ipt['office_id'];
		} else {
			$truthy = false;
		}
		unset($ipt);
		$act_ids = [];
        
		if ($truthy) {
			$office = \App\Office::where('id', $office_id)->first();
			$return['abvr'] = $office->abvr;
			
			$act_offices = \App\ActOffice::where('office_id', $office_id)->get();
			
			foreach ($act_offices as $ao) {
				$act_ids[] = $ao->account_id;
			}
		}
		$accounts = \App\Account::with('actStatus')->with('office')->orderBy('accountNumber', 'ASC');
		if ($truthy) {
			$accounts = $accounts->whereIn('id', $act_ids);
		}
		$accounts = $accounts->get();
		
		foreach ($accounts as $act) {
			if (!isset($act->office->office_id)) {
				$abvr = 'N/A';
			} else {
				$abvr = $off->find($act->office->office_id)->abvr;
			}
			$act_tmp = new \stdClass();
			$act_tmp->id = $act->accountNumber;
            
            $stat = ($status->find($act->actStatus->status_id)->code == 'AC' ? 'Active' : $status->find($act->actStatus->status_id)->code);
            
			$act_tmp->abvr = $abvr;
			$act_tmp->name = $act->actName;
			$loc = \App\Location::where('id', $act->location_id)->first();
			$act_tmp->co = $loc->care_of;
            if(!empty($act_tmp->co) && $stat == "Active"){
                $return['act'][] = $act_tmp;
            }
		}
		
		return view('reports.co', $return)
			->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
	}
	
	public function accountBio(){
		$ipt = \Input::all();
		\DB::enableQueryLog();
		$office_id = (isset($ipt['id']) ? $ipt['id'] : null);
		$begin = (isset($ipt['statusStart']) ? $ipt['statusStart'] : null);
		$end = (isset($ipt['statusEnd']) ? $ipt['statusEnd'] : null);
		$tech_id = (isset($ipt['tech']) && $ipt['tech'] != 'default' ? $ipt['tech'] : null);
		$acct = (isset($ipt['actId']) ? $ipt['actId'] : null);
		//dd($ipt, 'office_id ' . $office_id, 'Begin ' . $begin, 'end ' . $end, 'tech_id ' . $tech_id, 'acct ' . $acct);
		unset($ipt);
		$act_ids = [];
		$office = \App\Office::where('id', $office_id)->first();
		$act_offices = \App\ActOffice::where('office_id', $office_id)->get();
		
		foreach ($act_offices as $ao) {
			$act_ids[] = $ao->account_id;
		}
		$accounts = \App\Account::whereIn('id', $act_ids)->orderBy('accountNumber', 'ASC')->get();
		$act_ids = [];
		foreach ($accounts as $ao) {
			$act_ids[] = $ao->id;
		}
		
		$act_status = \App\FieldService::whereIn('account_id', $act_ids);
		// TODO: This is the correct date format, but tech id is screwed up
		if ($begin && !$end) {
			$act_status->where('service_date', '>', date('Y-m-d', strtotime($begin)));
		}
		if (!$begin && $end) {
			$act_status->where('service_date', '<', date('Y-m-d', strtotime($end)));
		}
		if ($begin && $end) {
			$act_status->whereBetween('service_date', [date('Y-m-d', strtotime($begin)), date('Y-m-d', strtotime($end))]);
		}
		if ($tech_id) {
			$act_status->where('tech_id', $tech_id);
		}
		$act_status = $act_status->get();
		foreach ($act_status as $act) {
			$act_tmp = new \stdClass();
			$act_tmp->id = \App\Account::find($act->account_id)->accountNumber;
			$act_tmp->name = \App\Account::find($act->account_id)->actName;
			$tech_in = \App\Technician::find($act->tech_id);
			if ($tech_in) {
				$act_tmp->by = $tech_in->code;
			} else {
				$act_tmp->by = 'N/A';
			}
			$act_tmp->date = $act->service_date;
			$return['act'][] = $act_tmp;
		}
		
		return view('reports.bio', $return)
			->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
	}
	
	public function accountCancel(){
		$ipt = \Input::all();
		$off = \App\Office::all();
		
		if (isset($ipt['id']) && ($ipt['id'] != 'default' || $ipt['id'] == 'all')) {
			$truthy = true;
			$office_id = $ipt['id'];
		} else {
			$truthy = false;
		}
        // TODO: This is the correct date format
		$begin = (isset($ipt['statusStart']) ? $ipt['statusStart'] : null);
		$end = (isset($ipt['statusEnd']) ? $ipt['statusEnd'] : null);
		$status = [1, 2, 3, 4, 5, 6, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 22, 23];
		$status_names = \App\Status::whereIn('id', $status)->get();
		unset($ipt);
		\DB::enableQueryLog();
		$act_ids = [];
//
//		$office = \App\Office::where('id', $office_id)->first();
//
//		$return['abvr'] = $office->abvr;
		
		$act_status = \App\ActStatus::whereIn('status_id', $status);
		if ($begin && !$end) {
			$act_status->where('status_date', '>=', date('Y-m-d', strtotime($begin)));
		}
		if (!$begin && $end) {
			$act_status->where('status_date', '<=', date('Y-m-d', strtotime($end)));
		}
		if ($begin && $end) {
			$act_status->whereBetween('status_date', [date('Y-m-d', strtotime($begin)), date('Y-m-d', strtotime($end))]);
		}
		$act_status = $act_status->get();
		
		foreach ($act_status as $ao) {
			$act_ids[] = $ao->account_id;
		}
		
		//do thin by office if was added...
		
		
		$accounts = \App\Account::whereIn('id', $act_ids)->with('actStatus')->with('office')->orderBy('accountNumber', 'ASC')->get();
		
		foreach ($accounts as $act) {
			if (!isset($act->office->office_id)) {
				$abvr = 'N/A';
			} else {
				$abvr = $off->find($act->office->office_id)->abvr;
			}
			$act_tmp = new \stdClass();
			$act_tmp->id = $act->accountNumber;
			$act_tmp->name = $act->actName;
			$act_tmp->abvr = $abvr;
			$act_tmp->date = $act->actStatus->status_date;
			$act_tmp->status = $status_names->find($act->actStatus->status_id)->code;
			$return['act'][] = $act_tmp;
		}
		
		return view('reports.cancel', $return)
			->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
	}
	
	private function fixPhone($value){
		if (strlen($value) > 10) {
			$rtn = "" . substr($value, 0, 3) . "-" . substr($value, 3, 3) . "-" . substr($value, 6, 4) . " Ext " . substr($value, 10);
		} else if (strlen($value) == 10) {
			$rtn = "" . substr($value, 0, 3) . "-" . substr($value, 3, 3) . "-" . substr($value, 6);
		} else {
			$rtn = "";
		}
		return $rtn;
	}
	
	private function stripPhone($value){
		$value = trim($value);
		$value = str_replace(['(', ')', '-', ' '], '', $value);
		
		return $value;
	}
	
	public function fixDates($value){
		if ($value !== '1970-01-01') {
			return date('m/d/Y', strtotime($value));
		} else {
			return '';
		}
	}
	
	public function purgeFetch(){
		$ipt = \Input::all();
		
		$services = \App\FieldService::where('service_date', '<', date('Y-m-d', strtotime($ipt['date'])))->count();
		if ($services > 0) {
			$return = [
				'result' => 'good',
				'count'  => $services
			];
		} else {
			$return = [
				'result' => 'bad',
				'count'  => 0
			];
		}
		return $return;
	}
	
	public function purgeRemove(){
		$ipt = \Input::all();
		
		$services = \App\FieldService::where('service_date', '<', date('Y-m-d', strtotime($ipt['date'])))->get();
		$serv_ids = [];
		foreach ($services as $serv) {
			$serv_ids[] = $serv->id;
		}
		//delete field data
		$fieldData = \App\FieldData::whereIn('field_service_id', $serv_ids)->delete();
		$services = \App\FieldService::where('service_date', '<', date('Y-m-d', strtotime($ipt['date'])))->delete();
		$return = ['result' => 'good'];
		
		return $return;
	}
	
	public function purgeAccountFetch(){
		$ipt = \Input::all();
		$acct_ids = \App\ActInfo::where('date_end', '<', date('Y-m-d', strtotime($ipt['date'])))->count();
		
		if ($acct_ids > 0) {
			$return = [
				'result' => 'good',
				'count'  => $acct_ids
			];
		} else {
			$return = [
				'result' => 'bad',
				'count'  => 0
			];
		}
		return $return;
	}
	
	public function purgeAccountRemove(){
		$ipt = \Input::all();
		$acct_ids = \App\ActInfo::where('date_end', '<', date('Y-m-d', strtotime($ipt['date'])))->get();
		$act_ids = [];
		$service_ids = [];
		$status = [1, 2, 3, 4, 5, 6, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 22, 23];
		foreach ($acct_ids as $serv) {
			$act_ids[] = $serv->account_id;
		}
		$lower_acts = \App\Account::whereIn('id', $act_ids)->with('actStatus')->get();
		$act_ids = [];
		foreach ($lower_acts as $la) {
			if (in_array($la->actStatus->status_id, $status)) {
				$act_ids[] = $la->id;
			}
		}
		$dead_acts = \App\Account::whereIn('id', $act_ids)->delete();
		$services = \App\FieldService::whereIn('account_id', $act_ids)->get();
		//delete field data
		$services = \App\FieldService::where('service_date', '<', date('Y-m-d', strtotime($ipt['date'])))->get();
		foreach ($services as $ser) {
			$service_ids[] = $ser->id;
		}
		$fieldData = \App\FieldData::whereIn('field_service_id', $service_ids)->delete();
		$deadServices = \App\FieldService::where('service_date', '<', date('Y-m-d', strtotime($ipt['date'])))->delete();
		$return = ['result' => 'good'];
		
		return $return;
	}
	
	public function bioReport(){
		set_time_limit(0);
		ini_set('memory_limit', '3.5G');
		\DB::enableQueryLog();
		$temp = [];
		$temp2 = [];
		$ipt = \Input::all();
		$salesmen = \App\Salesman::all();
		$offices = \App\Office::all();
		$salesmen_ids = [];
		foreach ($salesmen as $sal) {
			$salesmen_ids[] = $sal->id;
		}
		/*
		 *  Inputs
		 * 		actId
		 * 		office_id
		 * 		tech
		 *		statusStart
		 * 		statusEnd
		 *
		 */
		$superArray = [];
		$account_ids = [];
		if (isset($ipt['id']) && $ipt['id'] != 'default') {
			$offices = ActOffice::where('office_id', $ipt['id'])->get();
			foreach ($offices as $off) {
				$account_ids[] = $off->account_id;
			}
		}
		$superArray = $account_ids;
		
		if (isset($ipt['actId']) && $ipt['actId'] != '') {
			$actId = [];
			$id = Account::where('accountNumber', $ipt['actId'])->first();
			$actId[] = $id->id;
			if (count($superArray) > 0) {
				$superArray = array_intersect($superArray, $actId);
				if (count($superArray) < 1 && count($actId) > 0) {
					$superArray = $actId;
				}
			} else {
				$superArray = $actId;
			}
			
		}
		$acount_start_ids = [];
		/*	if(isset($ipt['statusStart']) && $ipt['statusStart'] != ''){

				if(!isset($ipt['statusEnd']) && $ipt['statusEnd'] == ''){
					dd("Please enter an End date with a Start date");
				}
				$end_date = date('Y-m-d', strtotime($ipt['statusEnd']));
				$start_date = date('Y-m-d', strtotime($ipt['statusStart']));
				$start_date = date('Y-m-d', strtotime($ipt['statusStart']));
				$startDates = ActInfo::where('date_begin', '>=', $start_date)->where('date_end', '<=', $end_date)->get();
				foreach($startDates as $sd){
					$acount_start_ids[] = $sd->account_id;
				}
			}*/
		/*		if(count($superArray) > 0 && count($acount_start_ids) > 0){
			$superArray2 = array_intersect($superArray, $acount_start_ids);
			$superArray = [];
			$superArray = $superArray2;
		}*/
		$field_has = function ($query) use ($ipt, $superArray) {
			if (isset($ipt['tech']) && $ipt['tech'] != 'default') {
				$query->where('tech_id', $ipt['tech']);
			}
		};
		/*
			if(isset($ipt['statusStart']) && $ipt['statusStart'] != ''){
				$serviceStart = substr($ipt['statusStart'], 0, 2) . '/' . substr($ipt['statusStart'], 3, 2) . '/' . substr($ipt['statusStart'], 6);
				$start_date = date('Y-m-d', strtotime($serviceStart));
				$query->where('service_date', '>=', $start_date);
			}
			if(isset($ipt['statusEnd']) && $ipt['statusEnd'] != ''){
				$serviceEnd = substr($ipt['statusEnd'], 0, 2) . '/' . substr($ipt['statusEnd'], 3, 2) . '/' . substr($ipt['statusEnd'], 6);
				$end_date = date('Y-m-d', strtotime($serviceEnd));
				$query->where('service_date', '<=', $end_date);
			}
		$field_has2 = function ($query) use ($ipt, $superArray) {
			if (isset($ipt['statusStart']) && $ipt['statusStart'] != '') {
				$serviceStart = substr($ipt['statusStart'], 0, 2) . '/' . substr($ipt['statusStart'], 3, 2) . '/' . substr($ipt['statusStart'], 6);
				$start_date = date('Y-m-d', strtotime($serviceStart));
				$query->where('service_date', '>=', $start_date);
			}
		};*/
		$field = Account::with('field')->with('salesmen')
			->whereHas('field', $field_has)->with(['field' => $field_has]);
		
		if (count($superArray) > 0) {
			$field = $field->whereIn('id', $superArray);
		}
		$field = $field->chunk(100, function ($act) use ($ipt, &$temp, &$temp2, $salesmen, $salesmen_ids) {
			foreach ($act as $a) {
				foreach ($a->field as $f) {
					if (isset($ipt['statusStart']) && $ipt['statusStart'] != '' && (strtotime($f->service_date) < strtotime($ipt['statusStart']))) {
						continue;
					}
					if (isset($ipt['statusEnd']) && $ipt['statusEnd'] != '' && (strtotime($f->service_date) > strtotime($ipt['statusEnd']))) {
						continue;
					}
					$tmp = new \stdClass();
					$tmp->actNum = $a->accountNumber;
					$tmp->actName = $a->actName;
					if (isset($a->salesmen) && isset($a->salesmen->salesmen_id) && in_array($a->salesmen->salesmen_id, $salesmen_ids)) {
						$tmp->salesman = $salesmen->find($a->salesmen->salesmen_id)->abvr;
					} else {
						$tmp->salesman = 'Orphan';
					}
					$tmp->date = $f->service_date;
					$temp[ $a->accountNumber ] = $tmp;
					$temp2[ ] = $tmp;
				}
			}
		});
		ksort($temp);
		usort($temp2, function($a, $b){
			if($a->salesman == $b->salesman){
				return 0;
			}
			return ( $a->salesman < $b->salesman) ? -1 : 1;
		});
		$return['act'] = $temp;
		$return['act2'] = $temp2;
		/*	$field = \App\FieldService::where(function($query) use( $superArray){
				if(count($superArray) > 0){
					$query->whereIn('account_id', $superArray);
				}
			})->where(function($query) use($ipt){
				if(isset($ipt['statusStart']) && $ipt['statusStart'] != ''){
					$serviceStart = substr($ipt['statusStart'], 0, 2) . '/' . substr($ipt['statusStart'], 3, 2) . '/' . substr($ipt['statusStart'], 6);
					$start_date = date('Y-m-d', strtotime($serviceStart));
					$query->where('service_date', '>=', $start_date);
				}
			})->where( function($query) use($ipt){
				if(isset($ipt['statusEnd']) && $ipt['statusEnd'] != ''){
					$serviceEnd = substr($ipt['statusEnd'], 0, 2) . '/' . substr($ipt['statusEnd'], 3, 2) . '/' . substr($ipt['statusEnd'], 6);
					$end_date = date('Y-m-d', strtotime($serviceEnd));
					$query->where('service_date', '<=', $end_date);
				}
			});*/

//		dd('Inputs', $ipt, 'fieldTest', $field, 'Temp2', $temp2);
		
		return view('reports.bio', $return)
			->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
	}
}
