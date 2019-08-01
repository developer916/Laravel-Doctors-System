<?php namespace App\Http\Controllers;



use App\Office;
use App\User;
use App\Salesman;

class DashController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
		$return['actActive'] = Account::with('act_status')->where('status_id', 0)->count();
		$return['actInactive'] = Account::with('act_status')->where('status_id','<>', 0)->count();
		$return['offices'] = Office::all();
		$return['salesman'] = \App\Salesman::all();
		$return['officesCount'] = count($return['offices']);
		$return['user_levels'] = \App\UserLevel::all();
		$return[ 'bc' ] = 'Main Menu';
		$return['perms'] = \App\Permission::all();
		$return['wide'] = false;
		$return['offices'] = $user;
            return view('dash.dash', $return);
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
