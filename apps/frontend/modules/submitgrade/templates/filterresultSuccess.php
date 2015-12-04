<form action="<?php echo url_for('submitgrade/filterresult') ?>" method="post">
    <?php echo $gradeFilterForm; ?>
    <input type="submit" value="Filter" name="submit" />
</form>