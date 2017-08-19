<?php

App::uses('ExpeditePluginController', 'Controller');

class OfficesController extends ExpeditePluginController {
	public function getList() {
		if (!empty($this->request->params['requested'])) {
			return $this->{$this->modelClass}->find('list');
		} else {
			throw new MethodNotAllowedException('Request Action Only'); 
		}
	}
}