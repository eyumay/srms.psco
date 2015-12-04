<h3 align="center"> Manage Courses for <span style="color:red;"> <?php echo $department->getName(); ?> </span> </h3>
<p style="font-size: 12px; "> Editing Course <?php $course->getName(); ?> </p> 
<?php include_partial('form', array('form' => $form)) ?>
