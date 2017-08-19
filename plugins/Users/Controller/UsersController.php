<?php

App::uses('ExpeditePluginController', 'Controller');

class UsersController extends ExpeditePluginController {
	
	public $paginate = array(
        'limit' => 10,
        'order' => array(
            'User.last_name' => 'asc',
		 	'User.first_name' => 'asc'
        ),
		'conditions' => array(
			'User.is_active' => 1
		)
    );
	
	// Callbacks //

	public function beforeFilter() {
		$userGroups = $this->User->UserGroup->find('list');
		$offices = $this->User->Office->find('list');
		$managers = $this->User->find('list');
		$this->set(compact('userGroups', 'offices', 'managers'));
		
        $this->Auth->allow('isSessionValid');
		
		return parent::beforeFilter(); 
    }
	
	// Authentication Methods //

	public function login() {
		$this->layout = 'login';
		if ($this->Auth->login()) {
			$this->Session->write(AuthComponent::$sessionKey . '.UserGroup', Hash::combine($this->Session->read(AuthComponent::$sessionKey), "UserGroup.{n}.id", "UserGroup.{n}.name"));
			return $this->redirect($this->Auth->redirectUrl());
		} else {
			if ($this->request->is('post')) {
				$this->Session->setFlash(__('Invalid username or password, try again'));
			} 
		}
        $this->loadModel('Offices.Region');
		$this->set('users', $this->User->find('list', array('fields' => array('User.username', 'User.fullname'))));
		$this->set('regions', $this->Region->find('list'));
		$this->render(); 
	}
	
	public function logout() {
		$this->Session->destroy(); 
		$this->redirect($this->Auth->logout());
	}
	
	// Direct URL Methods //
	
	public function index($status = 1, $show = 10, $search = '') {
		$this->paginate['conditions'][$this->modelClass . '.is_active'] = $status;
		parent::index($status, $show, $search);	
	}
	
	public function delete($id = null) {
		// Deleted Users go Inactive to ensure data stability and history. //
		if($this->Permissions->can('delete')) {
			if($this->request->isAjax()) {
				$this->{$this->modelClass}->id = $id;
				if (!$this->{$this->modelClass}->exists()) {
					throw new NotFoundException(__('Invalid ' . $this->modelClass));
				}
				if($this->{$this->modelClass}->saveField('is_active', false)) {
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
	
	public function upload_image($id = null) {
		if($this->User->exists($id)) {
			$this->User->id = $id;
			if($this->Permissions->can('update')) {
				if (!$this->User->exists()) {
					throw new NotFoundException(__('Invalid User'));
				}
				$this->User->set($this->request->data);
				$this->User->set('id', $this->User->id);
				if($this->User->validates()) {
					$this->User->save();
					return $this->response; 
				} else {
					throw new BadRequestException('Invalid File'); 
				}
			} else {
				throw new ForbiddenException("Cannot Access this Area");
			}
		} else {
			throw new NotFoundException('No User Selected');
		}
	}
	
	// RequestAction URL Methods //
	
	public function getUserInfo($id = null) {
		if(!empty($this->request->params['requested'])) {
			if(!empty($id)) {
				return $this->User->find('first', array('contain' => 'Office', 'conditions' => array('User.id' => $id)));
			} else {
				throw new BadRequestException("Need a User ID"); 
			}
		} else {
			throw new ForbiddenException("Not Allowed"); 
		}
	}
	
	public function getAllUsers() {
		if(!empty($this->request->params['requested'])) {
			return $this->User->find('list');
		} else {
			throw new ForbiddenException("Not Allowed"); 
		}
	}
	
	// Ajax Heartbeat //
	
	public function isSessionValid() {
		$this->Auth->allow();
		if ($this->request->isAjax()) {
			$this->set('alive', (boolean) AuthComponent::user()); 
			$this->set('_serialize', array('alive'));
			$this->render();
		} else {
			throw new MethodNotAllowedException('Ajax Only'); 
		}
	}
}