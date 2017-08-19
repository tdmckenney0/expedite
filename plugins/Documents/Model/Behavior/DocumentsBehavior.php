<?php

App::uses('ModelBehavior', 'Model');
App::uses('Document', 'Documents.Model');

class DocumentsBehavior extends ModelBehavior {

	public $settings = array();
    public $Document = null; 

	public function setup(Model $Model, $settings = array()) {
		if(!empty($settings['fieldname'])) {
			$this->settings[$Model->alias] = $settings; 
		}
        if(empty($this->Document)) {
             $this->Document = new Document();
        }
		return parent::setup($Model, $settings); 
	}

	/* 
		Model Callbacks
	*/
	
	public function beforeSave(Model $Model, $options = array()) {
		if(!empty($Model->data[$Model->alias][$this->settings[$Model->alias]['fieldname']])) {
			if($this->Document->store($Model->data[$Model->alias][$this->settings[$Model->alias]['fieldname']])) {
				$Model->data[$Model->alias][$this->settings[$Model->alias]['fieldname']] = $this->Document->data['Document']['filename'];
			} else {
				return false;
			}
		}
		return parent::beforeSave($Model, $options);
	}
	
	public function afterFind(Model $Model, $results = array(), $primary = false) {
		if(!empty($results)) { 
			if(!empty($results[$Model->alias][$this->settings[$Model->alias]['fieldname']])) {
				$results[$Model->alias][$this->settings[$Model->alias]['fieldname']] = $this->Document->findByFilename($results[$Model->alias][$this->settings[$Model->alias]['fieldname']]);
			} else {
				foreach($results as $key => $val) { 
					if(!empty($val[$Model->alias][$this->settings[$Model->alias]['fieldname']])) {
						 $results[$key][$Model->alias][$this->settings[$Model->alias]['fieldname']] = $this->Document->findByFilename($val[$Model->alias][$this->settings[$Model->alias]['fieldname']]);
					}
				}
			}
		} 
		return parent::afterFind($Model, $results, $primary);
	} 
	
	public function beforeDelete(Model $Model, $cascade = true) {
		$Model->read();
		$filename = $this->Document->findByFilename($Model->data[$Model->alias][$this->settings[$Model->alias]['fieldname']]);
		if(!empty($filename['Document']['id'])) {
			$this->Document->id = $filename['Document']['id'];
			if($filename['Document']['usage'] > 1) {
				$this->Document->saveField('usage', --$filename['Document']['usage']);
			} else {
				$this->Document->delete();
			}
		}
	}
}