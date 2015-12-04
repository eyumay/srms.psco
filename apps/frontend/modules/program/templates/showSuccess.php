<h4> Managing Program for <span style='color: red'> <?php echo $department->getName(); ?> </span>  </h4>

<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $program->getId() ?></td>
    </tr>
    <tr>
      <th>Name:</th>
      <td><?php echo $program->getName() ?></td>
    </tr>
    <tr>
      <th>Department:</th>
      <td><?php echo $program->getDepartmentId() ?></td>
    </tr>
    <tr>
      <th>Program type:</th>
      <td><?php echo $program->getProgramTypeId() ?></td>
    </tr>
    <tr>
      <th>Enrollment type:</th>
      <td><?php echo $program->getEnrollmentTypeId() ?></td>
    </tr>
    <tr>
      <th>Minor:</th>
      <td><?php echo $program->getMinor() ?></td>
    </tr>
    <tr>
      <th>Number of semesters:</th>
      <td><?php echo $program->getNumberOfSemesters() ?></td>
    </tr>
    <tr>
      <th>Total max chr:</th>
      <td><?php echo $program->getTotalMaxChr() ?></td>
    </tr>
    <tr>
      <th>Total min chr:</th>
      <td><?php echo $program->getTotalMinChr() ?></td>
    </tr>
    <tr>
      <th>Number of years:</th>
      <td><?php echo $program->getNumberOfYears() ?></td>
    </tr>
    <tr>
      <th>Max number of years:</th>
      <td><?php echo $program->getMaxNumberOfYears() ?></td>
    </tr>
    <tr>
      <th>Approval date:</th>
      <td><?php echo $program->getApprovalDate() ?></td>
    </tr>
    <tr>
      <th>Status:</th>
      <td><?php echo $program->getStatus() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $program->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $program->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('program/edit?id='.$program->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('program/index') ?>">List</a>
