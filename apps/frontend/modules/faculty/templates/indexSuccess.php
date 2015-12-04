<h1>Facultys List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Faculty name</th>
      <th>Description</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($facultys as $faculty): ?>
    <tr>
      <td><a href="<?php echo url_for('faculty/show?id='.$faculty->getId()) ?>"><?php echo $faculty->getId() ?></a></td>
      <td><?php echo $faculty->getFacultyName() ?></td>
      <td><?php echo $faculty->getDescription() ?></td>
      <td><?php echo $faculty->getCreatedAt() ?></td>
      <td><?php echo $faculty->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('faculty/new') ?>">New</a>
