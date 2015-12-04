<h5>Filter to Assign Courses </h5>
<form action="<?php echo url_for('student/filterforregistration'); ?>" method="post">
<?php echo $registrationFilterForm;  ?>
<input type="submit" value="Filter"><br/>
</form>

<form action="<?php echo url_for('student/registration'); ?>" method="post">
<?php $registrationForm;  ?>

</form>