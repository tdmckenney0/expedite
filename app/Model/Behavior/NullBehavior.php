<?php

App::uses('ModelBehavior', 'Model');

class NullBehavior extends ModelBehavior {
	public function beforeSave(Model $model) {
		$schema = $model->schema(); 
		foreach($schema as $field => $data) {
			if(isset($model->data[$model->alias][$field]) && $data['null']) {
				if($model->data[$model->alias][$field] == '') {
					$model->data[$model->alias][$field] = null;
				}
			}
		}
		return true;
	}
}