<h4> Manage Add Drop | <span style="color:red;"> Student Course ADD </span> </h4> 
<!-- Section Detail Start -->
<table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="800px">
    
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

<!-- STUDENT INFORMATION Detail Start -->
<table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="800px">
    
    <tr style="background-color: #000099; color: white;">
        <td align="center"> Student Information </td>
    </tr>

    <tr>
        <td valign="top">
            Full Name: <span style="color:red"> <i> <?php echo $student->getName(). ' '.$student->getFathersName(). ' ' .$student->getGrandfathersName(); ?> </i> </span> 
            ID: <span style="color:red"> <i> <?php echo $student->getStudentUid(); ?> </i> </span>  <br />
            Birth Day: <span style="color:red"> <i> <?php echo $student->getDateOfBirth(); ?> </i> </span>  <br />
            Admission Year: <span style="color:red"> <i> <?php echo $student->getAdmissionYear(); ?> </i> </span>  <br />            
        </td>
    </tr>
</table>
<!-- STUDENT INFORMATION Detail End -->

<!-- course information START -->
<h5 style="margin-top:20px;"> COURSE INFORMATION </h5>
<table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="800px">
    
    <tr style="background-color: #000099; color: white;">
        <td align="center"> Course Name </td>
        <td align="center"> Course Number /Code </td>
        <td align="center"> Credit Hour </td>
        <td align="center"> Grade Type </td>
    </tr>
        <td align="center"> <?php echo $courseDetail->getName(); ?> </td>
        <td align="center"> <?php echo $courseDetail->getCourseNumber(); ?> </td>
        <td align="center"> <?php echo $courseDetail->getCreditHoure(); ?> </td>
        <td align="center"> <?php echo $courseDetail->getGradeType(); ?> </td>
    <tr>
    </tr>
</table>
<!-- course information END -->

<!-- COURSE OFFER SECTION information START -->
<h5 style="margin-top:20px;"> COURSE INFORMATION </h5>
<table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="800px">
    <?php $count=1 ; ?>
    <tr style="background-color: #000099; color: white;">
        <td align="center"> SN. </td>
        <td align="center"> Section detail </td>        
    </tr>
    <?php if($showClearanceEnrollmentForm): ?>
        <?php foreach($programSectionsIdNamePairArray as $courseSection): ?>
            <tr>
                <td align="center"> <?php echo $count; ?> </td>
                <td align="center"> <?php echo $courseSection; ?> </td>
            </tr>
            <?php $count++; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
<!--  COURSE OFFER SECTION information END -->

    <h5 style="margin-top:20px;"> Manage ADD For Failed Courses Clearance Enrollments </h5>
<?php if($showClearanceEnrollmentForm): ?>    
    
    <form action="<?php echo url_for('dropadd/add/?studentId='.$student->getId().'&sectionId='.$sectionDetail->getId().'&courseId='.$courseDetail->getId()); ?>" method="post">
        <table>
            <?php echo $courseAddEnrollmentForm; ?>
        </table>
        <input type="submit" value="Make Course Add Enrollment" />
    </form>
        
<?php else: ?>
     <ul>
       <li style="font-size: 11px; color:red;"> There are no sections offering such course. </li>
    </ul>
<? endif; ?>    
