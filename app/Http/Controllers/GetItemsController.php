<?php namespace App\Http\Controllers;

use App\FieldService;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Account;
use App\TaxDistrict;
use App\Location;
use App\Contact;
use App\Status;
use App\State;

use Illuminate\Http\Request;

class GetItemsController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){
        //
    }

    public function taxStateDistrict(){
        //
        $ipt = \Input::all();
        $return = TaxDistrict::orderBy('id_code', 'asc')->where('state_id', $ipt['state_id'])->get();
//		dd($return);
        return json_encode($return);
    }
    
    public function taxStateDistrictEdit(){
        //
		$truthy = true;
        $ipt = \Input::all();
		foreach($ipt['data'] as $i){
			$id = $i['id'];
			unset($i['id']);
			$mat = \App\TaxDistrict::find($id)->update($i);
			if(!$mat){
				$truty = false;
			}
		}
		if($truthy){
			$return = 1;
		}else{
			$return = 0;
		}
        return json_encode($return);
    }

    public function getAccountAutocomplete(){
        $ipt = \Input::all();
        $return['suggestions'] = [];
        $return['nan'] = is_numeric($ipt['query']);
        if (is_numeric($ipt['query'])) {

            $act = Account::where('accountNumber', 'like', $ipt['query'] . '%')->select('id', 'accountNumber', 'actName')->get();
        } else {
            $act = Account::where('actName', 'like', '%' . $ipt['query'] . '%')->select('id', 'accountNumber', 'actName')->get();

        }

        if (count($act) < 1) {
            $return['suggestions'][] = ['value' => '00000 - No accounts found.', 'data' => 'error'];
        } else {
            foreach ($act as $a) {
                $return['suggestions'][] = ['value' => str_pad($a->accountNumber, 6, "0", STR_PAD_LEFT) . ' - ' . $a->actName, 'data' => str_pad($a->accountNumber, 6, "0", STR_PAD_LEFT), 'part' => $a->id];
            }
        }

        return $return;
    }

    public function autoselect(){
        $ipt = \Input::all();
        //query
        $act = Account::where('accountNumber', str_pad($ipt['query'], 6, "0", STR_PAD_LEFT))
            ->with('accounting')
            ->with('actStatus')
            ->with('office')
            ->with('note')
            ->with('actTax')
            ->with('salesmen')
            ->with('actTerms')
            ->with('actInfo')
            ->with('actType')
            ->with('actService')
            ->first();
        $act->accountNumber = str_pad($act->accountNumber, 6, "0", STR_PAD_LEFT);
        $act->location = Location::find($act->location_id);
        $act->location->state = State::select('name')->find($act->location->state_id);
        $act->status = Status::select('name', 'code')->find($act->actStatus->status_id);
        $act->contact = Contact::find($act->contact_id);
        $act->lastField = FieldService::where('account_id', $act->id)->orderBy('service_date', 'DESC')->first();
        if(is_null($act->lastField)){
            $obj = new \stdClass();
            $obj->service_date = 'None Found';
            $act->lastField = $obj;
        }
        return $act;
    }

    public function autoCompleteMat(){
        $ipt = \Input::all();
        $return['suggestions'] = [];
        $mat = \App\Material::where('code', 'LIKE', '%' . $ipt['query'] . '%')
            ->orWhere('name', 'LIKE', '%' . $ipt['query'] . '%')->get();

        foreach ($mat as $m) {
            $return['suggestions'][] = ['value' => $m->code . ' - ' . $m->name, 'data' => $m->id, 'part' => $m->units, 'unit' => $m->units, 'cost' => $m->cost];
        }
        return $return;
    }

    public function autoselectMat(){
        $ipt = \Input::all();
        $mat = \App\Material::select('code', 'units', 'cost')->where('id', $ipt['query'])->first();
        return $mat;
    }

    public function getSalesmenList(){
        return \App\Salesman::select('id', 'abvr', 'name')->get();
    }

    public function deleteSalesmen($id){
        $salesman = \App\Salesman::where('id', $id)->delete();
        return 'success';
    }

    public function addSalesmen(){
        $ipt = \Input::all();
        $salesman = new \App\Salesman([
            "abvr" => $ipt["abvr"],
            "name" => $ipt["name"]
        ]);
        $salesman->save();
        if ($salesman->id) {
            return ['result' => 'success'];
        } else {
            return ['result' => 'error'];
        }
    }
}