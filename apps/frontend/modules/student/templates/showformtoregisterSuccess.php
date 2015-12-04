<?php use_stylesheets_for_form($registrationForm) ?>
<?php use_javascripts_for_form($registrationForm) ?>
<?php use_stylesheet('ins_up.css') ?>
<h5>Filter to Assign Courses </h5>
<form action="<?php echo url_for('student/Showregistrationfilterformresults'); ?>" method="post">
<?php echo $registrationFilterForm;  ?>
<input type="submit" value="Filter"><br/>
</form>


<form action="<?php echo url_for('student/registration'); ?>" method="post">
<?php echo $registrationForm;  ?>
<input type="submit" value="Register"><br/>
</form>