<?php 
## Control variables
$showPrintStudentList               = FALSE;
$showPrintSemesterSlip              = FALSE;
$showGenerateConsolidate            = FALSE;
$showPromote                        = FALSE;
$showGenerateGradeReport            = FALSE;
$showGenerateCumulativeGradeReport  = TRUE;

$check = $sectionDetail->getEnrollmentInfos(); 
?>



<a href="<?php echo url_for('transfer/index') ?>"> << Back </a>

<?php 

$count                              = 1; 

?>

<h4> Manage Section Students </h4> 

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
                <div>                
                    <ul>
                        <li> <a href="<?php echo url_for('transfer/new/?sectionId='.$sectionDetail->getId()); ?>"> Add New Transfer </a>  </li>                       
                    </ul>                              
                </div>            
</div>
    
    
<div id='left'>
   
  <?php if($check): ?>
  <?php $checkTransfers = FALSE; ?>
<?php foreach($sectionDetail->getEnrollmentInfos() as $enrollment ): ?>
    <?php if(!$enrollment->getLeftout() && $enrollment->getEnrollmentAction() == sfConfig::get('app_transfer_enrollment')): ?>
        <?php $checkTransfers = TRUE; ?>
    <?php endif; ?>
<?php endforeach; ?>
<h4> Enrollments To This Section  </h4>

<table width="463" border="1px" cellspacing="0" cellpadding="3px" style="font-size: 12px;">
  <tr>
    <td align="center"><strong> S/No. </strong></td>  
    <td align="center"><strong> Student Name </strong></td>
    <td align="center"><strong> ID No. </strong></td>
    <td align="center"><strong> Sex </strong></td>
    <td align="center"><strong> Actions </strong></td>
  </tr>     
  <?php if($checkTransfers): ?>
    <?php foreach($sectionDetail->getEnrollmentInfos() as $enrollment ): ?>    
      <?php if(!$enrollment->getLeftout() && $enrollment->getEnrollmentAction() == sfConfig::get('app_transfer_enrollment')): ?>
        <tr>
          <td align="center"><?php echo $count; ?> </td>  
          <td align="center"><?php echo $enrollment->getStudent()->getName().' '.$enrollment->getStudent()->getFathersName().' '.$enrollment->getStudent()->getGrandfathersName();  ?>  </td>
          <td align="center">  <?php echo $enrollment->getStudent()->getStudentUid(); ?>  </td>
          <td align="center">  <?php echo ($enrollment->getStudent()->getSex())?'Male':'Female'; ?>  </td>
          <td align="center">  
              <a href="<?php echo url_for('transfer/edit/?sectionId='.$sectionDetail->getId().'&studentId='.$enrollment->getStudentId()); ?>"> Edit </a>  | 
              <a href="<?php echo url_for('transfer/view/?sectionId='.$sectionDetail->getId().'&studentId='.$enrollment->getStudentId()); ?>"> View </a>
          </td>
        </tr>
        <?php $count++; ?> 
      <?php endif; ?>
    <?php endforeach; ?> 
  <?php else: ?>
        <tr><td colspan="4"> There are no Transfered Students</td></tr>
  <?php endif; ?> 
</table>
<?php endif; ?>
   
<br /> <br /> <br />
</div>
</div>
    <a href="<?php echo url_for('transfer/index') ?>" class="btn"> << Back </a> 
