<?php

App::uses('AppController', 'Controller');

abstract class ExpeditePluginController extends AppController {

	public $components = array('Paginator');
	public $paginate = array(
		'limit' => 10
	);

	/* Display Method */

		public function display() {
			$path = func_get_args();

			$count = count($path);
			if (!$count) {
				$this->redirect('/');
			}
			$page = $subpage = $title_for_layout = null;

			if (!empty($path[0])) {
				$page = $path[0];
			}
			if (!empty($path[1])) {
				$subpage = $path[1];
			}
			if (!empty($path[$count - 1])) {
				$title_for_layout = Inflector::humanize($path[$count - 1]);
			}
			$this->set(compact('page', 'subpage', 'title_for_layout'));
			$this->render(implode('/', $path));
		}

	/* Search Method */

		public function index($status = 1, $show = 10, $search = '') {

			if(!empty($this->request->data[$this->modelClass]['search'])) {
				$this->redirect(array(1, 10, $this->request->data[$this->modelClass]['search']));
			}

			//$this->paginate['conditions'][$this->modelClass . '.status'] = $status;
			$this->paginate['limit'] = $show;
			$this->paginate['conditions'][$this->modelClass . '.search LIKE '] = '%' . $search . '%';

			$this->Paginator->settings = $this->paginate;
			$this->request->data = $this->Paginator->paginate($this->modelClass);
			$this->set('data', $this->request->data);
			$this->set(compact('search', 'status', 'show'));
		}

	/* The View for the Compartment */

		public function view($id = null) {
			if(!$this->{$this->modelClass}->exists($id)) {
				$this->StackMessages->push('Does not exist.', 'error');
				$this->redirect(array('action' => 'index'));
			}
			$this->{$this->modelClass}->id = $id;
			if ($this->request->isAjax()) {
				if($this->Permissions->can('update')) {
					$this->{$this->modelClass}->set($this->request->data);
					if($this->{$this->modelClass}->validates()) {
						if ($this->{$this->modelClass}->save()) {
							$msg = array('success' => true);
						} else {
							$msg = array('success' => false);
						}
						$this->set('msg', $msg);
						$this->set('_serialize', array('msg'));
						$this->StackMessages->push(Inflector::humanize(Inflector::underscore($this->modelClass)) . ' Has Been Updated', 'success');
					} else {
						$this->set('errors', $this->{$this->modelClass}->validationErrors);
						$this->set('_serialize', array('errors'));
					}
				} else {
					$this->set('errors', array('permission' => false));
					$this->set('_serialize', array('errors'));
				}
			} else {
				$options = array('conditions' => array($this->modelClass . '.' . $this->{$this->modelClass}->primaryKey => $id));
				$this->request->data = $this->{$this->modelClass}->find('first', $options);
			}
		}
	
	/* Adds a new entry to the Compartment. */

		public function add() {
			if($this->Permissions->can()) {
				if ($this->request->is('post')) {
					$this->{$this->modelClass}->set($this->request->data);
					if($this->{$this->modelClass}->validates()) {
						$this->{$this->modelClass}->save();
						$msg = array('success' => true);
						$this->set('msg', $msg);
						$this->set('_serialize', array('msg'));
						$this->StackMessages->push(Inflector::humanize(Inflector::underscore($this->modelClass)) . ' Has Been Added', 'success');
					} else {
						$this->set('errors', $this->{$this->modelClass}->validationErrors);
						$this->set('_serialize', array('errors'));
						$this->StackMessages->push(Inflector::humanize(Inflector::underscore($this->modelClass)) . ' Was Not Added', 'error');
					}
				}
			} else {
				$this->set('errors', array('permission' => false));
				$this->set('_serialize', array('errors'));
			}
		}

	/* Delete Function */

		public function delete($id = null) {

			if (!$this->{$this->modelClass}->exists($id)) {
				$this->StackMessages->push('Invalid ' . Inflector::humanize($this->modelClass), 'error');
				$this->redirect(array('action' => 'index'));
			}

			if($this->Permissions->can('delete')) {
				if ($this->request->isAjax()) {
					$this->{$this->modelClass}->id = $id;

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
					$this->StackMessages->push('AJAX Only.', 'error');
					$this->redirect(array('action' => 'index'));
				}
			} else {
				$this->StackMessages->push('Permission Denied', 'error');
				$this->redirect(array('action' => 'index'));
			}
		}

	/* Restrict the Edit function */

		public function edit() {
			$this->StackMessages->push('Permission Denied', 'error');
			$this->redirect(array('action' => 'index'));
		}

	/* End */
}
