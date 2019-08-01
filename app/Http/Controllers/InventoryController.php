<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Invantory;
use App\Material;
use App\Office;
use App\Traits\InventoriesTrait;
use Crypt;
use Illuminate\Http\Request;

class InventoryController extends Controller
{

	use InventoriesTrait;

	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create( )
	{
		$data['ipt'] = \Input::all();
		$data['bc'] = 'New Inventory';
		$data['mat'] = \App\Material::all();
		$data['inv_date'] = $data['ipt']['inv_date'];
		$splode = explode('/', $data['ipt']['inv_date']);
		$data['month'] = $splode[0];

		if ( $data['ipt']['office'] )
		{
			$office = \App\Office::where('id', $data['ipt']['office'])->firstOrFail();

			$data['year']      = $splode[1];
			$data['office']    = $office->officeName;
			$data['office_id'] = $office->id;
		}

		return view ( 'inventory.create_inv', $data );
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

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function storeInventory(Request $request)
	{
		foreach ($request->data as $data)
		{
			$this->createInventory( $data );
		}

		$redirectLink = route('edit_inv') . "?office_id={$request->office_id}&month={$request->month}";

		return redirect( $redirectLink )->with( 'message', 'Inventory created.' );
	}

	/**
	 * @param $officeId
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getInventories( $officeId )
	{
		$inventories = Invantory::getByOfficeGroupByMonth( $officeId );

		return response()->json([
			'inventories' => $inventories
		]);
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function editInventory( Request $request )
	{
		$month    = $request->month;
		$officeId = $request->office_id;

		$office = Office::findOrFail($officeId);
		$date   = \DateTime::createFromFormat("Y-m-d", $month);

		$yearAndMonth = "{$date->format("Y")}-{$date->format("m")}";

		$inventories = Invantory::getByOfficeAndMonth( $officeId, $yearAndMonth );

		return view('inventory.edit_inv', [
			'inventories' => $inventories,
			'office'      => $office,
			'inv_date'    => $yearAndMonth,
			'bc'          => 'Edit Inventory'
		]);
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function updateInventory( Request $request )
	{
		if (!empty($request->materials))
		{
			$this->updateMaterials( $request->materials );
		}

		if (!empty($request->purchased_amount))
		{
			$this->updatePurchasedAmounts( $request->purchased_amount );
		}

		if (!empty( $request->end_amount ))
		{
			$this->updateEndAmounts( $request->end_amount );
		}

		if (!empty( $request->begin_amount ))
		{
			$this->updateBeginAmounts( $request->begin_amount );
		}

		if (!empty( $request->cost ))
		{
			$this->updateCosts( $request->cost );
		}

		return back()->with('success', 'Inventory has been updated.');
	}

	/**
	 * @param Request $request
	 * @return array|\Illuminate\Http\JsonResponse
	 */
	public function autocompleteReport( Request $request )
	{
		$keyword = $request->keyword;

		$materials = Material::searchByKeyword( $keyword );

		$suggestions = [];

		if (count( $materials ))
		{
			foreach ( $materials as $material )
			{
				$suggestions[] = [
					'name'  => $material->name,
					'code'  => $material->code,
					'id'    => $material->id,
					'units' => $material->units
				];
			}
		}

		return response()->json($suggestions);
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
