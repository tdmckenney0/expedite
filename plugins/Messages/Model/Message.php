<?php

App::uses('MessagesAppModel', 'Messages.Model');
App::uses('Document', 'Documents.Model');
App::uses('Hash', 'Utility');
App::uses('CakeEmail', 'Network/Email');

class Message extends MessagesAppModel {

	public $displayField = 'subject';
	public $enumerations = array();
	public $order = 'Message.modified DESC';
	public $virtualFields = array(
		'search' => 'Message.subject'
	);

	public $validate = array(
		'sent' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'subject' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'body' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public $belongsTo = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
		'MessageAttachment' => array(
			'className' => 'Messages.MessageAttachment',
			'foreignKey' => 'message_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'MessageBlindCopy' => array(
			'className' => 'Messages.MessageBlindCopy',
			'foreignKey' => 'message_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'MessageCopy' => array(
			'className' => 'Messages.MessageCopy',
			'foreignKey' => 'message_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'MessageRecipient' => array(
			'className' => 'Messages.MessageRecipient',
			'foreignKey' => 'message_id',
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

	public function push($message = '', $subject = '', $to = array(), $cc = array(), $bcc = array(), $attachments = array()) {

		// Create the Message Itself //

		$this->create();
		$this->data['Message']['body'] = $message;
		$this->data['Message']['subject'] = $subject;

		if(AuthComponent::user('id')) {
			$this->data['Message']['user_id'] = AuthComponent::user('id');
		}

		if(!$this->save()) {
			return false;
		}

		// Parse Recievers

		if(!empty($to)) {
			foreach($to as $id => $email) {
				$this->MessageRecipient->create();
				$this->MessageRecipient->data['MessageRecipient']['message_id'] = $this->id;
				$this->MessageRecipient->data['MessageRecipient']['email'] = $email;
				$this->MessageRecipient->save();
			}
		} else {
			$this->delete();
			return false;
		}

		// Parse Carbon Copy

		if(!empty($cc)) {
			foreach($cc as $id => $email) {
				$this->MessageCopy->create();
				$this->MessageCopy->data['MessageCopy']['message_id'] = $this->id;
				$this->MessageCopy->data['MessageCopy']['email'] = $email;
				$this->MessageCopy->save();
			}
		}

		// Parse Blind Carbon Copy

		if(!empty($bcc)) {
			foreach($bcc as $id => $email) {
				$this->MessageBlindCopy->create();
				$this->MessageBlindCopy->data['MessageBlindCopy']['message_id'] = $this->id;
				$this->MessageBlindCopy->data['MessageBlindCopy']['email'] = $email;
				$this->MessageBlindCopy->save();
			}
		}

		// Parse File Attachments //

		if(!empty($attachments)) {
			foreach($attachments as $name => $file) {
				$this->MessageAttachment->create();
				$this->MessageAttachment->data['MessageAttachment']['message_id'] = $this->id;
				$this->MessageAttachment->data['MessageAttachment']['filename'] = $file;
				$this->MessageAttachment->save();
			}
		}

		return true;
	}

	public function pop() {

		$messages = $this->find('all', array('conditions' => array('Message.sent' => false)));

		foreach($messages as $message) {

			$this->id = $message['Message']['id'];

			$to = Hash::extract($message, 'MessageRecipient.{n}.email');
			$cc = Hash::extract($message, 'MessageCopy.{n}.email');
			$bcc = Hash::extract($message, 'MessageBlindCopy.{n}.email');

			$email = new CakeEmail('default');
			$email->emailFormat('html');
			$email->subject($message['Message']['subject']);
			$email->to($to);
			$email->cc($cc);
			$email->bcc($bcc);

			if(!empty($message['MessageAttachment'])) {

				$attachments = array();
				$document = new Document();

				foreach($message['MessageAttachment'] as $attachment) {
					$file = $document->findByFilename($attachment['filename']);
					$attachments[$file['Document']['filename_clean']] = $file['Document']['File']->path;
				}
				$email->attachments($attachments);
			}

			if($email->send($message['Message']['body'])) {
				$this->saveField('sent', true);
			}
		}

		return true;
	}
}
