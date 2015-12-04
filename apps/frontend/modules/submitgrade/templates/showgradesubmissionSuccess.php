<?php use_stylesheet('instr.css') ?>
<div class="filter">
    <table width="500px" cellspacing="0" border="0">
        <form action="<?php echo url_for('submitgrade/filterresult') ?>" method="post">
            <tr>
                <td> <?php echo $gradeFilterForm['program_id']->renderLabel(); ?> </td> <td> <?php echo $gradeFilterForm['program_id']->render(); ?> </td>
                <td> <?php echo $gradeFilterForm['academic_year']->renderLabel(); ?> </td> <td> <?php echo $gradeFilterForm['academic_year']->render(); ?> </td>
            </tr>
            <tr>
                <td> <?php echo $gradeFilterForm['year']->renderLabel(); ?> </td> <td> <?php echo $gradeFilterForm['year']->render(); ?> </td>
                <td> <?php echo $gradeFilterForm['semester']->renderLabel(); ?> </td> <td> <?php echo $gradeFilterForm['semester']->render(); ?> </td>
            </tr>
            <tr>
                <td> &nbsp; </td>  <td> &nbsp; </td>
                <td> <?php echo $gradeFilterForm['center_id']->renderLabel(); ?> </td> <td>  <?php echo $gradeFilterForm['center_id']->render(); ?> </td>
            </tr>
            <tr>  
                <td> &nbsp; </td>
                <td> &nbsp; </td>
                <td> <input type="submit" value="Filter" name="submit" /> </td> <td> <?php echo $gradeFilterForm['_csrf_token']->render(); ?> </td>

            </tr>
        </form>
    </table>
</div>
<hr />
<h2> Students List to Submit Grade </h2>
<form action="<?php echo url_for('submitgrade/dogradesubmission') ?>" method="post">
<table border="1">
    <?php echo $gradeForm; ?>
    <tr> <td> <input type="submit" value="Save" name="submit" /> </td> <td> &nbsp;  </td> </tr>
</table> </form>