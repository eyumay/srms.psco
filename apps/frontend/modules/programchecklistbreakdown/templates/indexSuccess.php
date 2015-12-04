<h1>Program checklist breakdowns List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Program</th>
      <th>Semester type</th>
      <th>Year</th>
      <th>Semester</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($program_checklist_breakdowns as $program_checklist_breakdown): ?>
    <tr>
      <td><a href="<?php echo url_for('programchecklistbreakdown/show?id='.$program_checklist_breakdown->getId()) ?>"><?php echo $program_checklist_breakdown->getId() ?></a></td>
      <td><?php echo $program_checklist_breakdown->getProgramId() ?></td>
      <td><?php echo $program_checklist_breakdown->getSemesterTypeId() ?></td>
      <td><?php echo $program_checklist_breakdown->getYear() ?></td>
      <td><?php echo $program_checklist_breakdown->getSemester() ?></td>
      <td><?php echo $program_checklist_breakdown->getCreatedAt() ?></td>
      <td><?php echo $program_checklist_breakdown->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('programchecklistbreakdown/new') ?>">New</a>
