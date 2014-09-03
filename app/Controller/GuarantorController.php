<?php

class GuarantorsController extends AppController {

    public $helpers = array('Html','Form');
    public $components = array('Session');
    
    public function index() {
        $param = array('order'=>'name desc');
        $this->set('garantes',$this->Guarantor->find('all',$param)); //SELECT * FROM STUDENTS WHERE name desc
    }
    
    public function add($guarantor) {
        if($this->request->is('post')):
            if($this->Guarantor->save($this->request->data)):
                $this->Session->setFlash('Garante guardado!');
                $this->redirect(array('action'=>'index'));
            endif;
        else:
            if($this->Guarantor->save($guarantor)):
//                $this->Session->setFlash('Garante guardado!');
//                $this->redirect(array('action'=>'index'));
            endif;
        endif;
    }
    
    public function edit($id = null) {
        $this->Guarantor->id = $id;
        if ($this->request->is('get')):
              $this->request->data = $this->Guarantor->read();
        else:
            $this->add();
        endif;
    }
    
    public function delete($id) {
        if ($this->request->is('get')):
            throw new MethodNotAllowedException();
        else:
            if ($this->Guarantor->delete($id)):
                $this->Session->setFlash('Garante eliminado');
                $this->redirect(array('action'=>'index'));
            endif;
        endif;
    }
}
?>
