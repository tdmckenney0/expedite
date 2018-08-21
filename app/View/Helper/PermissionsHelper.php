<?php

App::uses('AppHelper', 'View/Helper');
App::uses('Permissions', 'Controller/Component');

class PermissionsHelper extends AppHelper {

	/*
		The '$ability' parameter exists for backwards compatibility with existing code.
		Originally, the permissions were going to separate the create, update, view, and delete permissions
		for a single path. It turns out that it is simply overkill.

		Tanner Mckenney
		July 10, 2014
	*/

	public function has($controller = null, $action = null) {
		if(empty($controller)) {
			$controller = $this->request->params['controller'];
		}
		if(empty($action)) {
			$action = $this->request->params['action'];
		}
		return PermissionsComponent::check($controller, $action);
	}

	public function can($controller = null, $action = null) {
		return PermissionsComponent::check($controller, $action);
	}

	public function in($group = null) {
		return PermissionsComponent::in($group);
	}
}
