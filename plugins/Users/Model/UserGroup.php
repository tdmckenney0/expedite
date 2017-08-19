<?php

App::uses('AppModel', 'Model');

class UserGroup extends AppModel {

	public $displayField = 'name';
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

	public $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'Users.User',
			'joinTable' => 'users_user_groups',
			'foreignKey' => 'user_group_id',
			'associationForeignKey' => 'user_id',
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
	
	public $hasMany = array(
		'RequestedUrl' => array(
			'className' => 'Permissions.RequestedUrl',
			'foreignKey' => 'user_group_id',
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
	
	public function getUserListInGroup($id = null) {
		if($this->exists($id)) {
			$data = $this->find('first', array(
				'contain' => array(
					'User' => array(
						'conditions' => array('User.is_active' => true),
                        'fields' => array('id', 'fullname')
					)
				),
				'conditions' => array(
					'UserGroup.id' => $id
				),
			));
			return Hash::combine($data['User'], '{n}.id', '{n}.fullname'); 
		} else {
			return false;
		}
	}
	
	public function getUserEmailListInGroup($id = null) {
		if($this->exists($id)) {
			$data = $this->find('first', array(
				'contain' => array(
                    'User' => array(
                        'id', 
                        'email',
                        'conditions' => array('User.is_active' => true)
                    )
                ),
				'conditions' => array(
                    'UserGroup.id' => $id 
                ),
			));
			return Hash::combine($data['User'], '{n}.id', '{n}.email'); 
		} else {
			return false;
		}
	}
}