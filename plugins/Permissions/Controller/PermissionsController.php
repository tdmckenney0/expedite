<?php

App::uses('PermissionsAppController', 'Permissions.Controller');

class PermissionsController extends PermissionsAppController {
    public $uses = false;
    public function index($status = 1, $show = 10, $search = '') {
        $this->redirect(array('controller' => 'requested_urls', 'action' => 'index', $status, $show, $search)); 
    }
}