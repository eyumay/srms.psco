<h3> Course Add Module </h3> 
<table border="1px" style="font-size:11px" width="100%">
    <tr>
        <td> Year  </td>
        <td> Seme </td>
        <td> Acad. Year </td>
        
        <td> P Chrs </td>
        <td> S Chrs </td>
        <td> Total Chrs </td>
        
        <td> P G.Points </td>
        <td> S G.Points </td>
        <td> Total G.Points </td>
        
        <td> P.R. Chrs </td>
        <td> S R. Chrs </td>
        <td> Total Rep. Chrs </td>
        
        <td> P R. G.Points </td>
        <td> S R. G.Points </td>                
        <td> Total R. G.Points </td>
        <td> S.Action </td>
        <td> E.Action </td> 
        <td> Leftout </td> 
    </tr>    
<?php foreach($student->getEnrollmentInfos() as $enrollment): ?>
    <tr>
        <td> <?php echo $enrollment->getYear(); ?> </td>
        <td> <?php echo $enrollment->getSemester(); ?> </td>
        <td> <?php echo $enrollment->getAcademicYear(); ?> </td>
        
        <td> <?php echo $enrollment->getPreviousChrs(); ?> </td>
        <td> <?php echo $enrollment->getSemesterChrs(); ?> </td>
        <td> <?php echo $enrollment->getTotalChrs(); ?> </td>
        
        <td> <?php echo $enrollment->getPreviousGradePoints(); ?> </td>
        <td> <?php echo $enrollment->getSemesterGradePoints(); ?> </td>
        <td> <?php echo $enrollment->getTotalGradePoints(); ?> </td>
        
        <td> <?php echo $enrollment->getPreviousRepeatedChrs(); ?> </td>
        <td> <?php echo $enrollment->getSemesterRepeatedChrs(); ?> </td>
        <td> <?php echo $enrollment->getTotalRepeatedChrs(); ?> </td>
        
        <td> <?php echo $enrollment->getPreviousRepeatedGradePoints(); ?> </td>
        <td> <?php echo $enrollment->getSemesterRepeatedGradePoints(); ?> </td>                
        <td> <?php echo $enrollment->getTotalRepeatedGradePoints(); ?> </td>
        <td> <?php echo $enrollment->getSemesterAction(); ?> </td>
        <td> <?php echo $enrollment->getEnrollmentAction(); ?> </td>
        <td> <?php echo ($enrollment->getLeftout())?'YES':'NO'; ?> </td>
        <td> <?php echo $enrollment->getProgramSection(); ?> </td>
    </tr>
<?php endforeach; ?>    
</table> 

    
<?php if($showFailedCourses): ?>    
    <p style="font-size: 11px; margin-bottom: 5px; margin-top: 15px;"> Student can add the following courses at this semester </p>
    <ul>
    <?php foreach($failedCoursesIdNamePairArray as $id=>$courseName): ?> 
        <li> <?php echo $courseName; ?>  </li>
    <?php endforeach; ?> 
    </ul>
    
<? endif; ?>
    <h4> Manage ADD Failed Course Clearance Enrollments </h4>
<?php if($showClearanceEnrollmentForm): ?>    
    <p style="font-size: 14px; margin-bottom: 5px; margin-top: 15px;"> **Student can be enrolled to below sections</p>
    
    <form action="<?php echo url_for('dropadd/add/?studentId='.$student->getId().'&sectionId='.$sectionDetail->getId()); ?>" method="post">
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
    
    <?php print_r($coursePoolsArray); ?> 
    