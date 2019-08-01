<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Material;
use Crypt;
use Illuminate\Http\Request;

class InventoryController extends Controller {

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
		$data['ipt'] = \Input::all();
		$data['bc'] = 'New Inventory';
		$data['mat'] = \App\Material::all();
		$data['inv_date'] = $data['ipt']['inv_date'];
		$splode = explode('/', $data['ipt']['inv_date']);
		$data['month'] = $splode[0];
		$office = \App\Office::where('id', $data['ipt']['office'])->first();
		$data['year'] = $splode[1];
		$data['office'] = $office->officeName;
 		return view ( 'inventory.create_inv', $data )
			->withEncryptedCsrfToken ( Crypt::encrypt ( csrf_token () ) )
			;
	}

	public function add(){
		$ipt = \Input::all();
		$invAdd = new \App\Invantory($ipt);
		if($invAdd->id){
			return [ 'status' => 'success' ];
		}else{
			return ['status' => 'bad'];
		}
	}
	public function createSave(){
		$ipt = \Input::all();
		$tempArr = [];
		foreach($ipt['mat-cost'] as $mk => $mv){
			$tempArr[$mk]['mat-cost'] = $mv;
			$tempArr[$mk]['mat-beg'] = $ipt['mat-beg'][$mk];
			$tempArr[$mk]['mat-end'] = $ipt['mat-end'][$mk];
		}
		dd($tempArr);
	}
	/**
	 * Create new Material or Herb NOT FOUNTAIN.
	 *
	 * @return JSON msg
	 */
	public function newMaterial()
	{
		//
		$ipt = \Input::all();
		$mat = new \App\Material($ipt);
		$mat->save();
		if($mat){
			$return = 'good';
		}else{
			$return = 'bad';
		}
		return $return;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function autocomplete()
	{
		//
		$ipt = \Input::all();
		$return['suggestions'] = [];

			$act = \App\Material::where('code', 'like', '%' . $ipt['query'] . '%')
				->orWhere('name', 'like', '%' . $ipt['query'] . '%')->select('id', 'code', 'name')->get();


		if (count($act) < 1) {
			$return['suggestions'][] = ['value' => '00000 - Mat not found.', 'data' => 'error'];
		} else {
			foreach ($act as $a) {
				$return['suggestions'][] = ['value' => $a->code . ' - ' . $a->name, 'data' => $a->code, 'part' => $a->id];
			}
		}

		return $return;
	}

	public function autoselect(){
		$ipt = \Input::all();
		$mat = \App\Material::where('code', $ipt['query'])->first();
		return $mat;
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editMaterial()
	{
		//
		$ipt = \Input::all();
		$mat = \App\Material::where('id', $ipt['id'] )->update($ipt);
		if(isset($ipt['other']) && $ipt['other'] == '' ){
			$mat->update( ['other' => null] ); 
		}
		if($mat) {
			$return = 'good';
		}else{
			$return = 'bad' ;
		}
		return $return;
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
