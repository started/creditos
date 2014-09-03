<?php

class Client extends AppModel {

    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'El campo nombre no puede ser vacio'
        ),
        'last_name' => array(
            'rule' => 'notEmpty',
            'message' => 'El campo apellido no puede ser vacio'
        ),
        'address' => array(
            'rule' => 'notEmpty',
            'message' => 'El campo dirección no puede ser vacio'
        ),
        'phone' => array(
            'rule' => 'notEmpty',
            'message' => 'El campo telefono no puede ser vacio'
        )
    ); 
    
    public $hasMany = array(
        'Credit' => array(
            'className'  => 'Credit',
            'foreignKey' => 'client_id',
            'dependent'  => true
        )
    );
    
//    public $hasAndBelongsToMany = array(
//        'Course' => array(
//            'className' => 'Course',
//            'joinTable' => 'students_courses',
//            'foreignKey' => 'student_id',
//            'associationForeignKey' => 'course_id'
//        )
//    );

}
?>
