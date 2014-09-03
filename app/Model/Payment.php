<?php

class Payment extends AppModel {

    public $validate = array(
        'amount' => array(
            'rule' => 'notEmpty',
            'message' => 'El campo monto no puede ser vacio'
        ),
        'interest' => array(
            'rule' => 'notEmpty',
            'message' => 'El campo interes no puede ser vacio'
        ),
        'residue' => array(
            'rule' => 'notEmpty',
            'message' => 'El campo saldo no puede ser vacio'
        )
    ); 
    
    public $belogsTo = array(
        'Credit' => array(
            'className'  => 'Credit',
            'foreignKey' => 'credit_id',
            'dependent'  => true
        )
    );
    
//    public $hasMany = array(
//        'Credit' => array(
//            'className'  => 'Credit',
//            'foreignKey' => 'client_id',
//            'dependent'  => true
//        )
//    );
    
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
