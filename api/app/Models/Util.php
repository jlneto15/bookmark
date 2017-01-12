<?php

namespace App\Models;

use Response;

class Util {

	/**
	 * @author José Luiz Neto
	 * @param Integer $code HTTP Code
	 * @param Array $code Object to return.
	 * @param Object $debugText (Optional) Debug Text
	 * @return Response
	 */
	public static function setReturn($code, $object, $debugText = null) {
		$return = array(
			'response' => array(
				'code' => $code
		));

		$return['response'] = array_merge($return['response'], ['data' => $object]);

		if (!empty($debugText) && getenv("APP_DEBUG") == "true") {
			$return['debug'] = $debugText;
		}


		try {
			$return = Response::json($return, $code);
		} catch (Exception $ex) {
			$return = Response::json(self::array_utf8_encode($return), $code);
		}

		return $return;
	}

}
