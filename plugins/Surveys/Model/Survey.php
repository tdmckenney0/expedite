<?php

App::uses('SurveysAppModel', 'Surveys.Model');

class Survey extends SurveysAppModel {

	public $displayField = 'name';
    public $virtualFields = array(
        'search' => 'Survey.name'
    );

	public $validate = array(
		'name' => array(
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

	public $hasMany = array(
		'SurveySection' => array(
			'className' => 'Surveys.SurveySection',
			'foreignKey' => 'survey_id',
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
