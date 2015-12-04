<h3 align="center"> Manage Courses for <span style="color:red;"> <?php echo $department->getName(); ?> </span> </h3>
<div id='dropaddcontainer' style="width:100%;">
<table class="table table-hover table-condensed ">
    <tr>
        <td colspan="4">
            <a href="<?php echo url_for('course/new?departmentId='.$department->getId()) ?>"> +Add New Course </a>
        </td>
    </tr>    
    <tr>
        <td> <strong>  SNo. </strong> </td>
        <td> <strong>  Course Name  </strong></td>
        <td> <strong>  Course Number  </strong></td>
        <td> <strong>  Chr </strong> </td>
        <td> <strong>  Action  </strong></td>
    </tr> 
    
    <?php $sn = 1; ?>
    <?php //foreach(Doctrine_Core::getTable('Course')->getCoursesByDepartmentId($departmentId) as $course): ?>
    <?php foreach($department->getCourses() as $course): ?>
    <tr>
       
        <td> <?php echo $sn.'. '; ?> </td>
        <td> <?php echo $course->getName(); ?> </td>
        <td> <?php echo $course->getCourseNumber(); ?> </td>
        <td> <?php echo $course->getCreditHoure(); ?> </td>
        <td align="center">
            <a href="<?php echo url_for('course/show?id='.$course->getId() ) ?>"> View Detail  </a> |
            <a href="<?php echo url_for('course/edit?id='.$course->getId() ) ?>"> Edit </a> |
            <?php echo link_to('Delete', 'course/delete?id='.$course->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>   
        </td>
    </tr>

    <?php $sn++; ?>
    <?php endforeach; ?>
    <tr>
        <td colspan="4">
            <a href="<?php echo url_for('course/new?departmentId='.$department->getId()) ?>"> +Add New Course </a>
        </td>
    </tr>

</table>
</div>