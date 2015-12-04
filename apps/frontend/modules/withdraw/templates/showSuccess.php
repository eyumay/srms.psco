<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $student_withdrawal->getId() ?></td>
    </tr>
    <tr>
      <th>Enrollment info:</th>
      <td><?php echo $student_withdrawal->getEnrollmentInfoId() ?></td>
    </tr>
    <tr>
      <th>Withdrawal date:</th>
      <td><?php echo $student_withdrawal->getWithdrawalDate() ?></td>
    </tr>
    <tr>
      <th>Ac:</th>
      <td><?php echo $student_withdrawal->getAC() ?></td>
    </tr>
    <tr>
      <th>Remark:</th>
      <td><?php echo $student_withdrawal->getRemark() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $student_withdrawal->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $student_withdrawal->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('withdraw/edit?id='.$student_withdrawal->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('withdraw/index') ?>">List</a>
