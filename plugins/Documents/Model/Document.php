<?php
	
App::uses('DocumentsAppModel', 'Documents.Model');
App::uses('AuthComponent', 'Controller/Component');
App::uses('File', 'Utility');
App::uses('Folder', 'Utility');

class Document extends DocumentsAppModel {

	public $displayField = 'filename';
	public $actsAs = array('Containable'); 
    public $order = "Document.created DESC";
	public $virtualFields = array(
		'search' => 'CONCAT_WS("|",
			Document.filename,
			Document.description,
			Document.mimetype,
			Document.created
		)' 
	);
	
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'usage' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'filename' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'description' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'mimetype' => array(
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
	
	// Internal Parsing Functions //
	
	protected function getPath($name = null) {
		$path = array(ROOT, 'plugins', 'Documents', 'Storage');
		if(!empty($name)) {
			$path[] = $name;
		}
		return implode(DS, $path);
	}
	
	protected function getExtensionFromFilename($filename = null) {
		if(!empty($filename)) {
			$ext = explode('.', $filename);
			$ext = array_pop($ext);
			return $ext;
		} else {
			return false;
		}
	}
	
	protected function encodeFilename(File $file = null, $ext = null) {
		if(empty($ext)) {
			$ext = $file->ext();
		}		
		$name = hash_file('sha256', $file->path) . '.' . $ext;
		return $name;
	}
	
	protected function moveToStorage(File $file = null, $name = null) {
		if(!empty($file) && !empty($name)) {
			$name = $this->getPath($name);
			$file->copy($name, false);
			$file->delete();
			return new File($name);
		} else {
			return false;
		}
	}
	
	protected function parseFile(File $file = null) {
		if(!empty($file)) {
			$this->data['Document'] = array();
			if(empty($this->data['Document']['description'])) {
				$this->data['Document']['description'] = $file->name;
			}
			$this->data['Document']['mimetype'] = $file->mime();
			$this->data['Document']['filename'] = $this->encodeFilename($file);
			$this->data['Document']['File'] = $file;
			return true;
		} else {
			return false;
		}
	}
	
	protected function parseUpload(Array $data = array()) {
		if(!empty($data)) { 
			$this->data['Document'] = array();
			if(empty($this->data['Document']['description'])) {
				$this->data['Document']['description'] = $data['name'];
			}
			$this->data['Document']['mimetype'] = $data['type'];
			$this->data['Document']['File'] = new File($data['tmp_name']);
			$this->data['Document']['filename'] = $this->encodeFilename($this->data['Document']['File'], $this->getExtensionFromFilename($data['name']));
			return true;
		} else {
			return false;
		}
	}
	
	// Model Callback Functions //
	
	public function afterFind($results, $primary = false) {
		foreach($results as $key => $result) {
			if(!empty($result['Document']['filename'])) {
				$results[$key]['Document']['filename_clean'] = Inflector::slug($result['Document']['description']) . '.' . $this->getExtensionFromFilename($result['Document']['filename']);
				$results[$key]['Document']['File'] = new File($this->getPath($result['Document']['filename']), false);
			}
		}
		return parent::afterFind($results, $primary);
	}
	
	public function beforeDelete($cascade = true) {
		if($this->exists()) {
			$this->data = $this->read();
			if($this->data['Document']['usage'] < 2) {
				if(!$this->data['Document']['File']->delete()) {
					return false;
				}
			} else {
				$this->saveField('usage', --$this->data['Document']['usage']);
				return false;
			}
		}
		return parent::beforeDelete($cascade);
	}
	
	// Main Storage Function //
	
	public function store($data = null) {
		if(!empty($data)) {
			
			// Prep the Model //
			
			$this->create();
			
			// Parse the file into proper database format //
			
			if(is_a($data, 'File')) {
				$this->parseFile($data);
			} else {
				$this->parseUpload($data);
			}
			
			// Set the User Name //
		
			if(AuthComponent::user('id')) {
				$this->data['Document']['user_id'] = AuthComponent::user('id');
			} else {
				$this->data['Document']['user_id'] = null;
			}
			
			// Look for an entry //  
			
			$filename = $this->findByFilename($this->data['Document']['filename']); 
			
			if(!empty($filename['Document']['id'])) {
				// File Exists, Break off, Return that ID. //
				$this->clear();
				$this->id = $filename['Document']['id'];
				$this->saveField('usage', ++$filename['Document']['usage']);
				$this->read();
				return $filename['Document']['id'];
			} else {
				// File Doesn't exist, insert, return ID. //
				$this->data['Document']['File'] = $this->moveToStorage($this->data['Document']['File'], $this->data['Document']['filename']);
				if($this->save()) {
					$this->read();
					return $this->id;
				} else { 
					return false;
				}
			}
		} else {
			return false;
		}
	}
    
    // Clean Up Function //
    
    public function clean() {
        
        $folder = new Folder($this->getPath());
        $files = $folder->find();
        
        foreach($files as $file) {
            if(!in_array($file, array('.', '..'))) {
                
                $test = $this->findByFilename($file);
                
                if(empty($test['Document']['id'])) {
                    
                    if(unlink($this->getPath() . DS . $file)) {
                        $this->log("File Deleted: " . $file, LOG_INFO);
                    } else {
                        $this->log("Could not delete file: " . $file, LOG_INFO);
                    }
                }
            }
        }
    }
}