<?php
class User extends AppModel {
    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A name is required'
            )
        ),
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            ),
            'Match passwords'=>array(
                'rule'=>'matchPasswords',
                'message' => 'Las contraseñas no coinciden'
            )
        ),
        'password_confirmation' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please confirm your password '
            )
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'author')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
        )
    );
    public function matchPasswords($data){
        if($data['password'] == $this->data['User']['password_confirmation']){
            return true;
        }
        return false;
    }
    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }
}
?>
