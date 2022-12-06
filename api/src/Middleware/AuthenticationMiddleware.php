<?php
namespace App\Middleware;

use Cake\Http\Cookie\Cookie;
use Cake\I18n\Time;
use Psr\Http\Message\ResponseInterface;
use Cake\Http\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Cake\Http\Exception\ForbiddenException;

use App\Controller\Security\AuthenticationController;

class AuthenticationMiddleware implements MiddlewareInterface {

	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
		$auth = new AuthenticationController();
		return $handler->handle($request);
		if(!$request->getCookie('token')) { //and auth token correctly
			return $this->_accessDenied();
		} else if(!$auth->validToken($request->getCookie('token'))) {
			return $this->_accessDenied();
		} else {
			return $handler->handle($request);
		}
	}

	private function _accessDenied():Response {
		$response = new Response();
		$response = $response->withStatus(403, 'Not Logged In');
		$response = $response->withType('json');
		$response = $response->withStringBody(json_encode(['statusmessage' => 'Login token not found or incorrect']));

		return $response;
	}
}

?>