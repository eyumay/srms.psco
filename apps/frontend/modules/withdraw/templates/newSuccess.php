<h1>New Student withdrawal</h1>
<h4> Manage <span style="color:red;"> Student Withdrawal </span> </h4>

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
      <li> None </li>
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
<h4> Withdraw Student </h4> 
<?php include_partial('form', array('form' => $form)) ?>
</div>
</div>







<a href="<?php echo url_for('withdraw/index') ?>" class="btn"> << Back </a> 
