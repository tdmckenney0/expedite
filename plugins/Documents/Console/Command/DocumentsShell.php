<?php 

App::uses('AppShell', 'Console/Command');

class DocumentsShell extends AppShell {
	public $uses = array('Documents.Document');
	public function main() {
		
	}
	
	public function clean() {
        $this->Document->clean();
	}
}