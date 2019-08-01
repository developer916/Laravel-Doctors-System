<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\FieldActivityService;

class FieldActivityController extends Controller
{

	public function autocomplete(Request $request){
		dd($request->input('query'));
		$return['suggestions'][] = ['value' => 'dave', 'data' => 'lister', 'part' => '3'];
		return $return;
	}
	public function checkexist(Request $request){
		$fa = new FieldActivityService();
		return $fa->checkFieldActivityExists($request);
	}
	public function getFieldService(Request $request){
		$fa = new FieldActivityService();
		return $fa->getFieldService($request);
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
    public function create(Request $request)
    {
        
		$fa = new FieldActivityService($request);
		return $fa->createFieldActivity($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
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
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
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
