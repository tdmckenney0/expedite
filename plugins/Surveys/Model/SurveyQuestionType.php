<?php

App::uses('SurveysAppModel', 'Surveys.Model');

class SurveyQuestionType extends SurveysAppModel {
	public $displayField = 'name';
	public $hasMany = array(
		'SurveyQuestion' => array(
			'className' => 'Surveys.SurveyQuestion',
			'foreignKey' => 'survey_question_type_id',
			'dependent' => false,
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