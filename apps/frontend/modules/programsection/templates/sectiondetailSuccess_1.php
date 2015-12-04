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
<h4> Section Detail </h4>
<div style="font-size:12px;"> 
    <table border="1" style="font-size:11px; background-color:white" cellpadding="4px">    
        <tr style="background-color: #000099; color: white;">
            <td> Class Information </td> 
            <td> Class Students </td> 
            <td> <b> Actions/Statuses </b>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  </td> 
        </tr> 
        <tr>
            <td valign="top">
                Program: <span style="color:red"> <i> <?php echo $sectionDetail->getProgram(); ?> </i> </span> <br />
                Center: <span style="color:red"> <i> <?php echo $sectionDetail->getCenter(); ?> </i> </span>   <br />
                Academic Year: <span style="color:red"> <i> <?php echo $sectionDetail->getAcademicYear(); ?></i> </span>  <br />
                Year: <span style="color:red"> <i> <?php echo $sectionDetail->getYear(); ?> </i> </span> <br />
                Semester: <span style="color:red"> <i> <?php echo $sectionDetail->getSemester(); ?> </i> </span>  <br />
            </td>
            <td valign="top">  
                <?php if( $check[0] != ''): ?>
                <?php
                $count=1; 
                foreach($sectionDetail->getEnrollmentInfos() as $enrollment ): ?> 

                <?php echo $count.'. '; ?> 
                <?php echo $enrollment->getStudent(); ?>     <br />    
                <?php 
                $count++; 
                endforeach;    
                ?> 
                <?php 
                else:
                    echo 'No Enrolled Students / Class is empty <br />';
                    echo 'Please go to Program Section to enroll students '; 
                endif; ?>                 
            </td>
            <td valign="top"> 
                <div style="margin-bottom: 20px"> 
                    Class/Section Statuses <br />                    
                    <?php if(Doctrine_Core::getTable('ProgramSection')->checkIfSectionIsCreatedById($sf_params->get('id'))): ?>                           
                           <span style="color:green"> <strong> 1. Section is created </strong> </span><br /> 
                    <?php else: ?>
                           <span style="color:red"> <strong> 1. Section is not created </strong> </span><br /> 
                    <?php endif; ?>                     
                    <?php if(Doctrine_Core::getTable('EnrollmentInfo')->checkIfEnrolledToSectionBySectionId($sf_params->get('id'))): ?>                           
                           <?php $showPrintStudentList          = TRUE; ?>
                           <span style="color:green"> <strong> 2. Enrolled to Section </strong> </span><br /> 
                    <?php else: ?>
                           <span style="color:red">  <strong> 2. No Students Enrolled to Section </strong> </span><br /> 
                    <?php endif; ?>                    
                    <?php if(Doctrine_Core::getTable('SectionCourseOffering')->checkIfCourseIsDefined($sf_params->get('id'))): ?>                           
                           <?php $showPrintSemesterSlip         = TRUE; ?>
                           <span style="color:green"> <strong> 3. Course Offering: Course is defined. </strong> </span><br /> 
                    <?php else: ?>
                           <span style="color:red">  <strong> 3. Course Offering: Course is not defined  </strong> </span><br /> 
                    <?php endif; ?>                     
                    <?php if(Doctrine_Core::getTable('EnrollmentInfo')->checkIfRegisteredBySectionId($sf_params->get('id'))): ?>                           
                           <span style="color:green"> <strong> 4. Registered. </strong> </span><br /> 
                    <?php else: ?>
                           <span style="color:red">  <strong> 4. Not Registered </strong> </span><br /> 
                    <?php endif; ?>                                                                           
                    <?php if(Doctrine_Core::getTable('SectionCourseOffering')->checkIfGradeSubmittedBySectionId($sf_params->get('id'))): ?>                           
                           <?php $showGenerateConsolidate    = TRUE; 
                                 $showGenerateGradeReport    = TRUE; 
                                 
                                 ## if grade is defined, then also checkto show Promote link
                                 
                                 if(Doctrine_Core::getTable('PromotionSetting')                                    
                                        ->checkIfPromotionSettingIsDefined($sectionDetail->getProgramId(), $sectionDetail->getYear(), $sectionDetail->getSemester()) ) {
                                    if(!Doctrine_Core::getTable('ProgramSection')                                    
                                            ->checkIfSectionIsPromoted($sectionDetail->getId() )) {
                                        $showPromote = TRUE; 
                                    } 
                                 }                                    
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 ?>
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
                
                <div>
                Actions <br />
                <?php if($showPrintStudentList): ?>
                       <a href="<?php echo url_for('programsection/printStudentSlip?id='.$sectionDetail->getId()) ?>">  
                       <em> Print Student List  </em> </a> <br />
                <?php endif; ?>
                <?php if($showPrintSemesterSlip): ?>
                       <a href="<?php echo url_for('programsection/printSemesterSlip?id='.$sectionDetail->getId()) ?>">  
                       <em> Print Semester Slip  </em> </a> <br />
                <?php endif; ?>
                <?php if($showGenerateConsolidate): ?>
                       <a href="<?php echo url_for('programsection/generateConsolidate?id='.$sectionDetail->getId()) ?>">  
                       <em> Generate Consolidate </em> </a> <br />                       
                <?php endif; ?>   
                <?php if($showGenerateGradeReport): ?>
                       <a href="<?php echo url_for('programsection/generateGradeReport?id='.$sectionDetail->getId()) ?>">  
                       <em> Generate Grade Report </em> </a> <br />                       
                <?php endif; ?>                       
                <?php if($showGenerateCumulativeGradeReport): ?>
                       <a href="<?php echo url_for('programsection/generateCumulativeGradeReport?id='.$sectionDetail->getId()) ?>">  
                       <em> Generate Cumulative Grade Report </em> </a> <br />                       
                <?php endif; ?>     
                
                <br /> <br />
                Administrator Actions <br />
                <?php if($showPromote): ?>
                       <a href="<?php echo url_for('programsection/processPromotion?id='.$sectionDetail->getId()) ?>">  
                       <em> >> Do Promotion  </em> </a> <br />
                <?php else: ?>
                       >> Do Promotion
                <?php endif; ?>                          
                                              
                </div>
            </td>          
        </tr> 
    </table> 
</div>






<h4> Transfers </h4>
<table border="1" style="font-size:12px; background-color:white" cellpadding="4px"> 
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
<a href="<?php echo url_for('programsection/index') ?>"> << Back </a>
