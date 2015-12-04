<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $student->getId() ?></td>
    </tr>
    <tr>
      <th>Student uid:</th>
      <td><?php echo $student->getStudentUid() ?></td>
    </tr>
    <tr>
      <th>Name:</th>
      <td><?php echo $student->getName() ?></td>
    </tr>
    <tr>
      <th>Fathers name:</th>
      <td><?php echo $student->getFathersName() ?></td>
    </tr>
    <tr>
      <th>Grandfathers name:</th>
      <td><?php echo $student->getGrandfathersName() ?></td>
    </tr>
    <tr>
      <th>Mother name:</th>
      <td><?php echo $student->getMotherName() ?></td>
    </tr>
    <tr>
      <th>Date of birth:</th>
      <td><?php echo $student->getDateOfBirth() ?></td>
    </tr>
    <tr>
      <th>Admission year:</th>
      <td><?php echo $student->getAdmissionYear() ?></td>
    </tr>
    <tr>
      <th>Sex:</th>
      <td><?php echo $student->getSex() ?></td>
    </tr>
    <tr>
      <th>Nationality:</th>
      <td><?php echo $student->getNationality() ?></td>
    </tr>
    <tr>
      <th>Photo:</th>
      <td><?php echo $student->getPhoto() ?></td>
    </tr>
    <tr>
      <th>Birth location:</th>
      <td><?php echo $student->getBirthLocation() ?></td>
    </tr>
    <tr>
      <th>Residence city:</th>
      <td><?php echo $student->getResidenceCity() ?></td>
    </tr>
    <tr>
      <th>Residence woreda:</th>
      <td><?php echo $student->getResidenceWoreda() ?></td>
    </tr>
    <tr>
      <th>Residence kebele:</th>
      <td><?php echo $student->getResidenceKebele() ?></td>
    </tr>
    <tr>
      <th>Residence house number:</th>
      <td><?php echo $student->getResidenceHouseNumber() ?></td>
    </tr>
    <tr>
      <th>Ethinicity:</th>
      <td><?php echo $student->getEthinicity() ?></td>
    </tr>
    <tr>
      <th>Telephone:</th>
      <td><?php echo $student->getTelephone() ?></td>
    </tr>
    <tr>
      <th>Email:</th>
      <td><?php echo $student->getEmail() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $student->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $student->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('student/edit?id='.$student->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('student/index') ?>">List</a>
