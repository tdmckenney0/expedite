<?php

App::uses('AppModel', 'Model');

class User extends AppModel {

	public $displayField = 'fullname';
	public $actsAs = array('Containable', 'Documents.Documents' => array('fieldname' => 'image'));
	public $order = array("User.last_name" => 'asc', 'User.first_name' => 'asc');
	public $virtualFields = array(
		'fullname' => 'CONCAT(User.first_name, " ", User.last_name)', 							  
		'name' => 'CONCAT(User.first_name, " ", User.last_name)',
		'search' => 'CONCAT_WS("|",
			User.first_name,
			User.last_name,
			User.email,
			User.phone,
			User.title,
			User.username
		)'
	);
	
	public $validate = array(
		'username' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'update', // Limit validation to 'create' or 'update' operations
			),
		),
		'first_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'last_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'This email is already in use',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'image' => array(
			'extension' => array(
				'rule'=> array('extension', array('jpg', 'png', 'gif')),
				'message' => 'Please Provide a Valid Image'
			)
		)
	);

	public $hasAndBelongsToMany = array(
		'UserGroup' => array(
			'className' => 'Users.UserGroup',
			'joinTable' => 'users_user_groups',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'user_group_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
        'Office' => array(
			'className' => 'Offices.Office',
			'joinTable' => 'users_offices',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'office_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
	
	/* Callbacks */
	
	public function beforeSave($options = array()) {
		$this->update_password();
		return parent::beforeSave($options); 
	}
	
	public function afterSave($created, $options = array()) {
		$this->update_session();
		return parent::afterSave($created, $options); 
	}
	
	/* Methods */
	
	public function findByGroup($id = null) {
		if(!empty($id)) {
			$users = $this->UserGroup->find('first', array(
				'contain' => array('User'),
				'conditions' => array(
					'UserGroup.id' => $id
				)												   
			));
			$_users = array();
			foreach($users['User'] as $user) {
				$_users[$user['id']] = $user['fullname'];
			}
			return $_users;
		} else {
			return false; 
		}
	}
	
	public function update_password() {			
		if(!empty($this->data[$this->alias]['change_password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		} else {
			unset($this->data[$this->alias]['password']);
		}
	}
	
	public function update_session() {
		if($this->id == AuthComponent::User('id')) {
			$user = $this->find('first', array(
				'contain' => false,
				'conditions' => array('User.id' => $this->id)
			));
			unset($user['User']['password']);
			CakeSession::write('Auth.User', array_merge(AuthComponent::User(), $user['User'])); 
		} 
	}
}