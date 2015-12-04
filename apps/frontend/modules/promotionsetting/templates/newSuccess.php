<h4> Manage Promotion setting for <span style='color:red;'> <?php echo $program->getDepartment().' '.$program->getName(); ?> </span> </h4>
<p style='font-size: 12px'> Adding New Promotion Setting </p> 
<hr />
<form>
    <?php echo $form;  ?>
    <input type="submit" value="Submit" />
</form>
&nbsp;<a href="<?php echo url_for('curriculum/programDetail?programId='.$program->getId() ) ?>">Back to list</a>
