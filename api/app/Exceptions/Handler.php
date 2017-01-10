<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Models\Util;
use JWTException;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		//\Illuminate\Auth\AuthenticationException::class,
		//\Illuminate\Auth\Access\AuthorizationException::class,
		\Symfony\Component\HttpKernel\Exception\HttpException::class,
		\Illuminate\Database\Eloquent\ModelNotFoundException::class,
		//\Illuminate\Session\TokenMismatchException::class,
		//\Illuminate\Validation\ValidationException::class,
		//Tymon\JWTAuth\Exceptions\JWTException::class,
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $exception
	 * @return void
	 */
	public function report(Exception $exception) {
		parent::report($exception);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $exception
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $exception) {
		$type = get_class($exception);
		$code = 500;
		if (isset($exception->httpStatusCode)) {
			$code = $exception->httpStatusCode;
		}

		$error = "undefined";
		if (isset($exception->errorType)) {
			$error = $exception->errorType;
		}
		$message = $exception->getMessage();
		$data = [];

		switch (true) {
			case $exception instanceof \Illuminate\Database\QueryException:
				switch ($exception->getCode()) {
					case "23505":
						$error = "duplicate_register";
						$message = "Requisição duplicada";
					break;
				}
				break;
			case $exception instanceof \League\OAuth2\Server\Exception\OAuthException:
				switch ($exception->errorType) {
					case "invalid_request":
						$message = "Requisição inválida";
						break;
					case "invalid_client":
						$message = "Cliente não Autorizado";
						break;
					case "invalid_credentials":
						$message = "Usuário/Senha incorretos";
						break;
				}
				break;
			default:

				break;
		}
		$data = [
			"error" => $error
			, 'message' => $message
		];

		$debug = [
			"type" => $type
			, 'message' => $exception->getMessage()
			, 'trace' => $exception->getTrace()
		];

		$response = Util::setReturn($code, $data, $debug);
		return $response;
//		return parent::render($request, $exception);
	}

	/**
	 * Convert an authentication exception into an unauthenticated response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Illuminate\Auth\AuthenticationException  $exception
	 * @return \Illuminate\Http\Response
	 */
	protected function unauthenticated($request, AuthenticationException $exception) {
		if ($request->expectsJson()) {
			return response()->json(['error' => 'Unauthenticated.'], 401);
		}

		return redirect()->guest('login');
	}

}
