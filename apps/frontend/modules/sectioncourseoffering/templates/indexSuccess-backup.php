<h1>Section course offerings List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Course</th>
      <th>Grade status</th>
      <th>Instructor</th>
      <th>Section</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($section_course_offerings as $section_course_offering): ?>
    <tr>
      <td><a href="<?php echo url_for('sectioncourseoffering/show?id='.$section_course_offering->getId()) ?>"><?php echo $section_course_offering->getId() ?></a></td>
      <td><?php echo $section_course_offering->getCourseId() ?></td>
      <td><?php echo $section_course_offering->getGradeStatus() ?></td>
      <td><?php echo $section_course_offering->getInstructorId() ?></td>
      <td><?php echo $section_course_offering->getSectionId() ?></td>
      <td><?php echo $section_course_offering->getCreatedAt() ?></td>
      <td><?php echo $section_course_offering->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('sectioncourseoffering/new') ?>">New</a>
