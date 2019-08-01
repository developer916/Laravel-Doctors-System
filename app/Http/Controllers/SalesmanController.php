<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Office;
use App\Salesman;
use Illuminate\Http\Request;
use App\Salesman as Sale;
use Carbon\Carbon;
use App\Office as Off;
use Crypt;

class SalesmanController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //
        return view( 'account.account' );
    }

	public function autocomplete(Request $request){
		$sales = Salesman::where('code', 'like', $request->input('query') . '%')->get();
		$return = [];
		if($sales){

			foreach($sales as $sale){

				$return['suggestions'][] = ['value' => $sale->abvr . ' - ' . $sale->name, 'data' => $sale->id];
			}
		}else{
			$return['suggestions'][] = ['value' => '000 - Salesman doesn\'t exist.', 'data' => 'NaN'];
		}
		return $return;
	}

    public function getSales( ) {
		$offices = \App\Office::all();
		$officeData = new \stdClass();
		$officeData->count = $offices->count();
		$left = ceil($officeData->count / 2);
		$right = floor($officeData->count / 2);
		$index = 0;

		for ($i = 0; $i < $officeData->count; $i++) {
			if ($i < $left) {
				$officeData->left[] = $offices[$i];
			}
			else {
				$officeData->right[] = $offices[$i];

			}
		}

		$return['userLevels'] = \App\UserLevel::all();
        $return['report'] = Tech::join('offices', 'salesman.office_id', '=', 'offices.id')
			->select('salesmen.id', 'salesmen.abvr', 'salesmen.name', 'salesmen.office_id', 'offices.abvr', 'offices.officeName')
            ->orderBy('code', 'asc')
            ->get();
        $return[ 'bc' ] = 'Salesmen Management';
        $return[ 'offices' ] = Office::all();
        $return[ 'officesData' ] = $officeData;
		$return['monthHours'] = \App\FieldService::where('service_date', '>=', Carbon::now()->startOfMonth() )->sum('hours');
//		?$return['monthHours'] = \App\FieldService::where('service_date', date('M'))->sum('hours');
		$return['totalHours'] = \App\FieldService::sum('hours');
        $active = Tech::where('active', true)->get();
        $inactive = Tech::where('active', false)->get();
        $return[ 'active' ] = $active->count();
        $return[ 'inactive' ] = $inactive->count();
		$return['users'] = \App\User::orderBy('last_name', 'ASC')->get(  );
        $return['wide'] = true;
//        dd($return);
        return view( 'technicians.techManagement',  $return)
			->withEncryptedCsrfToken ( Crypt::encrypt ( csrf_token () ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
		$ipt = \Input::all();
		$newTech = new Technician($ipt);
		$newTech->active = 1;
		$newTech->save();

		if( isset($newTech->id) && $newTech->id ){
			return 'good';
		}else{
			return 'bad';
		}
	}

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show( $id ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit() {
        //
		$ipt = \Input::all();
		$id = $ipt['id'];
		unset($ipt['id']);
		unset($ipt['_token']);
		$editTech = Tech::find($id);
		$editTech->update($ipt);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update( $id ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(  ) {
        //
		$ipt = \Input::all();
		$deadTech = Tech::where('id', $ipt['id'])->first();
		$deadTech->delete();
		return 'good';
    }

}
