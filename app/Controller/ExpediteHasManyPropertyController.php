<?php

App::uses('AppController', 'Controller');

abstract class ExpediteHasManyPropertyController extends AppController {

	public $parentModule;
	public $layout = 'ajax';
	
	public function index($parent_id = null) {
		if($this->{$this->modelClass}->{$this->parentModule}->exists($parent_id)) {
			if ($this->request->isAjax()) {		
				$this->{$this->modelClass}->{$this->parentModule}->id = $parent_id;
				$this->request->data = $this->{$this->modelClass}->find('all', array(
					'conditions' => array(
						$this->modelClass . '.' . $this->{$this->modelClass}->belongsTo[$this->parentModule]['foreignKey'] => $this->{$this->modelClass}->{$this->parentModule}->id
					)
				));
				$this->set('data', $this->request->data);
			} else {
				throw new MethodNotAllowedException('Ajax Only'); 
			}
		} else {
			throw new NotFoundException('No ' . $this->parentModule . ' Selected');
		}
	}
	
	public function view() {
		throw new ForbiddenException("Cannot Access this Area");
	}
	
	public function add($parent_id = null) {
		if($this->{$this->modelClass}->{$this->parentModule}->exists($parent_id)) {
			$this->{$this->modelClass}->{$this->parentModule}->id = $parent_id;
			if ($this->request->isAjax()) {		
				if($this->Permissions->can('create')) {
					if($this->request->is('post')) {
						$this->{$this->modelClass}->create(array($this->{$this->modelClass}->belongsTo[$this->parentModule]['foreignKey'] => $this->{$this->modelClass}->{$this->parentModule}->id));
						$this->{$this->modelClass}->set($this->request->data);
						if($this->{$this->modelClass}->validates()) {
							$this->{$this->modelClass}->save();
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
				throw new MethodNotAllowedException('Ajax Only'); 
			}
		} else {
			throw new NotFoundException($this->parentModule . ' does not exist!');
		}
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
	
	public function delete($id = null) {
		if($this->Permissions->can('delete')) {
			if ($this->request->isAjax()) {
				$this->{$this->modelClass}->id = $id;
				if (!$this->{$this->modelClass}->exists()) {
					throw new NotFoundException(__('Invalid ' . $this->modelClass));
				}
				if ($this->{$this->modelClass}->delete()) {
					$msg = array('success' => true, 'msg' => ($this->modelClass . ' Deleted'));
					$this->StackMessages->push(Inflector::humanize(Inflector::underscore($this->modelClass)) . ' Has Been Deleted', 'success');
				} else {
					$msg = array('success' => true, 'msg' => ($this->modelClass . ' Failed to Delete'));
					$this->StackMessages->push(Inflector::humanize(Inflector::underscore($this->modelClass)) . ' Failed to Delete', 'error');
				}
				$this->set('msg', $msg); 
				$this->set('_serialize', array('msg'));
				$this->render(); 
			} else {
				throw new MethodNotAllowedException('Ajax Only'); 
			}
		} else {
			throw new ForbiddenException('Permission Denied'); 
		}
	}	
}