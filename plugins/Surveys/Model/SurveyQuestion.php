<?php

App::uses('SurveysAppModel', 'Surveys.Model');

class SurveyQuestion extends SurveysAppModel {

	public $displayField = 'question';
    
	public $validate = array(
		'question' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
    
    public $belongsTo = array(
		'SurveySection' => array(
			'className' => 'Surveys.SurveySection',
			'foreignKey' => 'survey_section_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'SurveyQuestionType' => array(
			'className' => 'Surveys.SurveyQuestionType',
			'foreignKey' => 'survey_question_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
    );

	public $hasMany = array(
		'SurveyQuestionChoice' => array(
			'className' => 'Surveys.SurveyQuestionChoice',
			'foreignKey' => 'survey_question_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
        'SurveyQuestionResponse' => array(
			'className' => 'Surveys.SurveyQuestionResponse',
			'foreignKey' => 'survey_question_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
}