<?php

App::uses('SurveysAppModel', 'Surveys.Model');

class SurveyQuestionChoice extends SurveysAppModel {

	public $displayField = 'choice';
    
	public $validate = array(
		'choice' => array(
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
        'SurveyQuestion' => array(
			'className' => 'Surveys.SurveyQuestion',
			'foreignKey' => 'survey_question_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
    );

	/* public $hasMany = array(
		'SurveyQuestion' => array(
			'className' => 'Surveys.SurveyQuestion',
			'foreignKey' => '',
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
	); */
}