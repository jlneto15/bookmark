<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Util;

class AuthController extends Controller {

	public function login(Request $request) {
		// grab credentials from the request
		$credentials = $request->only('email', 'password');

		try {
			// attempt to verify the credentials and create a token for the user
			if (!$token = JWTAuth::attempt($credentials)) {
				return Util::setReturn(Response::HTTP_UNAUTHORIZED, ['error' => 'invalid_credentials']);
			}
		} catch (JWTException $e) {
			// something went wrong whilst attempting to encode the token
			return Util::setReturn(Response::HTTP_INTERNAL_SERVER_ERROR, ['error' => 'could_not_create_token']);
		}

		// all good so return the token
		return Util::setReturn(Response::HTTP_OK, ['token' => $token, 'user' => JWTAuth::toUser($token)]);
	}

}
