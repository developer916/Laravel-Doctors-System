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
		$service->tech_id = $request->input('tech');
		$service->hours = $request->input('hours');
		$service->old_number = $act->accountNumber;
		$service->notes = $request->input('notes');
		$service->service_date = $this->cleanDate($request->input('date') );
		$act->field()->save($service);

		$field = FieldService::where('account_id', $request->input('act'))->where('service_date', $this->cleanDate($request->input('date')))->first();
//		return response(['res' => $request->material_row]);
		foreach ($request->material_row as $row)
		{
			if( trim($row['newcode']) == '' || is_null($row['newcode']))
			{
				continue;
			}
			
			$qty = $row['newqty'];
			$mat = $row['newcode'];

			$matExploded = explode('-', $mat);
			$matCode     = trim($matExploded[0]);

			$material    = Material::where('code', $matCode)->first();

			if( !$material && count($matExploded) > 2 )
			{
				$matCode = trim($matExploded[0]."-".$matExploded[1]);
				$material    = Material::where('code', $matCode)->first();
			}

			$matId = $material->id;

			$actn = $act->accountNumber;
			$fid = $field->id;
			$msg='OK';
			try {
				DB::table('field_data')->insert([
					'material_id' => $matId,
					'quantity'    => $qty,
					'field_service_id' => $fid,
					'old_number' => $actn,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				]);
//				$ret = \DB::insert('insert into field_data (material_id,quantity,field_service_id,old_number) values('.$mat.','.$qty.','.$fid.','.$actn.')');
			}
			catch(\Illuminate\Database\QueryException $ex){
				$msg = $ex->getMessage();
				return response()->json(['msg' => $msg]);
			}
		}
 //		$fa = new FieldData(
//			'material_id' = $mat;
//			'quantity' = $qty;
//			'field_service_id' = $field->id;
//			'old_number' = $act->accountNumber;
//		);
//
//		$fa->save();


//		foreach($request->input('data') as $data){
//			$fa = new FieldData();
//			$fa->material_id = $data['code'];
//			$fa->quantity = $data['quantity'];
//			$field->fieldData()->save($fa);
//		}

		
		return [ 'status' => 'good', 'wfi' => $act->accountNumber.'#'.$mat.'#'.$qty.'#'.$field->id.'#'.$msg ];
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