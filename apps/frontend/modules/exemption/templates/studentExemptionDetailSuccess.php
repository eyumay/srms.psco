<h4> Course <span style="color:red;"> Exemption Management </span> </h4>


<!-- Section Detail Start -->
<table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="650px">
    
    <tr style="background-color: #000099; color: white;">
        <td align="center"> Class Information </td>
    </tr>

    <tr>
        <td valign="top">
            Program: <span style="color:red"> <i> <?php echo $enrollment->getProgram()->getName(); ?> </i> </span> &nbsp; &nbsp;
            Center: <span style="color:red"> <i> <?php echo $enrollment->getProgramSection()->getCenter(); ?> </i> </span>  &nbsp; &nbsp;
            Academic Year: <span style="color:red"> <i> <?php echo $enrollment->getAcademicYear(); ?></i> </span>&nbsp; &nbsp;
            Year: <span style="color:red"> <i> <?php echo $enrollment->getYear(); ?> </i> </span> &nbsp; &nbsp;
            Semester: <span style="color:red"> <i> <?php echo $enrollment->getSemester(); ?> </i> </span>
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
            Full Name: <span style="color:red"> <i> <?php echo $enrollment->getStudent()->getName().' '.$enrollment->getStudent()->getFathersName().' '.$enrollment->getStudent()->getGrandfathersName(); ?> </i> </span>&nbsp; &nbsp;
            ID No.: <span style="color:red"> <i><?php echo $enrollment->getStudent()->getStudentUid(); ?></i> </span>&nbsp; &nbsp;
            Entry Year: <span style="color:red"> <i> <?php echo $enrollment->getStudent()->getAdmissionYear(); ?></i> </span>&nbsp; &nbsp;
        </td>
    </tr>
</table>
<!-- STUDENT DETAIL END -->







<!-- COURSE LIST AND FORM START -->
<p style="font-size:12px; margin-bottom: 2px; margin-top:10px;" > Use the following form to Activate Exemption Process  </p>
<div style="font-size:12px;"> 
    <table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="650px">

        <tr style="background-color: #000099; color: white;">
            <td align="center"> Form to Activate Exemption </td>
            <td align="center"> Registered courses </td>
        </tr> 
        <tr>
            <td valign="top">
                <table width="100%" border="0" style="font-size:11px; background-color:white" align="center">
                    <!-- THIS PORTION IS SHOWN ONLY TO HOD 11111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111-->
                    <?php if($sf_user->getAttribute('credential') == 'hod'): ?>
                    <form action="<?php echo url_for('exemption/studentExemptionDetail?sectionId='.$programSectionId.'&studentId='.$studentId.'&enrollmentId='.$enrollmentId) ?>" method="post">
                        <td>
                            <?php echo $frontendExemptionRequestForm ; ?>
                        </td>
                        <td align="right"><input type="submit" value="Activate Exemption" /></td>
                    </form>
                    <?php endif; ?>
                    <!-- END TO HOD VIEW -->

                    <!-- THIS PORTION IS SHOWN ONLY TO DATAWORKER 2222222222222222222222222222222222222222222222222222222222222222222222222222222222222 -->
                    <?php if($sf_user->getAttribute('credential') == 'dataworker'): ?>
                    <?php if($showActivatedExemptions): ?>
                    <form action="<?php echo url_for('exemption/doexemptionsubmission?sectionId='.$programSectionId.'&studentId='.$studentId.'&enrollmentId='.$enrollmentId) ?>" method="post">
                        <td>
                            <?php echo $frontendExemptionSubmissionForm; ?>
                        </td>
                        <td align="right"><input type="submit" value="Save Exemption Grade" /></td>
                    </form>
                    <?php else: ?>
                    <tr>
                        <td> No course to Exempt </td>
                    </tr>
                    <?php endif;  ?>
                    <?php endif; ?>
                    <!-- END TO DATAWORKER VIEW -->
                    
                </table>
            </td>
            <td valign="top">
                <!-- Course list 3333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333 -->
                <table width="100%" border="0" style="font-size:11px; background-color:white" cellpadding="4px" align="center">
                    <?php if($enrollment->getRegistrations()): ?>
                    <?php foreach($enrollment->getRegistrations() as $registration): ?>
                    <?php foreach($registration->getStudentCourseGrades() as $scg): ?>
                    <tr>
                        <?php if($scg->getIsExempted() != 1): ?>
                        <td align="right"><?php echo $scg->getCourse(). ' '.$showActivatedExemptions; ?> </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="2"> All courses are exempted </td>
                    </tr>
                    <?php endif; ?>
                </table>
                <!-- Course list end 3333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333 -->
            </td>
        </tr> 
    </table>
