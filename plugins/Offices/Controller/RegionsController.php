<?php

App::uses('ExpeditePluginController', 'Controller');

class RegionsController extends ExpeditePluginController {
	public function getList() {
		if (!empty($this->request->params['requested'])) {
			return $this->{$this->modelClass}->find('list');
		} else {
			throw new MethodNotAllowedException('Request Action Only'); 
		}
	}
}