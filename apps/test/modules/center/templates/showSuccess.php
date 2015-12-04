<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $center->getId() ?></td>
    </tr>
    <tr>
      <th>Name:</th>
      <td><?php echo $center->getName() ?></td>
    </tr>
    <tr>
      <th>Description:</th>
      <td><?php echo $center->getDescription() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $center->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $center->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('center/edit?id='.$center->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('center/index') ?>">List</a>
