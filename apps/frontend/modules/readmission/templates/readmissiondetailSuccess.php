<?php $showReadmissionForm = FALSE; ?>
<h4> Manage Readmission </h4> 

<div style="font-size:12px;"> 
<!-- Section Detail Start -->
<table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="800px">
    
    <tr style="background-color: #000099; color: white;">
        <td align="center"> Class Information </td>
    </tr>

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
    <?php foreach($student->getEnrollmentInfos() as $enrollment): ?>
    <?php if($enrollment->getLeftout()): ?>
              <?php if($enrollment->getAcademicStatus() == sfConfig::get('app_adr_status') || $enrollment->getAcademicStatus() == sfConfig::get('app_withdrawal_status') || $enrollment->getSemesterAction() == sfConfig::get('app_withdrawn_semester_action')): ?>
                  <?php $showReadmissionForm = TRUE; ?>
                  <?php $sEnrollment = $enrollment; ?>
              <?php endif; ?>

    <?php endif; ?>
    <?php endforeach; ?>   
    <?php if($showReadmissionForm): ?>
      <li> <a href="<?php echo url_for('readmission/readmitstudent/?enrollmentId='.$sEnrollment->getId()) ?>"> Readmit Student </a> </li>
    <?php else: ?>
        <li> None </li>
    <?php endif; ?>
       
</ul>
</div>
    
    
<div id='left'>
<h4> Student Enrollments </h4>
<table width="490" border="1" cellspacing="0" cellpadding="2px" style="font-size: 12px;">
  <tr>
      <th> Program Section </th>
      <th> Ac.Year </th>
      <th> Year </th>
      <th> Sem </th>
      <th> CGPA </th>
      <th> S.Action </th>
      <th> Status </th>
  </tr>
  <?php foreach($student->getEnrollmentInfos() as $enrollment): ?>
  <?php if(!$enrollment->getLeftout()): ?>
  <tr>
      <td> <?php echo $enrollment->getProgramSection() ; ?>  </td>
      <td>  <?php echo $enrollment->getAcademicYear() ; ?>  </td>
      <td>  <?php echo $enrollment->getYear() ; ?>   </td>
      <td>  <?php echo $enrollment->getSemester() ; ?>   </td>
      <td>  <?php echo $enrollment->getCGPA() ; ?>   </td>
      <td>  <?php echo SemesterActions::getSemesterAction($enrollment); ?>   </td>
      <td>  <?php echo Statuses::getStudentStatus($student->getEnrollmentInfos(),$enrollment->getYear(),  $enrollment->getSemester(), $enrollment->getSectionId())?>   </td>
            <?php if($enrollment->getAcademicStatus() == sfConfig::get('app_adr_status') || $enrollment->getAcademicStatus() == sfConfig::get('app_withdrawal_status')): ?>
                <?php $showReadmissionForm = TRUE; ?>
                <?php $sEnrollment = $enrollment; ?>
            <?php endif; ?>
                
  </tr>  
  <?php endif; ?>
  <?php endforeach; ?>
</table>
</div>
</div>







<a href="<?php echo url_for('readmission/index') ?>" class="btn"> << Back </a> 