<?php 

App::uses('AppShell', 'Console/Command');
App::uses('File', 'Utility'); 

class UsersShell extends AppShell {
	public $uses = array('Users.User');

	public function main() {
		
	}
}