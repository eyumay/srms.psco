<?php $check = $sectionDetail->getEnrollmentInfos(); ?>
<h4> Transfer: <span style="color:red;"> Center Change Management </span> </h4>


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
            <td align="center"> <strong> Current Center Enrollment </strong></td>
            <td align="center"> <strong> To Center </strong> </td>
        </tr> 
        <tr>
            <td valign="top">
                Program: <span style="color:red"> <i> <?php echo $sectionDetail->getProgram(); ?> </i> </span>  <br />
                Center: <span style="color:red"> <i> <?php echo $sectionDetail->getCenter(); ?> </i> </span>  <br />
                Academic Year: <span style="color:red"> <i> <?php echo $sectionDetail->getAcademicYear(); ?></i> </span> <br />
                Year: <span style="color:red"> <i> <?php echo $sectionDetail->getYear(); ?> </i> </span>  <br />
                Semester: <span style="color:red"> <i> <?php echo $sectionDetail->getSemester(); ?> </i> </span>    <br />              
            </td>
            <td valign="top">  
                <table width="100%" border="0" style="font-size:11px; background-color:white" align="center">
                    <!-- TO NEW CENTER START -->                    
                    <form action="<?php echo url_for('centerchange/studentTransferDetail?sectionId='.$programSectionId.'&studentId='.$studentId.'&enrollmentId='.$enrollmentId) ?>" method="post">
                        <?php if($showToSectionForm): ?>
                        <td>
                            <?php echo $centerchangeForm; ?>                                                                                                
                        </td>
                        <td><input type="submit" value="Change Center" /></td>
                        <?php else: ?> 
                            Student cannot Change center because there are no Active Centers.
                        <?php endif; ?>
                    </form>
                    <!-- TO NEW CENTER END -->
                </table>                
            </td>
        </tr> 
    </table>
<!-- COURSE LIST AND FORM END -->


</div>

<a href="<?php echo url_for('programsection/index') ?>"> << Back </a>
