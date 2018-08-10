<?php

App::uses('SurveysAppModel', 'Surveys.Model');

class SurveySection extends SurveysAppModel {

	public $displayField = 'name';
    
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
    
    public $belongsTo = array(
		'Survey' => array(
			'className' => 'Surveys.Survey',
			'foreignKey' => 'survey_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
    );

	public $hasMany = array(
		'SurveyQuestion' => array(
			'className' => 'Surveys.SurveyQuestion',
			'foreignKey' => 'survey_section_id',
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