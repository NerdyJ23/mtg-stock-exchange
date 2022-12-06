<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Controller\Controller;
use Cake\Controller\PagesController;
use Cake\View\JsonView;

class ErrorController extends AppController
{
    public function initialize(): void
    {
        $this->loadComponent('RequestHandler');
		$this->viewBuilder()->setClassName('Json');

    }

    public function beforeFilter(EventInterface $event)
    {
    }


    public function beforeRender(EventInterface $event)
    {
        // parent::beforeRender($event);
		// $this->viewBuilder()->setTemplatePath('Error');
		// $this->defaultResponse();
		$this->errorResponse($event);
    }

	public function defaultResponse() {
		$this->response = $this->response->withStatus(404);
	}

	private function errorResponse(EventInterface $event) {
		$this->response = $this->response->withStatus(500);
		$this->set('body', $this->request->getParsedBody());
		$this->set('request',$this->request);
		$this->set('errormessage',$event);
		$this->viewBuilder()->setOption('serialize', true);
	}
    public function afterFilter(EventInterface $event)
    {
    }
}