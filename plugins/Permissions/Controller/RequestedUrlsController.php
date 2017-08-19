<?php

App::uses('ExpeditePluginController', 'Controller');
App::uses('ExpediteHasManyPropertyController', 'Controller');

class RequestedUrlsController extends ExpeditePluginController {	
	public function beforeFilter() {
		if($this->Auth->user('is_superuser') == false) {
			$this->StackMessages->push('Permission Denied.', 'error');
			$this->redirect('/');
		}
		return parent::beforeFilter(); 
	}
	
	public function edit($id = null) {
		ExpediteHasManyPropertyController::edit($id);
	}
}