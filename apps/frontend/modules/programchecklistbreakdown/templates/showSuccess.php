<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $program_checklist_breakdown->getId() ?></td>
    </tr>
    <tr>
      <th>Program:</th>
      <td><?php echo $program_checklist_breakdown->getProgramId() ?></td>
    </tr>
    <tr>
      <th>Semester type:</th>
      <td><?php echo $program_checklist_breakdown->getSemesterTypeId() ?></td>
    </tr>
    <tr>
      <th>Year:</th>
      <td><?php echo $program_checklist_breakdown->getYear() ?></td>
    </tr>
    <tr>
      <th>Semester:</th>
      <td><?php echo $program_checklist_breakdown->getSemester() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $program_checklist_breakdown->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $program_checklist_breakdown->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('programchecklistbreakdown/edit?id='.$program_checklist_breakdown->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('programchecklistbreakdown/index') ?>">List</a>
