<?php

App::uses('SurveysAppModel', 'Surveys.Model');

class SurveyQuestionResponse extends SurveysAppModel {

	public $displayField = 'response';
	public $validate = array(); // Gets glitchy. 
    
    public $belongsTo = array(
        'SurveyQuestion' => array(
			'className' => 'Surveys.SurveyQuestion',
			'foreignKey' => 'survey_question_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
         'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
    );
    
    public function beforeSave($options = array()) { 
        if(!empty($this->data[$this->alias]['response'])) {
            
            $this->data[$this->alias]['user_id'] = AuthComponent::user('id');
            
            return parent::beforeSave($options);
        } else {
            return false;
        }
    }
}