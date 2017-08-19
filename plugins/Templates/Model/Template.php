<?php

App::uses('TemplatesAppModel', 'Templates.Model');

class Template extends TemplatesAppModel {

	public $virtualFields = array(
		'search' => 'Template.name'
	);

	public $validate = array(
		'template_type_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
		'body' => array(
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
		'TemplateType' => array(
			'className' => 'TemplateType',
			'foreignKey' => 'template_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function removeVariableBlock($body = null, $block = null) {
		if(!empty($body) && !empty($block)) {
			
			$block = '<!--[' . $block . ']-->';
			
			$left = stripos($body, $block);
			$right = strripos($body , $block) + strlen($block);
			$body = substr_replace($body, '', $left, ($right - $left));			
		} 
		return $body;
	}
}