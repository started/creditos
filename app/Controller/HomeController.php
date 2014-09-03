<?php

class HomeController extends AppController {

    public $helpers = array('Html','Form');
    public $components = array('Session');
    
    public function index() {
//        $param = array('order'=>'name desc');
//        $this->set('clientes',$this->Client->find('all',$param)); //SELECT * FROM STUDENTS WHERE name desc
//        $this->set('estudiantes',$this->Student->findAllByLastName('solano', array() ,array('Student.id' => 'desc')));
        //$this->set('estudiantes',$this->Student->findAllByLastNameOrName('solano','rudy', array() ,array('Student.id' => 'desc')));
    }

}

?>
