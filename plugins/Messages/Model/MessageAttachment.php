<?php

App::uses('MessagesAppModel', 'Messages.Model');

class MessageAttachment extends MessagesAppModel {
	public $displayField = 'filename';
	public $actsAs = array('Containable', 'Null', 'Documents.Documents' => array('fieldname' => 'filename'));
	public $validate = array(
		'message_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);

	public $belongsTo = array(
		'Message' => array(
			'className' => 'Messages.Message',
			'foreignKey' => 'message_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}