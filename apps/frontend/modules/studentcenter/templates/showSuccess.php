<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $student_center->getId() ?></td>
    </tr>
    <tr>
      <th>Center:</th>
      <td><?php echo $student_center->getCenterId() ?></td>
    </tr>
    <tr>
      <th>Student:</th>
      <td><?php echo $student_center->getStudentId() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $student_center->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $student_center->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('studentcenter/edit?id='.$student_center->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('studentcenter/index') ?>">List</a>
