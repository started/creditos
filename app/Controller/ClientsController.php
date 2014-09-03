<?php

class ClientsController extends AppController {

    public $helpers = array('Html','Form');
    public $components = array('Session');
    
    public function index() {
        $param = array('order'=>'name desc');
        $this->set('clientes',$this->Client->find('all',$param)); //SELECT * FROM STUDENTS WHERE name desc
//        $this->set('estudiantes',$this->Student->findAllByLastName('solano', array() ,array('Student.id' => 'desc')));
        //$this->set('estudiantes',$this->Student->findAllByLastNameOrName('solano','rudy', array() ,array('Student.id' => 'desc')));
    }
    public function add() {
        if($this->request->is('post')):
            if($this->Client->save($this->request->data)):
                $this->Session->setFlash('Cliente guardado!');
                $this->redirect(array('action'=>'index'));
            endif;
        endif;
    }
    public function edit($id = null) {
        $this->Client->id = $id;
        if ($this->request->is('get')):
              $this->request->data = $this->Client->read();
        else:
            $this->add();
//            if ($this->Student->save($this->request->data)):
//                $this->Session->setFlash('Estudiante '.$this->request->data['Student']['name'].' guardado!');
//                $this->redirect(array('action'=>'index'));
//            else:
//                $this->Session->setFlash('No de pudo guardar');
//            endif;
        endif;
    }
    public function delete($id) {
        if ($this->request->is('get')):
            throw new MethodNotAllowedException();
        else:
            if ($this->Client->delete($id)):
                $this->Session->setFlash('Cliente eliminado');
                $this->redirect(array('action'=>'index'));
            endif;
        endif;
    }
}
?>
