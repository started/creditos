<?php

class UsersController extends AppController {

//    public function beforeFilter() {
//        parent::beforeFilter();
//        $this->Auth->allow('add');
//        $this->Auth->autoRedirect = false;
//    }

    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->User->find('all'));
    }

    public function view($id = null) {
        $this->User->id = $id;
        
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function add() {
        $this->set('title_page', 'Be&Maf - Login - Nuevo Usuario');
        
        if ($this->request->is('post')) {
//            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Su usuario fue creado'));
                return $this->redirect(array('action' => 'index'));
            }
            else{
                $this->Session->setFlash(__('El usuario no fue guardado. Por favor, intente nuevamente.'));
            }
        }
    }

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.')
            );
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) {
        $this->request->onlyAllow('post');

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }

    public function login() {
        $this->set('title_page', 'Be&Maf - Login');
        $this->layout = '';
        
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirect());
            }
            $this->Session->setFlash(__('Usuario o password invalido, Intente de nuevo'));
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
    

}
?>
