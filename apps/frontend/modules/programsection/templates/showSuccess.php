<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $program_section->getId() ?></td>
    </tr>
    <tr>
      <th>Program:</th>
      <td><?php echo $program_section->getProgramId() ?></td>
    </tr>
    <tr>
      <th>Academic advisor:</th>
      <td><?php echo $program_section->getAcademicAdvisorId() ?></td>
    </tr>
    <tr>
      <th>Academic calendar:</th>
      <td><?php echo $program_section->getAcademicCalendarId() ?></td>
    </tr>
    <tr>
      <th>Number of student:</th>
      <td><?php echo $program_section->getNumberOfStudent() ?></td>
    </tr>
    <tr>
      <th>Academic year:</th>
      <td><?php echo $program_section->getAcademicYear() ?></td>
    </tr>
    <tr>
      <th>Year:</th>
      <td><?php echo $program_section->getYear() ?></td>
    </tr>
    <tr>
      <th>Semester:</th>
      <td><?php echo $program_section->getSemester() ?></td>
    </tr>
    <tr>
      <th>Section number:</th>
      <td><?php echo $program_section->getSectionNumber() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $program_section->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $program_section->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('programsection/edit?id='.$program_section->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('programsection/index') ?>">List</a>
