<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

use Cake\Utility\Security;
use Cake\View\JsonView;
use Cake\Auth\WeakPasswordHasher;
use App\Controller\Component\Enum\Success;

class ApiController extends Controller {
	public $success = Success::NONE;

	public function initialize(): void {
		parent::initialize();
		$this->loadComponent('RequestHandler');
        $this->viewBuilder()->setClassName('Json');
	}

	public function beforeFilter(EventInterface $event) {
		$this->_returnJSON();
	}

	protected function _returnJSON() {
		$this->response = $this->response->cors($this->request)
		->allowOrigin('*.jessprogramming.com')
		->build();
		$this->response = $this->response->withHeader('Access-Control-Allow-Credentials', 'true');
		$this->viewBuilder()->setOption('serialize',true);

	}

	protected function _isPushingData() {
		return ($this->request->is('post') || $this->request->is('patch'));
	}

	protected function _isListingData() {
		return ($this->request->is('get') || $this->request->is('list'));
	}

	public function setSuccess($result) {

		if($this->getSuccess() === Success::NONE) {
			$this->success = $result ? Success::SUCCESS : Success:: FAIL;
		} else if ($this->getSuccess() === Success::PARTIAL) {

		} else {
			if ($this->getSuccess() === Success::SUCCESS) {
				$this->success = $result ? $this->getSuccess() : Success::FAIL;
			} else if ($this->getSuccess() === Success::FAIL) {
				$this->success = $result ? Success::PARTIAL : $this->getSuccess();
			}
		}
	}

	public function getSuccess(): Success {
		return $this->success;
	}
}

?>