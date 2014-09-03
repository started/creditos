<?php

class Guarantor extends AppModel {

//    public $validate = array(
//        'name' => array(
//            'rule' => 'notEmpty',
//            'message' => 'El campo nombre no puede ser vacio'
//        ),
//        'last_name' => array(
//            'rule' => 'notEmpty',
//            'message' => 'El campo apellido no puede ser vacio'
//        ),
//        'address' => array(
//            'rule' => 'notEmpty',
//            'message' => 'El campo dirección no puede ser vacio'
//        ),
//        'phone' => array(
//            'rule' => 'notEmpty',
//            'message' => 'El campo telefono no puede ser vacio'
//        )
//    );
    
    public $belogsTo = array(
        'Credit' => array(
            'className'  => 'Credit',
            'foreignKey' => 'credit_id',
            'dependent'  => false
        )
    );
}
?>
