<?php

App::uses('Controller', 'Controller');
App::uses('Component', 'Controller');
App::uses('AuthComponent', 'Controller');
App::uses('User', 'Users.Model');
App::uses('Hash', 'Utility');

/*
	The Permissions Component Provides a Static API for Controller and View to determine if a
*/

class PermissionsComponent extends Component {

	public $controller = null;

	public function initialize(Controller $controller) {
		$this->controller = $controller;
	}

	public function can() {
		return self::check($this->controller->request->params['controller'], $this->controller->request->params['action']);
	}

	public static function check($controller = null, $action = null) {

		/*
			We Don't do nulls here.
		*/

			if(empty($controller) || empty($action)) {
				return false;
			}

		/*
			Check if User is Logged in.
		*/

			if(AuthComponent::user() == false) {
				return false; /* User Isn't Logged in. */
			}

		/*
			Check if User is Active.
		*/

			if(AuthComponent::user('is_active') == false) {
				return false; /* User Isn't Active. */
			}

		/*
			Check if User is a Superuser.
		*/

			if(AuthComponent::user('is_superuser') == true) {
				return true;
			}

		/*
			Create the User Model
		*/

			$user = ClassRegistry::init('Users.User');
			$user->id = AuthComponent::user('id');

		/*
			Check for permissions
		*/

			$permission = array();

			$permission = $user->find('first', array(
				'contain'=> array(
					'UserGroup' => array(
						'RequestedUrl' => array(
							'conditions' => array(
								'RequestedUrl.controller' => $controller,
								'RequestedUrl.action' => $action
							)
						)
					)
				),
				'conditions' => array(
					'User.id' => $user->id
				)
			));

			$permission = Hash::extract($permission, 'UserGroup.{n}.RequestedUrl.{n}.id');

		/*
			If Empty, Check Global Permissions.
		*/

			if(empty($permission)) {
				$permission = $user->UserGroup->RequestedUrl->find('list', array(
					'conditions' => array(
						'RequestedUrl.controller' => $controller,
						'RequestedUrl.action' => $action,
						'RequestedUrl.user_group_id' => null
					)
				));
			}

		/*
			Return Empty Check.
		*/

			return (!empty($permission));

		/*
			 End of Function
		*/
	}

	public static function in($group = array()) {
		if(AuthComponent::user() !== false) {
			if(!is_array($group)) {
				$group = array($group);
			}

			$user = ClassRegistry::init('Users.User');
			$user->id = AuthComponent::user('id');
			$user->contain(array('UserGroup'));
			$user->data = $user->read();

			$groups = Hash::extract($user->data, "UserGroup.{n}.id");
			$groups = array_intersect($group, $groups);

			if(count($groups) > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
