<?php
class Teacher extends AppModel {

    public $displayField = 'name';
    public $hasMany = array(
        'Course' => array(
            'className'  => 'Courses',
            'foreignKey' => 'teacher_id',
            'dependent'  => true
        )
    );

}
?>
