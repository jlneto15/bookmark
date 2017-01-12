<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Util;
use App\Models\Bookmark;
use JWTAuth;

class BookmarkController extends Controller {

	public function __construct() {
		$this->middleware('jwt.auth', ['except' => []]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		
//		$user = JWTAuth::parseToken()->toUser();
//		dd($user);
		
		$return = Bookmark::all();
		return Util::setReturn(Response::HTTP_OK, $return);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		
		$bookmark = new Bookmark($request->all());

		$user = JWTAuth::parseToken()->toUser();
		$bookmark->user_id = $user->id;
		
		$return = [
			"created" => $bookmark->save(),
			"bookmark" => $bookmark
		];

		return Util::setReturn(Response::HTTP_CREATED, $return);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		$return = Bookmark::findOrFail($id);
		return Util::setReturn(Response::HTTP_OK, $return);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$bookmark = Bookmark::findOrFail($id);
		$bookmark->fill($request->all());

		$return = [
			"updated" => $bookmark->save(),
			"bookmark" => $bookmark
		];

		return Util::setReturn(Response::HTTP_OK, $return);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$bookmark = Bookmark::findOrFail($id);
		$return = [
			"deleted" => $bookmark->delete()
		];
		
		return Util::setReturn(Response::HTTP_NO_CONTENT, $return);
	}

}
