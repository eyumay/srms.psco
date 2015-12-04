<?php 

$count                              = 1; 

?>

<h3 align="center"> Manage Section Students </h3> 

<!-- Section Detail Start -->
<table width="100%" class="table table-hover table-condensed ">   
  
    <tr>
        <td> <strong> Program </strong> </td>
        <td> <strong>  Center </strong>  </td>
        <td>  <strong> Academic Year  </strong> </td>
        <td>  <strong> Year </strong>  </td>
        <td>  <strong> Semester  </strong> </td>
        <td>  <strong> Status  </strong> </td>
    </tr> 
   
    <tr>
        <td> <?php echo $sectionDetail->getProgram()->getEnrollmentType(); ?> </td>
        <td> <?php echo $sectionDetail->getCenter()->getName(); ?> </td>
        <td> <?php echo $sectionDetail->getAcademicYear(); ?> </td>
        <td> <?php echo $sectionDetail->getYear(); ?> </td>
        <td> <?php echo $sectionDetail->getSemester(); ?> </td>
        <td> 
            <?php echo $sectionDetail->getSectionStatus(); ?>
        </td>

    </tr>  
    <tr>
        <td colspan="6"> <a href="<?php echo url_for('programsection/index') ?>" > << Back To Sections List </a> </td>

    </tr>     
</table>
<!-- Section Detail End -->

<div id='dropaddcontainer' style='width:1000px;'>
<div id='right' style="font-size: 14px; ">
  <h4>Actions</h4>               
                <div>                
                    <ul>
                        
                <?php if($sectionDetail->getYear() == 1 && $sectionDetail->getSemester() == 1 && $showAddNewStudent): ?>
                        <li> 
                        <a href="<?php echo url_for('student/admission?sectionId='.$sectionDetail->getId()) ?>">  
                           Add New Student </a>
                        </li>
                <?php endif; ?> 
                <?php if($showPrintStudentList): ?>
                        <li> 
                       <a href="<?php echo url_for('programsection/printStudentSlip?id='.$sectionDetail->getId()) ?>">  
                       <em> Print Student List  </em> </a>
                        </li>
                <?php endif; ?>
                <?php if($showPrintSemesterSlip): ?>
                        <li> 
                       <a href="<?php echo url_for('programsection/printSemesterSlip?id='.$sectionDetail->getId()) ?>">  
                       <em> Print Semester Slip  </em> </a>
                        </li>
                <?php endif; ?>
                <?php if($showGenerateConsolidate): ?>
                        <li>
                       <a href="<?php echo url_for('programsection/generateConsolidate?id='.$sectionDetail->getId()) ?>">  
                       <em> Generate Consolidate </em> </a>
                        </li>
                <?php endif; ?>   
                <?php if($showGenerateGradeReport): ?>
                        <li>
                       <a href="<?php echo url_for('programsection/generateGradeReport?id='.$sectionDetail->getId()) ?>">  
                       <em> Generate Grade Report </em> </a> <br />                       
                        </li>
                <?php endif; ?>                       
                <?php if($showGenerateCumulativeGradeReport): ?>
                        <li>
                       <a href="<?php echo url_for('programsection/generateCumulativeGradeReport?id='.$sectionDetail->getId()) ?>">  
                       <em> Generate Cumulative Grade Report </em> </a>
                        </li>
                <?php endif; ?>     
                
                <?php if($showPromote): ?>
                        <li>
                       <a href="<?php echo url_for('programsection/processPromotion?id='.$sectionDetail->getId()) ?>">  
                       <em>  Do Promotion  </em> </a> <br />
                        </li>
                <?php else: ?>
                       <li> Do Promotion </li>
                <?php endif; ?>                          
                    </ul>                              
                </div>

                <div style="margin-bottom: 20px"> 
                    <h4> Class/Section Statuses </h4>
                    <?php if($showSectionIsCreated): ?>                           
                           <span style="color:green"> <strong> 1. Section is created </strong> </span><br /> 
                    <?php else: ?>
                           <span style="color:red"> <strong> 1. Section is not created </strong> </span><br /> 
                    <?php endif; ?>                     
                    <?php if($showEnrolledToSection): ?>                           
                           <span style="color:green"> <strong> 2. Enrolled to Section </strong> </span><br /> 
                    <?php else: ?>
                           <span style="color:red">  <strong> 2. No Students Enrolled to Section </strong> </span><br /> 
                    <?php endif; ?>                    
                    <?php if($showCourseIdDefined): ?>                           
                           <span style="color:green"> <strong> 3. Course Offering: Course is defined. </strong> </span><br /> 
                    <?php else: ?>
                           <span style="color:red">  <strong> 3. Course Offering: Course is not defined  </strong> </span><br /> 
                    <?php endif; ?>                     
                    <?php if($showRegistered): ?>                           
                           <span style="color:green"> <strong> 4. Registered. </strong> </span><br /> 
                    <?php else: ?>
                           <span style="color:red">  <strong> 4. Not Registered </strong> </span><br /> 
                    <?php endif; ?>                                                                           
                    <?php if($showGradeIsSubmitted): ?>                           
                           <span style="color:green"> <strong> 5. Grade Submitted. </strong> </span><br /> 
                           <?php if($sectionDetail->getYear()==1 && $sectionDetail->getSemester()==1 ){ 
                                    $showGenerateCumulativeGradeReport    = FALSE;
                                }
                           ?>
                    <?php else: ?>
                           <?php $showGenerateCumulativeGradeReport = FALSE; ?> 
                           <span style="color:red">  <strong> 5. Grade Not Submitted </strong> </span><br /> 
                    <?php endif; ?>                                   
                                                       
                     
                </div>      
  
