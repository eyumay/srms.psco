<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $course->getId() ?></td>
    </tr>
    <tr>
      <th>Grade type:</th>
      <td><?php echo $course->getGradeTypeId() ?></td>
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
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('course/edit?id='.$course->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('course/index') ?>">List</a>
