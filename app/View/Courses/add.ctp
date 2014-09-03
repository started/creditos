<div class="form">
    <?php echo $this->Form->create('Course'); ?>
    <fieldset>
        <legend>Agregar Curso</legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('description');
            echo $this->Form->input('teacher_id');
        ?>
    </fieldset>
    <?php echo $this->Form->end('Guardar'); ?>
</div>