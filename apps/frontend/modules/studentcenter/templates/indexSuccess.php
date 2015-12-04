<h1>Student centers List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Center</th>
      <th>Student</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($student_centers as $student_center): ?>
    <tr>
      <td><a href="<?php echo url_for('studentcenter/show?id='.$student_center->getId()) ?>"><?php echo $student_center->getId() ?></a></td>
      <td><?php echo $student_center->getCenterId() ?></td>
      <td><?php echo $student_center->getStudentId() ?></td>
      <td><?php echo $student_center->getCreatedAt() ?></td>
      <td><?php echo $student_center->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('studentcenter/new') ?>">New</a>
