<?php

App::uses('Component', 'Controller');

/* Stack in Session that stores messages meant for the User. */

class StackMessagesComponent extends Component {

	public function initialize(Controller $controller) {
		if(!CakeSession::check('StackMessages')) {
			CakeSession::write('StackMessages', array());
		}
		return parent::initialize($controller);
	}
	
	/* Pushes a message into the Session Stack. */
	
	public static function push($message, $type) {
		$_SESSION['StackMessages'][] = array(
			'message' => $message,
			'type' => $type
		);
		return true;
	}
	
	/* Pops the last message out of the stack. */

	public static function pop() {
		return array_pop($_SESSION['StackMessages']); 
	}
	
	/* returns the entire stack array and clears the session */
	
	public static function flush() {
		$_ret = $_SESSION['StackMessages'];
		$_SESSION['StackMessages'] = array();
		return $_ret;
	}
	
	/* Empties the stack */
	
	public static function destroy() {
		$_SESSION['StackMessages'] = array();
		return true;
	}
	
	/* Checks if stack is empty */
	
	public static function exists() {
		return (!empty($_SESSION['StackMessages']));
	}
}