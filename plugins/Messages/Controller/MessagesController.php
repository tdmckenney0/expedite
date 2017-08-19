<?php

App::uses('ExpeditePluginController', 'Controller');

class MessagesController extends ExpeditePluginController {
	public function index($status = 0, $show = 10, $search = '') {
		if(!empty($this->request->data[$this->modelClass]['search'])) {
			$this->redirect(array(1, 10, $this->request->data[$this->modelClass]['search']));
		}
		
		$this->paginate['conditions'][$this->modelClass . '.sent'] = $status;
		$this->paginate['limit'] = $show;
		$this->paginate['conditions'][$this->modelClass . '.search LIKE '] = '%' . $search . '%';		
		
		$this->Paginator->settings = $this->paginate;	
		$this->request->data = $this->Paginator->paginate($this->modelClass);
		$this->set('data', $this->request->data);
		$this->set(compact('search', 'status', 'show'));
	}
}