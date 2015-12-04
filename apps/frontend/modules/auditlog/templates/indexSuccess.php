<h1>Audit logs List</h1>

<table style="font-size: 12px;  " width="100%">
  <thead>
    <tr style="background-color: blue; color: white;">

      <th>User</th>
      <th>Action</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($audit_logs as $audit_log): ?>
    <tr>
      <td><?php echo $audit_log->getUser() ?></td>
      <td><?php echo $audit_log->getAction() ?></td>
      <td><?php echo $audit_log->getCreatedAt() ?></td>
      <td><?php echo $audit_log->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('auditlog/new') ?>">New</a>
