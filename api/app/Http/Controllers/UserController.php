<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Util;
use App\Models\User;
use App\Models\Bookmark;
use JWTAuth;

class UserController extends Controller {

	public function __construct() {
		$this->middleware('jwt.auth', ['except' => ['store']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//$return = User::with('bookmark')->get();
		$return = User::all();
		foreach ($return as $user) {
			$user->bookmark = Bookmark::withoutGlobalScopes()->where('user_id', $user->id)->get();
		}

		return Util::setReturn(200, $return);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$user = new User($request->all());
		
		$return = [
			"created" => $user->save(),
			"user" => $user,
			"token" => JWTAuth::fromUser($user)
		];

		return Util::setReturn(200, $return);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		$return = User::find($id);
		return Util::setReturn(200, $return);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$user = User::find($id);
		$user->fill($request->all());
		
		$return = [
			"updated" => $user->save(),
			"user" => $user
		];
		
		return Util::setReturn(200, $return);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}

}
