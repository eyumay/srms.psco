<?php use_stylesheets_for_form($frontendProgramChecklistBreakdownForm) ?>
<?php use_javascripts_for_form($frontendProgramChecklistBreakdownForm) ?>
<?php use_stylesheet('ins_up.css') ?>

<h4> Manage Program Curriculum:   <span style="color:red;font-style: italic;"><?php echo $program->getName(); ?> </span> </h4>
<p style="font-size:12px; margin-bottom:3px; "> Adding New Course Breakdown </p>
<hr />
<form action="<?php echo url_for('curriculum/programchecklistbreakdownnew?programId='.$program->getId()); ?>" method="post">
    <?php echo $frontendProgramChecklistBreakdownForm; ?>
    <input type="submit" value="Save"> | 
    <a href="<?php echo url_for('curriculum/programDetail?programId='.$program->getId() )?>" style="font-size: 12px;"> Cancel </a>
</form>