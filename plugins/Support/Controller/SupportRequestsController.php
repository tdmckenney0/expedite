<?php

App::uses('ExpeditePluginController', 'Controller');

class SupportRequestsController extends ExpeditePluginController {
	public $paginate = array(
        'limit' => 10,
        'order' => array('SupportRequestStatus.sort' => 'asc')
    );
	
	public function index($status = 0, $show = 10, $search = '') {
		if(!empty($status)) {
			$this->paginate['conditions'][$this->modelClass . '.support_request_status_id'] = $status;
		} else {
			$this->paginate['conditions'][$this->modelClass . '.support_request_status_id'] = array(1, 3, 4);
		}
		parent::index($status, $show, $search);
	}
	
	public function beforeFilter() {
		$this->set('supportRequestTypes', $this->SupportRequest->SupportRequestType->find('list'));
		$this->set('supportRequestStatuses', $this->SupportRequest->SupportRequestStatus->find('list'));
		$this->set('users', $this->SupportRequest->User->find('list'));
		return parent::beforeFilter(); 
	}
}