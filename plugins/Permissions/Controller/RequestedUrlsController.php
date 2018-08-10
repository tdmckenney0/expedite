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
		if ($this->request->isAjax()) {
			$this->{$this->modelClass}->id = $id;
			if($this->Permissions->can('update')) {
				if (!$this->{$this->modelClass}->exists($id)) {
					throw new NotFoundException(__('Invalid '. $this->modelClass));
				}
				if(!empty($this->request->data)) {
					$this->{$this->modelClass}->set($this->request->data);
					if($this->{$this->modelClass}->validates()) {
						$this->{$this->modelClass}->save();
						$msg = array('success' => true);
						$this->set('msg', $msg);
						$this->set('_serialize', array('msg'));
						$this->StackMessages->push(Inflector::humanize(Inflector::underscore($this->modelClass)) . ' Has Been Updated', 'success');
					} else {
						$this->set('errors', $this->{$this->modelClass}->validationErrors);
						$this->set('_serialize', array('errors'));
					}
				} else {
					$this->request->data = $this->{$this->modelClass}->read();
				}
			} else {
				throw new ForbiddenException("Cannot Access this Area");
			}
		} else {
			throw new MethodNotAllowedException(__('Ajax Only'));
		}
	}
}
