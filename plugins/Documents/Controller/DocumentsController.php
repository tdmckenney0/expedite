<?php
	
App::uses('ExpeditePluginController', 'Controller');

class DocumentsController extends ExpeditePluginController {
	
	public function add() {
		if($this->Permissions->can('create')) {
			if($this->request->is('post')) {
				if($this->{$this->modelClass}->store($this->request->data['Document']['File'])) {
					$msg = array('success' => true);
					$this->StackMessages->push(Inflector::humanize(Inflector::underscore($this->modelClass)) . ' Has Been Added', 'success');
					$this->set('msg', $msg); 
					$this->set('_serialize', array('msg'));
				} else {
					$this->set('errors', $this->{$this->modelClass}->validationErrors);				
					$this->set('_serialize', array('errors'));
					$this->StackMessages->push(Inflector::humanize(Inflector::underscore($this->modelClass)) . ' Was Not Added', 'error');
				}
			}
		} else {
			throw new ForbiddenException("Cannot Access this Area");
		}
	}
	
	public function view($filename = null) { 
		$filename = $this->Document->findByFilename($filename);
		if(!empty($filename['Document']['File'])) {
			$this->response->file($filename['Document']['File']->path, array('download' => true, 'name' => $filename['Document']['filename_clean']));
			return $this->response;
		} else {
			$this->StackMessages->push("Could not find file...", 'error');
			$this->redirect(array('action' => 'index'));
		}
	}
}