<h1>Centers List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
      <th>Description</th>

    </tr>
  </thead>
  <tbody>
    <?php foreach ($centers as $center): ?>
    <tr>
      <td><a href="<?php echo url_for('center/show?id='.$center->getId()) ?>"><?php echo $center->getId() ?></a></td>
      <td><?php echo $center->getName() ?></td>
      <td><?php echo $center->getDescription() ?></td>

    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('center/new') ?>">New</a>
