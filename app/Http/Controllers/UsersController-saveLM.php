<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{

	public function userAutocomplete()
	{
		$return = [];
		$ipt = \Input::All();
		$users = \App\User::where('email', 'LIKE', '%' . $ipt['query'] . '%')
			->orWhere('first_name', 'LIKE', '%' . $ipt['query'] . '%')
			->orWhere('middle_name', 'LIKE', '%' . $ipt['query'] . '%')
			->orWhere('last_name', 'LIKE', '%' . $ipt['query'] . '%')
			->get();
		if (!$users->isEmpty()) {
			foreach ($users as $m) {
				if(isset($m->deleted_at)){
					continue;
				}
				$return['suggestions'][] = ['value' => $m->last_name
					. ', ' . $m->first_name
					. ' ' . $m->middle_name
					. ': ' . $m->email,
					'data' => $m->id,
					'part' => $m->level];
			}
			if(!isset($return['suggestions']) || count($return['suggestions']) < 1){
				$return['suggestions'][] = ['value' => $ipt['query'] . " not found",
					'data' => '0',
					'part' => 'error'];
			}
		}
		else {
			$return['suggestions'][] = ['value' => $ipt['query'] . " not found",
				'data' => '0',
				'part' => 'error'];
		}
		return $return;
	}

	public function userAutoselect()
	{
		$ipt = \Input::All();
		$userLevels = \App\UserLevel::all();
		$offices = \App\Office::all();

		$user = \App\User::where('id', $ipt['userId'])->with('offices')->with('permissions')->first();
		$temparr = [];
		if(isset($user->offices) && count($user->offices) > 0) {
			foreach ($user->offices as $uo) {
				$temparr[] = $uo->id;
			}

			$user->office_names = $temparr;
		}
		$temparr = [];

		if(isset($user->permissions) ) {
			foreach ($user->permissions as $uo) {
				$temparr[] = $uo->id;
			}
			$user->perm_names = $temparr;
		}
//		$user->office_names = [];
/*		dd('isset is_dev',isset($user->is_dev),
			'bool is_dev',$user->is_dev,
			'isset user is_super_admin', isset($user->is_super_admin),
			'user is_super_admin',$user->is_super_admin,
			'user is_super_admin',$user->level,
			'uerLevels find user level',$user->level,
			'uerLevels userLevels',$userLevels,
			'user',$user);*/
		$user->level_name = ( (isset($user->is_dev) && $user->is_dev)
			? 'Development'
			: (( isset($user->is_super_admin) && $user->is_super_admin )
				? 'Super Admin'
				: $userLevels->find($user->level)->level_name));
//		$user->office_name = $offices->find($user->office)->officeName;
//		dd($user);
		return $user;
	}

	public function userUpdate()
	{
		$ipt = \Input::all();
		$data = json_decode($ipt['query']);
		$id = $data->id;
		unset($data->id);
        
		$user = \App\User::with('offices')->with('permissions')->find($id);
		$user->update([
			'first_name' => $data->first_name,
			'middle_name' => $data->middle_name,
			'last_name' => $data->last_name,
			'email' => $data->email,
			'level' => $data->level
		]);
        
        if(!empty($data->password)){
            $user->update([
                'password' => $data->password
            ]);
        }
        
//		dd($data->office);
//		$user->offices()->detach();
//		$user->permissions()->detach();
		$user->offices()->sync($data->office);
		$user->permissions()->sync($data->prams);
//		unset($ipt['query']['id']);
		return json_encode(['result' => 'good']);
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
		$ipt = \Input::all();
		$data = json_decode($ipt['query']);
//dd($data);
		$user = new \App\User([
			'first_name' => $data->first_name,
			'middle_name' => $data->middle_name,
			'last_name' => $data->last_name,
			'email' => $data->email,
			'level' => $data->level,
			'password' => 'WeLoveSantoDesignGroup'
		]);
		$user->save();
		if($data->istech){
			$tech = new \App\Technician([
				'active' => 1,
				'user_id' => $user->id,
				'code' => $data->techCode,
				'name' => $data->techName,
				'office' => $data->office[0],
				'rate' => $data->techRate,
			]);
			$tech->save();
		}
		$user->offices()->sync($data->office);
		$user->permissions()->sync($data->prams);
//		unset($ipt['query']['id']);
		return json_encode(['result' => 'good', 'id' => $user->id]);
	}

	public function officeView()
	{
		$ipt = \Input::All();
		$usersByOffice = \App\Office::where('id', $ipt['id'])
			->with('office')
			->first();
		$return['data'] = [];
		foreach ($usersByOffice->office as $of) {
			$users = new \stdClass();
			$users->id = $of->id;
			$users->first_name = $of->first_name;
			$users->middle_name = $of->middle_name;
			$users->last_name = $of->last_name;
			$users->email = $of->email;

			$return['data'][] = $users;
		}
		$return['result'] = 'good';
		return $return;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Request $request
	 * @param  int $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy()
	{
		//
		$ipt = \Input::all();
		$id = $ipt['id'];
		$user = User::find($id); //->delete();
		if (!$user) {
			return ['result' => 'bad', 'msg' => 'User not found.'];
		}
		if (!$user->is_super_admin && !$user->is_dev) {
			//check for tech
			$user->permissions()->detach();
			$user->delete();
			$ipt['success'] = ['result' => 'good', 'msg' => 'User deleted.'];
		} else {
			$ipt['success'] = ['result' => 'bad', 'msg' => 'Cant delete SuperAdmin or Development testing accounts.'];
		}

		return $ipt;
	}
}
