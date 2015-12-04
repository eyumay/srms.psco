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
