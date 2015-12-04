<h4> Manage Add and Drop </h4> 

<div style="font-size:12px;"> 
<!-- Section Detail Start -->
<table border="1" style="font-size:11px; background-color:white;" cellpadding="4px" width="800px">
    
    <tr style="background-color: #000099; color: white;">
        <td align="center"> Class Information </td>
    </tr>

    <tr>
        <td valign="top">
            Program: <span style="color:red"> <i> <?php echo $sectionDetail->getProgram(); ?> </i> </span> 
            Center: <span style="color:red"> <i> <?php echo $sectionDetail->getCenter(); ?> </i> </span>  
            Academic Year: <span style="color:red"> <i> <?php echo $sectionDetail->getAcademicYear(); ?></i> </span>
            Year: <span style="color:red"> <i> <?php echo $sectionDetail->getYear(); ?> </i> </span> 
            Semester: <span style="color:red"> <i> <?php echo $sectionDetail->getSemester(); ?> </i> </span> 
        </td>
    </tr>
</table>
<!-- Section Detail End -->

<div id='dropaddcontainer'>
<div id='right'>
  <h4>Actions</h4>
  <ul><li> ADD </li>
<li> DROP </li>
<li> 
    <?php if($showDropRegistrationLink && $courseOfferingDefined): ?>
        <a href="<?php echo url_for('dropadd/registrationwithdrop/?enrollmentId='.$enrollmentId.'&sectionId='.$sectionId.'&studentId='.$studentId); ?>"> 
            Register with Drop 
        </a>
    <?php else: ?>
        Register with Drop 
    <?php endif; ?>
</li>
</ul>
</div>
    
    
<div id='left'>
<h4>Course Checklist</h4>
<table width="463" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;">
  <?php if($showCourseChecklists): ?>
  <tr>
    <td width="297" align="center"><strong>Course Name </strong></td>
    <td width="166" align="center"><strong>Action</strong></td>
  </tr>
  <?php foreach($coursesChecklists as $courseId=>$cclist): ?>
  <tr>
    <td width="297" align="center"> <?php echo $cclist ?> </td>
    <td width="166" align="center"> 
        <?php $checkIfCourseHasBeenAdded = Doctrine_Core::getTable('EnrollmentInfo')->checkIfCourseHasBeenAdded($sectionDetail, $studentId, $courseId); ?>
        <?php if( is_null($checkIfCourseHasBeenAdded) ): ?>
        Error to determine status
        <?php else: ?>
                <?php if(!$checkIfCourseHasBeenAdded): ?>
                <a href="<?php echo url_for('dropadd/add?sectionId='.$sectionId.'&studentId='.$studentId.'&courseId='.$courseId); ?>">             
                ADD this course </a>
            <?php else: ?>
            <em> <span style='color:green; '> ADDED </span></em>
            <?php endif;?>
        <?php endif; ?>
    </td>
  </tr>
  <?php endforeach; ?>
  <?php else: ?>
  <tr>
      <td colspan="2"> None </td>
  </tr>
  <?php endif; ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


<h4>Semester Registrations </h4>
<table width="463" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;">
  <?php if($showRegistrations): ?>
  <tr>
    <td width="297" align="center"><strong>Course Name </strong></td>
    <td width="166" align="center"><strong>Action</strong></td>
  </tr>
  <?php foreach($semesterRegistrations as $regCourse): ?>
  <tr>
    <td width="297" align="center"> <?php echo $regCourse ?> </td>
    <td width="166" align="center"> ADD this course </td>
  </tr>
  <?php endforeach; ?>
  <?php else: ?>
  <tr>
      <td colspan="2"> None </td>
  </tr>
  <?php endif; ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<h4> Semester Adds</h4>
<table width="463" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;">
  <?php if($showAdds): ?>
  <tr>
    <td width="297" align="center"><strong>Course Name </strong></td>
    <td width="166" align="center"><strong>Action</strong></td>
  </tr>
  <?php else: ?>
  <tr>
      <td colspan="2"> None </td>
  </tr>
  <?php endif; ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


<h4> Semester Drops</h4>
<table width="463" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;">
  <?php if($showDrops): ?>
  <tr>
    <td width="297" align="center"><strong>Course Name </strong></td>
    <td width="166" align="center"><strong>Action</strong></td>
  </tr>
  <?php foreach($semesterDrops as $droppedCourse): ?> 
  <tr>
    <td width="297" align="center"> <?php echo $droppedCourse; ?>  </td>
    <td width="166" align="center"> None </td>
  </tr>  
  <?php endforeach; ?> 
  <?php else: ?>
  <tr>
      <td colspan="2"> None </td>
  </tr>
  <?php endif; ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>



<h4> Semester Exemptions</h4>
<table width="463" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;">
  <?php if($showExemptions): ?>
  <tr>
    <td width="297" align="center"><strong>Course Name </strong></td>
    <td width="166" align="center"><strong>Action</strong></td>
  </tr>
  <?php else: ?>
  <tr>
      <td colspan="2"> None </td>
  </tr>
  <?php endif; ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>

</div>