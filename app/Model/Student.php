<?php

class Student extends AppModel {

    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'El nombre no puede ser vacio'
        ),
        'last_name' => array(
            'rule' => 'notEmpty',
            'message' => 'El apellido no puede ser vacio'
        )
    ); 
    public $hasAndBelongsToMany = array(
        'Course' => array(
            'className' => 'Course',
            'joinTable' => 'students_courses',
            'foreignKey' => 'student_id',
            'associationForeignKey' => 'course_id'
        )
    );

}
?>
