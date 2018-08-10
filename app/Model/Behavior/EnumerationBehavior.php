<?php

App::uses('ModelBehavior', 'Model');

class EnumerationBehavior extends ModelBehavior {
	public function beforeSave(Model $model, $options = []) {
		if(!empty($model->data[$model->alias])) {
			foreach($model->data[$model->alias] as $key => $data) {
				if(is_array($data) && !array_key_exists('tmp_name', $data) && !is_numeric($key)) {
					$model->data[$model->alias][$key] = implode(',', $data);
				}
			}
		}
		return true;
	}
}
