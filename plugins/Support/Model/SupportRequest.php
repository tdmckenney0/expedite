<?php

App::uses('SupportAppModel', 'Support.Model');
App::uses('Message', 'Messages.Model');
App::uses('CakeTime', 'Utility');

class SupportRequest extends SupportAppModel {

	public $displayField = 'title';
	public $enumerations = array();
	public $actsAs = array('Containable', 'Enumeration', 'Null'); 
	public $virtualFields = array(
		'name' => 'SupportRequest.title',
		'search' => 'SupportRequest.title'
	);

	public $validate = array(
		'support_request_type_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'requested_user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_closed' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'closing_date' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'description' => array(
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
		'SupportRequestType' => array(
			'className' => 'SupportRequestType',
			'foreignKey' => 'support_request_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SupportRequestStatus' => array(
			'className' => 'SupportRequestStatus',
			'foreignKey' => 'support_request_status_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'requested_user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ClosingUser' => array(
			'className' => 'Users.User',
			'foreignKey' => 'closing_user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		) 
	);
	
	public function beforeSave($options = array()) {
	
		/* Requested User */
		
			if(empty($this->data['SupportRequest']['requested_user_id'])) {
				$this->data['SupportRequest']['requested_user_id'] = AuthComponent::user('id');
			}		
			
		/* Closing User*/
		
			if(!empty($this->data['SupportRequest']['is_closed'])) {
				$this->data['SupportRequest']['closing_user_id'] = AuthComponent::user('id');
				$this->data['SupportRequest']['closing_date'] = CakeTime::toServer(new DateTime());
			}
			
		return parent::beforeSave($options);
	}
	
	public function afterSave($created, $options = array()) {
		$this->read();
		$message = new Message();
		$users = $this->User->UserGroup->getUserEmailListInGroup(21); // Expedite Group
		$message->push($this->data['SupportRequest']['description'] . '<br />' . $this->data['SupportRequest']['notes'], $this->data['SupportRequest']['title'] . ' [' . $this->data['SupportRequestStatus']['name'] . ']', $users, null, null, null);
		return parent::afterSave($created, $options);
	}
}