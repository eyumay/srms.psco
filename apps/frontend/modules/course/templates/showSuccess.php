<h3 align="center"> Manage Courses for <span style="color:red;"> <?php echo $department->getName(); ?> </span> </h3>
<div id='dropaddcontainer' style="width:100%;">
<table  class="table table-hover table-condensed ">
  <tbody>
    <tr>
      <th>Grade type:</th>
      <td><?php echo $course->getGradeType() ?></td>
    </tr>
    <tr>
      <th>Department:</th>
      <td><?php echo $course->getDepartment() ?></td>
    </tr>
    <tr>
      <th>Course number:</th>
      <td><?php echo $course->getCourseNumber() ?></td>
    </tr>
    <tr>
      <th>Name:</th>
      <td><?php echo $course->getName() ?></td>
    </tr>
    <tr>
      <th>Credit houre:</th>
      <td><?php echo $course->getCreditHoure() ?></td>
    </tr>
    <tr>
      <th>Ac minutes:</th>
      <td><?php echo $course->getAcMinutes() ?></td>
    </tr>
    <tr>
      <th>Aproval date:</th>
      <td><?php echo $course->getAprovalDate() ?></td>
    </tr>
    <tr>
      <th>Description:</th>
      <td><?php echo $course->getDescription() ?></td>
    </tr>
    <tr>
      <th>Status:</th>
      <td><?php echo $course->getStatus() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $course->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $course->getUpdatedAt() ?></td>
    </tr>
    <tr>
        <td colspan="2">
        <a href="<?php echo url_for('course/edit?id='.$course->getId()) ?>">Edit</a>
        &nbsp; | &nbsp;
        <a href="<?php echo url_for('course/index') ?>"> Courses List</a>         
        </td>
    </tr>
  </tbody>
</table>





</div>