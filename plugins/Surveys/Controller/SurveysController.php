<?php

App::uses('ExpeditePluginController', 'Controller');

class SurveysController extends ExpeditePluginController {
    
    public function beforeFilter() {
		if($this->Auth->user('is_superuser') == false) {
			$this->StackMessages->push('Permission Denied.', 'error');
			$this->redirect('/');
		}
        return parent::beforeFilter();
	}
    
	public function view($id = null) {
        
        $this->Survey->contain(array(
            'SurveySection' => array(
                'SurveyQuestion' => array(
                    'SurveyQuestionType',
                    'SurveyQuestionChoice',
                    'SurveyQuestionResponse' => array(
                        'conditions' => array('SurveyQuestionResponse.user_id' => AuthComponent::user('id'))
                    )
                )
            )
        ));
        
        $boolean = array('Yes', 'No');
        $boolean = array_combine($boolean, $boolean);
        
        $this->set('boolean', $boolean);
        $this->set('form_defaults', array('label' => false, 'div' => false));
        
        parent::view($id);
    }
}