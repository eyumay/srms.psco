<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $section_course_offering->getId() ?></td>
    </tr>
    <tr>
      <th>Course:</th>
      <td><?php echo $section_course_offering->getCourseId() ?></td>
    </tr>
    <tr>
      <th>Grade status:</th>
      <td><?php echo $section_course_offering->getGradeStatus() ?></td>
    </tr>
    <tr>
      <th>Instructor:</th>
      <td><?php echo $section_course_offering->getInstructorId() ?></td>
    </tr>
    <tr>
      <th>Section:</th>
      <td><?php echo $section_course_offering->getSectionId() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $section_course_offering->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $section_course_offering->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('sectioncourseoffering/edit?id='.$section_course_offering->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('sectioncourseoffering/index') ?>">List</a>
