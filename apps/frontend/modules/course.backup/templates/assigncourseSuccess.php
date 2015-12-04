<h5>Filter to Assign Courses </h5>
<form action="<?php echo url_for('course/assigncourse'); ?>" method="post">

<?php echo $filterform ?>

<input type="submit" value="Assign courses"><br/>
<br/>
</form>