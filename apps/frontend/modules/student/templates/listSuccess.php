<h1>Students List</h1>

<table>
  <thead>
    <tr>
      <th> ID </th>
      <th> Full Name</th>
      <th> Date of birth</th>
      <th> Admission year</th>
      <th> Sex</th>

    </tr>
  </thead>
  <tbody>
    <?php foreach ($students as $student): ?>
    <tr>
      <td><?php echo $student->getStudentUid() ?></td>
      <td><?php echo $student->getName()." ". $student->getFathersName()." ".$student->getGrandfathersName() ?> </td>
      <td><?php echo $student->getDateOfBirth() ?></td>
      <td><?php echo $student->getAdmissionYear() ?></td>
      <td><?php echo ($student->getSex() == 1) ? "Male" : "Female"  ?></td>

    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('student/new') ?>">New</a>
