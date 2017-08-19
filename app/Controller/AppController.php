<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('CakePluginPolling', 'Vendor');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    public $theme = 'Expedite'; 
    
	public $components = array(
		'Auth' => array(
			'loginAction' => array(
				'plugin' => 'users',
				'controller' => 'users',
				'action' => 'login'
			),
			'authenticate' => array(
				'Form' => array(
					'userModel' => 'Users.User',
					'scope' => array('is_active' => 1),
					'contain' => array(
						'Office',
						'UserGroup'
					)
				)
			) 
		),
		'StackMessages', 
		'Session', 
		'Cookie',
		'RequestHandler',
		'Permissions'
	);
    
	public $helpers = array(
		'Html', 'Time', 'Number',
		'Form' => array(
            'className' => 'ExpediteForm'
        )
	);

	public function beforeFilter() {
		// Tell the View what plugins Expedite has loaded for Dynamic Layouts.  //
		$this->set('_plugins', CakePluginPolling::getLoadedPlugins());
		return parent::beforeFilter();
	}
}
