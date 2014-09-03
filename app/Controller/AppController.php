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
//         public $components = array('DebugKit.Toolbar');
         
         public $components = array(
//            'DebugKit.Toolbar',
            'Session',
            'Auth' => array(
                'loginRedirect' => array(
//                    'controller' => '/',
//                    'action' => 'index'
                ),
                'logoutRedirect' => array(
                    'controller' => 'users',
                    'action'     => 'login'
                ),
                'authError'=>'No puede ingresar a esta pagina',
                'authorize' => array('Controller')
            )
        );
         public function isAuthorized($user) {
//              if(isset($user['role']) && $user['role'] === 'admin') {
//                return true;
//            }
//            return false;
             return true;
         }
//        public function beforeFilter() {
//            $this->Auth->allow('index', 'view');
//            $this->set('logged_in',  $this->Auth->loggedIn());
//            $this->set('current_user',  $this->Auth->user());
//            
//            
//        }
         public function beforeFilter() {
             $this->Auth->allow('login');
             $this->set('logged_in',  $this->Auth->loggedIn());
             $this->set('current_user',  $this->Auth->user());
//            if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
//                $this->Auth->deny();
//            } else {
//                $this->Auth->allow();
//            }
        }
}