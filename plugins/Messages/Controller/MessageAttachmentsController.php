<?php

App::uses('ExpediteHasManyPropertyController', 'Controller');

class MessageAttachmentsController extends ExpediteHasManyPropertyController {
	public $parentModule = 'Message';
	public function add($parent_id = null) {
		if($this->{$this->modelClass}->{$this->parentModule}->exists($parent_id)) {
			$this->{$this->modelClass}->{$this->parentModule}->id = $parent_id;
			if($this->Permissions->can('create')) {
				if($this->request->is('post')) {
					$this->{$this->modelClass}->create(array($this->{$this->modelClass}->belongsTo[$this->parentModule]['foreignKey'] => $this->{$this->modelClass}->{$this->parentModule}->id));
					$this->{$this->modelClass}->set($this->request->data);
					if($this->{$this->modelClass}->save()) {
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
				$this->set('parent_id', $this->{$this->modelClass}->{$this->parentModule}->id);
			} else {
				throw new ForbiddenException("Cannot Access this Area");
			}
		} else {
			throw new NotFoundException($this->parentModule . ' does not exist!');
		}
	}
}