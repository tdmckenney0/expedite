<?php

App::uses('ExpeditePluginController', 'Controller');

class TemplatesController extends ExpeditePluginController {

	public function beforeFilter() {
		if(!$this->Permissions->can()) {
			$this->StackMessages->push('Permission Denied.', 'error');
			$this->redirect('/');
		}
		return parent::beforeFilter();
	}

	public function view($id = null) {
		$this->set('templateTypes', $this->Template->TemplateType->find('list'));
		parent::view($id);
	}
	
	public function add() {
		$this->set('templateTypes', $this->Template->TemplateType->find('list'));
		parent::add();
	}
}