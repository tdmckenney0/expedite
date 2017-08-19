<?php

App::uses('ExpediteHasManyPropertyController', 'Controller');

abstract class ExpediteHasOnePropertyController extends ExpediteHasManyPropertyController {
	
	public function add($parent_id = null) {
		throw new ForbiddenException("Cannot Access this Area");
	}

	public function edit($parent_id = null) {
		if($this->{$this->modelClass}->{$this->parentModule}->exists($parent_id)) {
			$this->{$this->modelClass}->id = $parent_id; 
			if($this->Permissions->can('update')) {
				if ($this->request->isAjax()) {
					if ($this->request->is('post') || $this->request->is('put')) {
						if (!$this->{$this->modelClass}->exists($this->{$this->modelClass}->id)) {
							$this->{$this->modelClass}->create(array($this->{$this->modelClass}->primaryKey => $this->{$this->modelClass}->id));
						} 
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
						$data = $this->{$this->modelClass}->find('first', array(
							'conditions' => array(
								$this->modelClass . '.' . $this->{$this->modelClass}->primaryKey => $this->{$this->modelClass}->id
							)
						));
						$this->set(compact('parent_id', 'data'));
					}
				} else {
					throw new MethodNotAllowedException('Ajax Only'); 
				}
			} else {
				throw new ForbiddenException('You are not allowed to access this area.');
			}
		} else {
			throw new NotFoundException('No ' . $this->parentModule . ' Selected');
		}
	}
}