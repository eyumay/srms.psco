<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $faculty->getId() ?></td>
    </tr>
    <tr>
      <th>Faculty name:</th>
      <td><?php echo $faculty->getFacultyName() ?></td>
    </tr>
    <tr>
      <th>Description:</th>
      <td><?php echo $faculty->getDescription() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $faculty->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $faculty->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('faculty/edit?id='.$faculty->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('faculty/index') ?>">List</a>
