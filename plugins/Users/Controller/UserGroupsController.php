<?php
	
App::uses('ExpediteHasOnePropertyController', 'Controller');

class UserGroupsController extends ExpediteHasOnePropertyController {
	public $parentModule = 'User';
	public function getUserListInGroup($id = null) {
		if(!empty($this->request->params['requested'])) {
			if(!empty($id)) {
				return $this->UserGroup->getUserListInGroup($id);
			} else {
				throw new BadRequestException("Need a User Group ID"); 
			}
		} else {
			throw new ForbiddenException("Not Allowed"); 
		}
	}
	
	public function getUserGroups() {
		if(!empty($this->request->params['requested'])) {
            return $this->UserGroup->find('list');
		} else {
			throw new ForbiddenException("Not Allowed"); 
		}
	}
    
    public function getUserEmailListInGroup($id = null) {
		if(!empty($this->request->params['requested'])) {
			if(!empty($id)) {
				return $this->UserGroup->getUserEmailListInGroup($id);
			} else {
				throw new BadRequestException("Need a User Group ID"); 
			}
		} else {
			throw new ForbiddenException("Not Allowed"); 
		}
	}
}