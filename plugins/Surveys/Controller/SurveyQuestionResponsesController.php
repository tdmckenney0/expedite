<?php

App::uses('ExpediteHasManyPropertyController', 'Controller');

class SurveyQuestionResponsesController extends ExpediteHasManyPropertyController {
    public $parentModule = 'SurveyQuestion';
    
    public function beforeFilter() {
		if($this->Auth->user('is_superuser') == false) {
			$this->StackMessages->push('Permission Denied.', 'error');
			$this->redirect('/');
		}
		return parent::beforeFilter();
	}
}