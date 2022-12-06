<?php

namespace App\Controller\Security;

use Cake\Controller\Controller;

use Cake\Utility\Security;
use Cake\Auth\WeakPasswordHasher;
use Cake\Http\ServerRequest;

class EncryptionController extends Controller {
	const METHOD = 'aes128';

	public function initialize(): void {
		parent::initialize();
	}

	public function encrypt($value) {
		return base64_encode(openssl_encrypt($value, $this::METHOD, $_ENV['SECURITY_SALT'], $options=0,  $_ENV['SECURITY_SALT']));
	}

	public function decrypt($value) {
		return openssl_decrypt(base64_decode($value), $this::METHOD, $_ENV['SECURITY_SALT'], $options=0, $_ENV['SECURITY_SALT']);
	}

	public function hashPassword($pass) {
		return $hashedPass = Security::hash($pass, null, true);
	}
}

?>