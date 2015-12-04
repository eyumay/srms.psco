<h1>Course checklists List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Course</th>
      <th>Program</th>
      <th>Year</th>
      <th>Semester</th>
      <th>Course type</th>
      <th>Status</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($course_checklists as $course_checklist): ?>
    <tr>
      <td><a href="<?php echo url_for('coursechecklist/show?id='.$course_checklist->getId()) ?>"><?php echo $course_checklist->getId() ?></a></td>
      <td><?php echo $course_checklist->getCourseId() ?></td>
      <td><?php echo $course_checklist->getProgramId() ?></td>
      <td><?php echo $course_checklist->getYear() ?></td>
      <td><?php echo $course_checklist->getSemester() ?></td>
      <td><?php echo $course_checklist->getCourseType() ?></td>
      <td><?php echo $course_checklist->getStatus() ?></td>
      <td><?php echo $course_checklist->getCreatedAt() ?></td>
      <td><?php echo $course_checklist->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('coursechecklist/new') ?>">New</a>