<!-- COURSE LIST AND FORM END -->

<!-- ACTIVATED REGRADE COURSES LIST START -->
<?php if($showActivatedExemptions): ?>
<p style="font-size:12px; margin-bottom: 2px; margin-top:10px;" > Activated Exemptions </p>
<div style="font-size:12px;">
    <table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="650px">

        <tr style="background-color: #000099; color: white;">
            <td align="center"> <strong> Course Name </strong> </td>
            <td align="center"> <strong> Grade </strong> </td>
            <td align="center"> <strong> Action </strong> </td>
        </tr>
        <?php foreach($enrollment->getRegistrations() as $registration ): ?>
        <?php foreach($registration->getStudentCourseGrades() as $scg ): ?>
        <?php if($scg->getIsExempted() == 2 || $scg->getIsExempted() == 3): ?>
        <tr>
            <td align="center"> <strong> <?php  echo $scg->getCourse()->getName(); ?> </strong> </td>
            <td align="center"> 
                <?php  if($scg->getGradeId() == ''): ?>
                under process
                <?php else: ?>
                <?php echo $scg->getGrade(); ?>
                <?php endif; ?> 
            </td>
            <!-- THIS PORTION IS SHOWN ONLY TO HOD -->
            <?php if($sf_user->getAttribute('credential') == 'hod'): ?>
            <td valign="top">
                <ul>
                    <li>
                        <a href="<?php echo url_for('exemption/cancelexemption?sectionId='.$programSectionId.'&studentId='.$studentId.'&enrollmentId='.$enrollmentId.'&studentCourseGradeId='.$scg->getId()) ?>">
                            Cancel Exemption
                        </a> </li>
                    <?php if($scg->getIsExempted() == 3): ?>
                    <li>
                        <a href="<?php echo url_for('exemption/approveexemption?sectionId='.$programSectionId.'&studentId='.$studentId.'&enrollmentId='.$enrollmentId.'&studentCourseGradeId='.$scg->getId() )?>">
                            Approve Exemption 
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
        <?php endif; ?> 
        <?php endforeach;  ?>
        <?php endforeach;  ?>
    </table>
<?php endif; ?> 
<!-- ACTIVATED REGRADE COURSES LIST END -->


<!-- 55555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555 -->
    <?php //if($showApprovedExemptions): ?>
    <p style="font-size:12px; margin-bottom: 2px; margin-top:10px;" > Already Approved Exemptions </p>
    <table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="650px">

        <tr style="background-color: #000099; color: white;">
            <td align="center"> <strong> Course Name </strong> </td>
            <td align="center"> <strong> Grade </strong> </td>
        </tr>
        <?php foreach($enrollment->getRegistrations() as $registration ): ?>
        <?php foreach($registration->getStudentCourseGrades() as $scg ): ?>
        <?php if($scg->getIsExempted() == 1): ?>
        <tr>
            <td> <?php echo $scg->getCourse()->getName(); ?> </td>
            <td> <?php echo $scg->getGrade();  ?></td>
        </tr>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php endforeach; ?>
    </table>
<!-- 55555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555 -->
    <?php //endif; ?>
</div>

<a href="<?php echo url_for('exemption/index') ?>"> << Back </a>
