<?php

class Credit extends AppModel {

    public $validate = array(
        'product_name' => array(
            'rule' => 'notEmpty',
            'message' => 'El campo nombre no puede ser vacio'
        ),
        'product_price' => array(
            'rule' => 'notEmpty',
            'message' => 'El campo precio no puede ser vacio'
        ),
        'interest' => array(
            'rule' => 'notEmpty',
            'message' => 'El campo interés no puede ser vacio'
        ),
        'term' => array(
            'rule' => 'notEmpty',
            'message' => 'El campo plazos no puede ser vacio'
        ),
        'down_payment' => array(
            'rule' => 'notEmpty',
            'message' => 'El campo cuota inicial no puede ser vacio'
        ),
        'fine' => array(
            'rule' => 'notEmpty',
            'message' => 'El campo multa no puede ser vacio'
        )
    );
    
    public $belogsTo = array(
        'Client' => array(
            'className'  => 'Client',
            'foreignKey' => 'client_id',
            'dependent'  => true
        )
    );
    
    public $hasMany = array(
        'Payment' => array(
            'className'  => 'Payment',
            'foreignKey' => 'credit_id',
            'dependent'  => true
        )
    );
    
    public $hasOne = array(
        'Guarantor' => array(
            'className'  => 'Guarantor',
            'foreignKey' => 'credit_id',
            'dependent'  => true
        )
    );
    
}
?>
