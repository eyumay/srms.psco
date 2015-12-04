<h1>Students List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Student uid</th>
      <th>Name</th>
      <th>Fathers name</th>
      <th>Grandfathers name</th>
      <th>Mother name</th>
      <th>Date of birth</th>
      <th>Admission year</th>
      <th>Sex</th>
      <th>Nationality</th>
      <th>Photo</th>
      <th>Birth location</th>
      <th>Residence city</th>
      <th>Residence woreda</th>
      <th>Residence kebele</th>
      <th>Residence house number</th>
      <th>Ethinicity</th>
      <th>Telephone</th>
      <th>Email</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($students as $student): ?>
    <tr>
      <td><a href="<?php echo url_for('student/show?id='.$student->getId()) ?>"><?php echo $student->getId() ?></a></td>
      <td><?php echo $student->getStudentUid() ?></td>
      <td><?php echo $student->getName() ?></td>
      <td><?php echo $student->getFathersName() ?></td>
      <td><?php echo $student->getGrandfathersName() ?></td>
      <td><?php echo $student->getMotherName() ?></td>
      <td><?php echo $student->getDateOfBirth() ?></td>
      <td><?php echo $student->getAdmissionYear() ?></td>
      <td><?php echo $student->getSex() ?></td>
      <td><?php echo $student->getNationality() ?></td>
      <td><?php echo $student->getPhoto() ?></td>
      <td><?php echo $student->getBirthLocation() ?></td>
      <td><?php echo $student->getResidenceCity() ?></td>
      <td><?php echo $student->getResidenceWoreda() ?></td>
      <td><?php echo $student->getResidenceKebele() ?></td>
      <td><?php echo $student->getResidenceHouseNumber() ?></td>
      <td><?php echo $student->getEthinicity() ?></td>
      <td><?php echo $student->getTelephone() ?></td>
      <td><?php echo $student->getEmail() ?></td>
      <td><?php echo $student->getCreatedAt() ?></td>
      <td><?php echo $student->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('student/new') ?>">New</a>
