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
<h4> Transfer <span style="color:red;"> Center Change Management </span> </h4>


<!-- Section Detail Start -->
<table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="600px">
    
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



<!-- STUDENT LIST START -->
<p style="font-size:12px; margin-bottom: 2px; margin-top:10px;" > Available Students in the class </p>
<div style="font-size:12px;"> 
    <table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="600px">

        <tr style="background-color: #000099; color: white;">
            <td> S.N </td>
            <td> Students Full Name </td>
            <td> <b> Actions </b>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td> 
        </tr> 
        
        <?php if( $check[0] != ''): ?>
        <?php $count=1; ?>
        <?php foreach($sectionDetail->getEnrollmentInfos() as $enrollment ): ?> 
        <tr>
            <td>
                <?php echo $count.'. '; ?> 
            </td>
            <td valign="top">  
                <?php echo $enrollment->getStudent(); ?>     <br />    
                <?php $count++;   ?>
                                 
            </td>
            <td valign="top">
                <a href="<?php echo url_for('centerchange/studentTransferDetail?sectionId='.$enrollment->getSectionId().'&studentId='.$enrollment->getStudentId().'&enrollmentId='.$enrollment->getId()) ?>"> Goto Transfer  </a>
            </td>
        </tr> 
        <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td colspan="3">
                <?php echo 'No Enrolled Students / Class is empty <br />';
                            echo 'Please go to Program Section to enroll students ';
                ?>
            </td>
        </tr>
        <?php endif; ?>
    </table> 
</div>
<!-- STUDENTS LIST END -->


<a href="<?php echo url_for('centerchange/index') ?>"> << Back </a>
