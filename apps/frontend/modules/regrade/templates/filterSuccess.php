<?php use_stylesheets_for_form($studentsToEnroll) ?>
<?php use_javascripts_for_form($studentsToEnroll) ?>
<?php use_stylesheet('ins_up.css') ?>
<?php use_stylesheet('instr.css') ?> 
<?php include_partial('filterform', array('programs'=> $programs,'years'=> $years, 'semesters'=> $semesters,'academicYears'=> $academicYears, 'centers'=> $centers));  ?>

<form action="<?php echo url_for('programsection/enrolltosection'); ?>" method="post">
<?php echo $studentsToEnroll; ?>  
       <input type="submit" value="Enroll students to Section"/> 
</form>