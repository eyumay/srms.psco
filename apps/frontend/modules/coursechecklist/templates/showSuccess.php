<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $course_checklist->getId() ?></td>
    </tr>
    <tr>
      <th>Course:</th>
      <td><?php echo $course_checklist->getCourseId() ?></td>
    </tr>
    <tr>
      <th>Program:</th>
      <td><?php echo $course_checklist->getProgramId() ?></td>
    </tr>
    <tr>
      <th>Year:</th>
      <td><?php echo $course_checklist->getYear() ?></td>
    </tr>
    <tr>
      <th>Semester:</th>
      <td><?php echo $course_checklist->getSemester() ?></td>
    </tr>
    <tr>
      <th>Course type:</th>
      <td><?php echo $course_checklist->getCourseType() ?></td>
    </tr>
    <tr>
      <th>Status:</th>
      <td><?php echo $course_checklist->getStatus() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $course_checklist->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $course_checklist->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('coursechecklist/edit?id='.$course_checklist->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('coursechecklist/index') ?>">List</a>
