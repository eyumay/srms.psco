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
<h4> Course <span style="color:red;"> Regrade Management </span> </h4>


<!-- Section Detail Start -->
<table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="650px">
    
    <tr style="background-color: #000099; color: white;">
        <td align="center"> Class Information </td>
    </tr>

    <tr>
        <td valign="top">
            Program: <span style="color:red"> <i> <?php echo $sectionDetail->getProgram(); ?> </i> </span> &nbsp; &nbsp;
            Center: <span style="color:red"> <i> <?php echo $sectionDetail->getCenter(); ?> </i> </span>  &nbsp; &nbsp;
            Academic Year: <span style="color:red"> <i> <?php echo $sectionDetail->getAcademicYear(); ?></i> </span>&nbsp; &nbsp;
            Year: <span style="color:red"> <i> <?php echo $sectionDetail->getYear(); ?> </i> </span> &nbsp; &nbsp;
            Semester: <span style="color:red"> <i> <?php echo $sectionDetail->getSemester(); ?> </i> </span> 
        </td>
    </tr>
</table>
<!-- Section Detail End -->
<br />

<!-- STUDENT DETAIL START -->
<table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="650px">

    <tr style="background-color: #000099; color: white;">
        <td align="center"> Student Information </td>
    </tr>
    <tr>
        <td valign="top">
            Full Name: <span style="color:red"> <i> <?php echo $studentDetail->getName().' '.$studentDetail->getFathersName().' '.$studentDetail->getGrandfathersName(); ?> </i> </span>&nbsp; &nbsp;
            ID No.: <span style="color:red"> <i><?php echo $studentDetail->getStudentUid(); ?></i> </span>&nbsp; &nbsp;
            Entry Year: <span style="color:red"> <i> <?php echo $studentDetail->getAdmissionYear(); ?></i> </span>&nbsp; &nbsp;
        </td>
    </tr>
</table>
<!-- STUDENT DETAIL END -->


<!-- COURSE LIST AND FORM START -->
<p style="font-size:12px; margin-bottom: 2px; margin-top:10px;" > Use the following form to Activate Regrade </p>
<div style="font-size:12px;"> 
    <table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="650px">

        <tr style="background-color: #000099; color: white;">
            <td align="center"> Form To Regrade</td>
            <td align="center"> Current Grade </td>
        </tr> 
        <tr>
            <td valign="top">
                <table width="100%" border="0" style="font-size:11px; background-color:white" align="center">
                    <!-- THIS PORTION IS SHOWN ONLY TO HOD -->
                    <?php if($sf_user->getAttribute('credential') == 'hod'): ?>
                    <form action="<?php echo url_for('regrade/studentRegradeDetail?sectionId='.$programSectionId.'&studentId='.$studentId.'&enrollmentId='.$enrollmentId) ?>" method="post">
                        <td>
                            <?php echo $frontendRegradeRequestForm; ?>                                                    
                        </td>
                        <td><input type="submit" value="Activate Regrade" /></td>
                    </form>
                    <?php endif; ?>
                    <!-- END TO HOD VIEW -->

                    <!-- THIS PORTION IS SHOWN ONLY TO DATAWORKER -->
                    <?php if($sf_user->getAttribute('credential') == 'dataworker'): ?>
                    <form action="<?php echo url_for('regrade/doregradesubmission?sectionId='.$programSectionId.'&studentId='.$studentId.'&enrollmentId='.$enrollmentId) ?>" method="post">
                        <td>
                            <?php echo $frontendRegradeSubmissionForm; ?>
                        </td>
                        <td><input type="submit" value="Save Regrade" /></td>
                    </form>
                    <?php endif; ?>
                    <!-- END TO DATAWORKER VIEW -->
                    
                </table>
            </td>
            <td valign="top">  
                <table width="100%" border="0" style="font-size:11px; background-color:white" cellpadding="4px" align="center">
                    <tr>
                        <td align="right"> <strong> Course Name </strong></td> <td align="left"><strong>Grade</strong></td>
                    </tr>
                    <?php if($showCourseGrades): ?>
                    <?php foreach($activeGradedStudentCourses as $courseGrade): ?>
                    <tr>
                        <td align="right"><?php echo $courseGrade->getCourse(); ?> - </td> <td align="left"> <?php echo $courseGrade->getGrade(); ?> </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="2"> There are no graded courses this time!</td>
                    </tr>
                    <?php endif; ?>
                </table>
            </td>
        </tr> 
    </table>
<!-- COURSE LIST AND FORM END -->

<!-- ACTIVATED REGRADE COURSES LIST START -->
<?php if($showActivatedRegrade): ?>
<p style="font-size:12px; margin-bottom: 2px; margin-top:10px;" > Activated Regrades </p>
<div style="font-size:12px;">
    <table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="650px">

        <tr style="background-color: #000099; color: white;">
            <td align="center"> <strong> Course Name </strong> </td>
            <td align="center"> <strong> New Grade </strong> </td>
            <td align="center"> <strong> Action </strong> </td>
        </tr>
        <?php foreach($activatedCoursesForRegrade as $activatedCFG): ?>
        <tr>
            <td valign="top">
                <?php echo $activatedCFG->getCourse(); ?>
            </td>
            <td valign="top">
                <?php if($activatedCFG->getGradeId() == NULL): ?>
                Under Process
                <?php else: ?>
                <?php echo $activatedCFG->getGrade(); ?> 
                <?php endif; ?>
            </td>
                                
            <!-- THIS PORTION IS SHOWN ONLY TO HOD -->
            <?php if($sf_user->getAttribute('credential') == 'hod'): ?>
            <td valign="top">
                <ul>
                    <li>
                        <a href="<?php echo url_for('regrade/cancelregrade?sectionId='.$programSectionId.'&studentId='.$studentId.'&enrollmentId='.$enrollmentId.'&studentCourseGradeId='.$activatedCFG->getId()) ?>">
                            Cancel Regrade
                        </a> </li>
                    <?php if($activatedCFG->getRegradeStatus() == 3): ?>
                    <li>
                        <a href="<?php echo url_for('regrade/approveregrade?sectionId='.$programSectionId.'&studentId='.$studentId.'&enrollmentId='.$enrollmentId.'&studentCourseGradeId='.$activatedCFG->getId() )?>">
                            Approve Regrade
                        </a></li>
                    <?php endif; ?>
                </ul>
            </td>
            <?php endif; ?>
            <!-- END TO HOD VIEW -->

            <!-- THIS PORTION IS SHOWN ONLY TO DATAWORKER -->
            <?php if($sf_user->getAttribute('credential') == 'dataworker'): ?>
            <td valign="top">
            ----
            </td>
            <?php endif; ?>
            <!-- END TO DATAWORKER VIEW -->
        </tr>
        <?php endforeach;  ?>
    </table>
<?php endif; ?> 
<!-- ACTIVATED REGRADE COURSES LIST END -->
<?php print_r($regradeRegistrationIdsArray); ?> 

</div>

<a href="<?php echo url_for('programsection/index') ?>"> << Back </a>
