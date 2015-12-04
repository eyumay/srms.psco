<h4> Manage Student Records </h4> 

<div style="font-size:12px;"> 
<!-- Section Detail Start -->
<table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="800px">
    
    <tr>
        <td valign="top">
            ID: <span style="color:red"> <i> <?php echo $student->getStudentUid(); ?> </i> </span> &nbsp; &nbsp; &nbsp; 
            Name: <span style="color:red"> <i> <?php echo $student->getName().' '.$student->getFathersName().' '.$student->getGrandfathersName(); ?> </i> </span>  &nbsp; &nbsp; &nbsp; 
            Admission Year: <span style="color:red"> <i> <?php echo $student->getAdmissionYear(); ?> </i> </span> &nbsp; &nbsp; &nbsp; 
            Date of Birth:  <span style="color:red"> <i> <?php echo $student->getDateOfBirth(); ?> </i> </span>  &nbsp; &nbsp; &nbsp; 
        </td>
    </tr>
</table>
<!-- Section Detail End -->

<div id='dropaddcontainer'>
<div id='right'>
  <h4>Actions</h4>
  <ul>
      <?php if($showEdit || $showDelete): ?>
      <li> <a href="<?php echo url_for('student/edit/?id='.$student->getId()) ?>" >  Edit </a> </li>
      <li> <a href="<?php echo url_for('student/delete/?id='.$student->getId() ) ?>" > Delete </a> </li>
      <?php else: ?>
      <li> None </li>
      <?php endif; ?>
</ul>
</div>
    
    
<div id='left'>
<h4> Student Enrollments </h4>
<table width="490" border="1" cellspacing="0" cellpadding="2px" style="font-size: 12px;">
  <tr>
      <td> Program Section </td>
      <td> Ac.Year </td>
      <td> Year </td>
      <td> Semester </td>
      <td> GPA </td>
      <td> CGPA </td>
      <td> Semester Action </td>
      <td> Status </td>
  </tr>
  <?php foreach($student->getEnrollmentInfos() as $enrollment): ?>
  <tr>
      <td> <?php echo $enrollment->getProgramSection() ; ?>  </td>
      <td>  <?php echo $enrollment->getAcademicYear() ; ?>  </td>
      <td>  <?php echo $enrollment->getYear() ; ?>   </td>
      <td>  <?php echo $enrollment->getSemester() ; ?>   </td>
      <td>  <?php echo $enrollment->getCGPA() ; ?>   </td>
      <td>  <?php echo $enrollment->getCGPA() ; ?>   </td>
      <td>  <?php echo SemesterActions::getSemesterAction($enrollment); ?>   </td>
      <td>  <?php echo Statuses::getStudentStatus($enrollment)?>   </td>
  </tr>  
  <?php endforeach; ?>
</table>
</div>
</div>







<a href="<?php echo url_for('student/index') ?>" class="btn"> << Back </a> 
<?php if(!$enrollment->checkIfEnrolled() ): ?>
<?php echo link_to('Delete', 'student/delete?id='.$student->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?> 
<?php endif; ?>