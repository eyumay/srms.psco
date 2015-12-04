<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $audit_log->getId() ?></td>
    </tr>
    <tr>
      <th>User:</th>
      <td><?php echo $audit_log->getUserId() ?></td>
    </tr>
    <tr>
      <th>Action:</th>
      <td><?php echo $audit_log->getAction() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $audit_log->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $audit_log->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('auditlog/edit?id='.$audit_log->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('auditlog/index') ?>">List</a>
