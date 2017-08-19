<?php 

App::uses('AppShell', 'Console/Command');

class MessagesShell extends AppShell {
	public $uses = array('Messages.Message');
	public function main() {
		
	}
	
	public function deploy() {
		$this->Message->pop();
	}
}