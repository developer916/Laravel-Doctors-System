<?php
/**
 * Created by PhpStorm.
 * User: TCP85_000
 * Date: 10/18/2016
 * Time: 5:24 AM
 */

namespace App\Services;

use App\FieldData;
use \DB;
use Illuminate\Http\Request;
use App\Account;
use App\FieldService;
use App\Material;
use App\Technician;

class FieldActivityService
{


	public function autocomplete(){

	}
	public function checkFieldActivityExists(Request $request){
		$accountId = Account::where('id', $request->input('act'))->first();
		$serviceDate = $this->cleanDate($request->input('date'));
		$checkService = FieldService::where('account_id', $accountId->id)
						->where('service_date', $serviceDate)->first();
		$faid = ($checkService && isset($checkService->id) ? $checkService->id : null);
		return [ 'status' => $checkService ? 'true' : 'false', 'faid' => $faid ];
	}

	public function getFieldService(Request $request){
		$field = FieldService::with('fieldData')->find($request->input('id'));
		if($field){
			$mats = Material::all();
			$temp = [];
			foreach($mats as $mat){
				$temp[$mat->id] = array(
					'code' => $mat->code,
					'unit' => $mat->units,
					'cost' => $mat->cost
				);
			}
			$tech = Technician::find($field->tech_id);
			$return = array(
				'field' => $field,
				'mats' => $temp,
				'tech' => $tech->code,
				'status' => 'good'
			);
		}else{
			$return['status'] = 'bad';
		}

		return $return;
	}

	public function createFieldActivity(Request $request){
		$act = Account::find($request->input('act'));

		$service = new FieldService();

		$service->tech_id      = $request->input('tech');
		$service->hours        = $request->input('hours');
		$service->notes        = $request->input('notes');
		$service->service_date = $this->cleanDate($request->input('date') );

		$act->field()->save($service);

		$field = FieldService::where('account_id', $act->id)->where('service_date', $this->cleanDate($request->input('date')))->first();

		$fa = new FieldData();

		$fa->material_id = $request->input('newcode');
		$fa->quantity    = $request->input('newqty');

		$field->fieldData()->save( $fa );

		return [ 'status' => 'good'];
	}

	protected function cleanDate($date){
		$splode = '';
		if(strpos($date, '/') !== false){
			$splode = explode('/', $date);
		}elseif(strpos($date, '-') !== false){
			$splode = explode('-', $date);
		}
		return $splode[2] . '-' . $splode[0] . '-' . $splode[1];
	}
}