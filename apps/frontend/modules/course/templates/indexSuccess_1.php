<h4> Manage Courses </h4>

<table style="font-size: 11px;" border="1px" width ="400px">

    <?php foreach($departments as $department): ?>
     <?php $sn = 1; ?>
    
    <tr>
      <th colspan="3"><?php echo $department->getName(); ?> Courses <br /></th>
    </tr>

    <?php foreach(Doctrine_Core::getTable('Course')->getCoursesByDepartmentId($department->getId()) as $course): ?>
    <tr>
        <td> <?php echo $sn.'. '; ?> </td>
        <td> <?php echo $course->getName(); ?> </td>
        <td align="center">
            <a href="<?php echo url_for('course/show?id='.$course->getId() ) ?>"> View Detail  </a> |
            <a href="<?php echo url_for('course/edit?id='.$course->getId() ) ?>"> Edit </a> |
            <a href="<?php echo url_for('course/delete?id='.$course->getId() ) ?>"> Delete </a>
        </td>
    </tr>

    <?php $sn++; ?>
    <?php endforeach; ?>
    <tr>
        <td colspan="3">
            <a href="<?php echo url_for('course/new?departmentId='.$department->getId()) ?>"> +Add New Course </a>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

  <a href="<?php echo url_for('course/new') ?>">+ Add New</a>
