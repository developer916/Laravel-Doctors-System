<?php namespace App\Http\Controllers;

use App\FieldData;
use App\FieldService;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class UpdateController extends Controller {
	public function updateReport(){
		$ipt = \Input::all();
		$report = \App\FieldService::where('id', $ipt['service_id'])->first();
		$report->tech_id = intval($ipt['tech_id']);
		$report->hours = floatval($ipt['man_hours']);
		$report->service_date = date('Y-m-d', strtotime($ipt['service_date']));
		$report->save();
		

		return json_encode(['code' => 'success']);
	}

	//field activity report
	public function updateMaterial(){
		$ipt = \Input::all();
		$field = \App\FieldData::where('id', $ipt['fd'])->first();
		$field->material_id = intval($ipt['mat']);
		$field->quantity = floatval($ipt['qty']);
		$field->save();
		return json_encode( [ 'code' => 'success' ] );
	}
	//field activity report
	public function newMaterial(){
		$ipt = \Input::all();
		$field = new \App\FieldData([
			'field_service_id' => $ipt['fd'],
			'material_id' => $ipt['mat'],
			'quantity' => $ipt['qty'],
		]);
		$field->save();
		return json_encode([ 'code' => 'success' , 'id' => $field->id ]);
	}

	//field activity report
	public function removeMaterial(){
		$ipt = \Input::all();

		$fieldService = \App\FieldData::where('id', intval($ipt['id']))->first();

		$fieldServiceId = $fieldService->field_service_id;

		$count = \App\FieldData::where('field_service_id', $fieldServiceId)->count();

		\App\FieldData::where('id', intval($ipt['id']))->delete();

		if ( !($count > 1) )
		{
			\App\FieldService::where('id', $fieldService->field_service_id)->delete();
		}

		return response()->json([
			'count' => $count,
			'code'  => 'success'
		]);
	}

	//field activity report
	public function removeAllMaterial(){
		$ipt = \Input::all();

		if (intval($ipt['id']) > 0) 
		{
			$countMaterials = \App\FieldData::where('field_service_id', $ipt['id'])->count();

			if ( $countMaterials > 0 )
			{
				\App\FieldData::where('field_service_id', intval($ipt['id']))->delete();
			}

			$countService = \App\FieldService::where('id', $ipt['id'])->count();

			if ( $countService > 0 )
			{
				\App\FieldService::where('id', intval($ipt['id']))->delete();
			}

			$result = 'success';

		}
		else
		{
			$result = 'fail';
		}	
		
		return response()->json([
			'code'  => $result
		]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