</div>
    
    
<div id='left' style='width: 700px; '>
   
  <?php if($check && $showEnrolledToSection): ?>
<h4> Enrollments Students To This Section  </h4>

<table class="table table-hover table-condensed ">
  <tr>
    <td align="center"><strong> S/No. </strong></td>  
    <td align="center"><strong> Student Name </strong></td>
    <td align="center"><strong> ID No. </strong></td>
    <td align="center"><strong> Sex </strong></td>
    <td align="center"><strong> Action </strong></td>
  </tr>     
    <?php foreach($sectionDetail->getEnrollmentInfos() as $enrollment ): ?>
      <?php if(!$enrollment->getLeftout()): ?>
        <tr>
          <td align="center"><?php echo $count; ?>. </td>  
          <td align="center"><?php echo $enrollment->getStudent()->getName().' '.$enrollment->getStudent()->getFathersName().' '.$enrollment->getStudent()->getGrandfathersName();  ?>  </td>
          <td align="center">  <?php echo $enrollment->getStudent()->getStudentUid(); ?>  </td>
          <td align="center">  <?php echo ($enrollment->getStudent()->getSex())?'Male':'Female'; ?>  </td>
          <td align="center"> 
              <a href="<?php echo url_for('programsection/editstudent?studentId='.$enrollment->getStudentId().'&sectionId='.$enrollment->getSectionId()) ?>"> 
                  Edit Info. 
              </a>
          </td>
        </tr>
        <?php $count++; ?> 
      <?php endif; ?>
    <?php endforeach; ?> 
</table>
  <?php else: ?>
   <?php if($showAdmissions): ?>
  <h4> Admissions To This Program  </h4>

<table width="463" border="1px" cellspacing="0" cellpadding="3px" style="font-size: 12px;">
  <tr>
    <td align="center"><strong> S/No. </strong></td>  
    <td align="center"><strong> Student Name </strong></td>
    <td align="center"><strong> ID No. </strong></td>
    <td align="center"><strong> Sex </strong></td>
  </tr>     
    <?php foreach($admissions as $enrollment ): ?>
        <tr>
          <td align="center"><?php echo $count; ?> </td>  
          <td align="center"><?php echo $enrollment->getStudent()->getName().' '.$enrollment->getStudent()->getFathersName().' '.$enrollment->getStudent()->getGrandfathersName();  ?>  </td>
          <td align="center">  <?php echo $enrollment->getStudent()->getStudentUid(); ?>  </td>
          <td align="center">  <?php echo ($enrollment->getStudent()->getSex())?'Male':'Female'; ?>  </td>
        </tr>
        <?php $count++; ?> 
    <?php endforeach; ?> 
</table>
  <?php else: ?>
   <ul> <li> No Admitted Students  </li> </ul>
  <?php endif; ?> 
<?php endif; ?>
<h4> Transfers </h4>
<table class="table table-hover table-condensed "> 
    <tr>
        <td align="center"> <strong> Student </strong> </td>
        <td align="center"><strong>  From  </strong> </td>
        <td align="center"> <strong> To </strong>  </td>
    </tr>
<?php if($showTransferDetails): ?>    
<?php foreach($transfers as $transfer): ?>  
    <tr>
        <td> <?php echo $transfer->getStudent(); ?> </td> 
        <td> <?php echo $transfer->getProgramSection(); ?> </td>
        <td> <?php echo $transfer->getToSection(); ?> </td>
    </tr>
<?php endforeach; ?>
      
<?php endif; ?>
</table>  

<h4> Withdraws </h4>
<?php $count = 1; ?> 
<table  class="table table-hover table-condensed ">
  <tr>
    <td align="center"><strong> S/No. </strong></td>  
    <td align="center"><strong> Student Name </strong></td>
    <td align="center"><strong> ID No. </strong></td>
    <td align="center"><strong> Sex </strong></td>
  </tr>     
    <?php foreach($sectionDetail->getEnrollmentInfos() as $enrollment ): ?>
      <?php if($enrollment->getLeftout() && $enrollment->getSemesterAction() == sfConfig::get('app_withdrawn_semester_action')): ?>
        <tr>
          <td align="center"><?php echo $count; ?> </td>  
          <td align="center"><?php echo $enrollment->getStudent()->getName().' '.$enrollment->getStudent()->getFathersName().' '.$enrollment->getStudent()->getGrandfathersName();  ?>  </td>
          <td align="center">  <?php echo $enrollment->getStudent()->getStudentUid(); ?>  </td>
          <td align="center">  <?php echo ($enrollment->getStudent()->getSex())?'Male':'Female'; ?>  </td>
        </tr>
        <?php $count++; ?> 
      <?php endif; ?>
    <?php endforeach; ?> 
</table>
<br /> <br /> <br />
</div>
    <a href="<?php echo url_for('programsection/index') ?>" class="btn"> << Back </a> 
</div>