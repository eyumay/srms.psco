<?php foreach($students as $student): ?>
<?php 
    $count      = 1 ; 
    $totalChr   = 0 ;    
    $totalGp    = 0 ; 
    $leftoutTotalGp = 0;
    $leftoutTotalChr = 0;
    $leftoutTotalRChr = 0;
    $leftoutTotalRGp = 0; 
?>

<table width='686' style='font-size:11px;'>
  <tr>
    <td colspan='2'>
		<div align='center'> 
		<h5 style='margin:0px; padding:0px;'>Public Service College of Oromia</h5>
		<h5 style='margin:0px; padding:0px;'>Education Team of <?php echo $departmentName; ?></h5>
		<h5 style='margin:0px; padding:0px;'>Student Grade Report</h5>
		</div>	</td>
  </tr>
  <tr>
    <td width='311' align='left' valign='top'>Student's Name: <?php echo $student->getName().' '.$student->getFathersName().' '.$student->getGrandfathersName(); ?><br>
      Major: <?php echo $sectionDetail->getProgram(); ?><br>
      Academic Year: <?php echo $sectionDetail->getAcademicYear(); ?> </td>
    <td width='281' align='left' valign='top'>ID No. <?php echo $student->getStudentUid(); ?> <br>
      Program: <?php echo $programName;  ?><br>
      Year: <?php echo $sectionDetail->getYear(); ?>, Semester: <?php echo $sectionDetail->getSemester(); ?> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>





<!-- ##################################### NORMAL ENROLLMENTS ################################## -->
<!-- ##################################### NORMAL ENROLLMENTS ################################## -->
<!-- ##################################### NORMAL ENROLLMENTS ################################## -->
<?php foreach($student->getEnrollmentInfos() as $enrollment): ?> 
<?php if(!$enrollment->getLeftout()): ?>
<table width='686' border='1' cellspacing='0' style='font-size:11px;' cellpadding='5px'>
  <tr style='background-color:#000099; color: #FFFFFF;'>
    <td width='38'>No.</td>
    <td width='518'>Course Title </td>
    <td width='134'>Course Number </td>
    <td width='89'>Credit Hours </td>
    <td width='52'>Grade</td>
    <td width='109'>Grade Point </td>
  </tr>
  <?php foreach($enrollment->getRegistrations() as $registration ): ?>
  <?php foreach($registration->getStudentCourseGrades() as $scg): ?>
  <?php if( $scg->getIsCalculated() ): ?>
  <tr>
    <td> <?php echo $count.'.'; ?> </td>
    <td> <?php echo $scg->getCourse()->getName(); ?> </td>
    <td> <?php echo $scg->getCourse()->getCourseNumber(); ?> </td>
    <td> <?php echo $scg->getCourse()->getCreditHoure();
                    $totalChr += $scg->getCourse()->getCreditHoure();
    ?> </td>
    <td> 
                    <?php
                        if($scg->getGradeId() != '')
                                echo $scg->getGrade();
                        else
                            echo '--';
                    ?>
    </td>
    <td>  
        <?php $gradePoint = $scg->getGrade()->getValue()*$scg->getCourse()->getCreditHoure(); ?>
        <?php $totalGp   += $gradePoint; ?> 
        <?php echo $gradePoint; ?> 
    </td>
  </tr>
  <?php   $count++; ?>
  <?php endif; ?>
  <?php endforeach; ?>
  <?php endforeach;  ?>
</table>
<?php endif; ?>
<?php endforeach; ?>
<!-- ##################################### END OF NORMAL ENROLLMENTS ################################## -->
<!-- ##################################### END OF NORMAL ENROLLMENTS ################################## -->
<!-- ##################################### END OF NORMAL ENROLLMENTS ################################## -->


<!-- ##################################### ADDED ENROLLMENTS ################################## -->
<!-- ##################################### ADDED ENROLLMENTS ################################## -->
<!-- ##################################### ADDED ENROLLMENTS ################################## -->
<?php $addEnrollmentExists = FALSE; ?>
<?php foreach($student->getEnrollmentInfos() as $enrollment): ?> 
    <?php if($enrollment->checkIfAddEnrollmentExists()): ?>
        <?php $addEnrollmentExists = TRUE; ?>
    <?php endif; ?>
<?php endforeach; ?>


<?php if($addEnrollmentExists): ?>
<h4> Semester Adds </h4>
<table width='686' border='1' cellspacing='0' style='font-size:11px;' cellpadding='5px'>
<?php foreach($student->getEnrollmentInfos() as $enrollment): ?> 
<?php if($enrollment->getLeftout()): ?>
  <?php foreach($enrollment->getRegistrations() as $registration ): ?>
  <?php foreach($registration->getStudentCourseGrades() as $scg): ?>
  <?php if( $scg->getIsCalculated() ): ?>  
  <tr>
    <td> <?php echo $count.'.'; ?> </td>
    <td> <?php echo $scg->getCourse()->getName(); ?> </td>
    <td> <?php echo $scg->getCourse()->getCourseNumber(); ?> </td>
    <td> <?php echo $scg->getCourse()->getCreditHoure();
                    $totalChr += $scg->getCourse()->getCreditHoure(); ?> 
    </td>
    <td> 
                    <?php
                        if($scg->getGradeId() != '')
                                echo $scg->getGrade();
                        else
                            echo '--';
                    ?>
    </td>
    <td>  
        <?php $gradePoint = $scg->getGrade()->getValue()*$scg->getCourse()->getCreditHoure(); ?>
        <?php $totalGp   += $gradePoint; ?> 
        <?php echo $gradePoint; ?> 
    </td>
  </tr>
  <?php   $count++; ?>
  <?php endif; ?>
  <?php endforeach; ?>
  <?php endforeach;  ?>

<?php endif; ?>

<?php endforeach; ?>
</table>
<?php endif; ?>
<!-- ##################################### END OF ADDED ENROLLMENTS ################################## -->
<!-- ##################################### END OF ADDED ENROLLMENTS ################################## -->
<!-- ##################################### END OF ADDED ENROLLMENTS ################################## -->











<table width='686' style='font-size:11px;' cellpadding='5px'>

  <tr>
    <td width='147' align='left' valign='top'>Academic Status:         
        <span style='color:red;'> <?php echo Statuses::getStudentStatus($student->getEnrollmentInfos(), $sectionDetail->getyear(), $sectionDetail->getSemester()) ?>  </span> 
    </td>
    <td width='511' align='right' valign='top'><table width='509' border='1' cellpadding='5px' cellspacing='0' style='font-size:11px;'>
      <tr>
        <td width='124' align='left' valign='top'>&nbsp;</td>
        <td width='220' align='left' valign='top'>Credit Hours </td>
        <td width='170' align='right' valign='top'>Grade Point </td>
        <td width='170' align='right' valign='top'>GPA</td>
      </tr>
      <tr>
        <td align='left' valign='top'>Current Semester </td>
        <td align='left' valign='top'><?php echo Statuses::getSemesterCreditHours($student->getEnrollmentInfos(), $sectionDetail->getYear(), $sectionDetail->getSemester()); ?> </td>
        <td align='right' valign='top'><?php echo Statuses::getSemesterGradePoints($student->getEnrollmentInfos(), $sectionDetail->getYear(), $sectionDetail->getSemester()); ?> </td>
        <td align='right' valign='top'>
            <?php echo Statuses::getGPA($student->getEnrollmentInfos(), $sectionDetail->getYear(), $sectionDetail->getSemester() ) ?>
        </td>
      </tr>
      <tr>
        <td align='left' valign='top'>Previous Semester </td>
        <td align='left' valign='top'><?php echo Statuses::getPreviousCreditHours($student->getEnrollmentInfos(), $sectionDetail->getYear(), $sectionDetail->getSemester()); ?></td>
        <td align='right' valign='top'><?php echo Statuses::getPreviousGradePoints($student->getEnrollmentInfos(), $sectionDetail->getYear(), $sectionDetail->getSemester()); ?></td>
        <td align='right' valign='top'>
            <?php echo Statuses::getPreviousSGPA($student->getEnrollmentInfos(), $sectionDetail->getYear(), $sectionDetail->getSemester()); ?>
        </td>
      </tr>
      <tr>
        <td align='left' valign='top'>Cumulative</td>
        <td align='left' valign='top'><?php echo Statuses::getTotalCreditHours($student->getEnrollmentInfos(), $sectionDetail->getYear(), $sectionDetail->getSemester())//$totalChrs = $enrollment->getTotalChrs() + $leftoutTotalChr - $leftoutTotalRChr; echo $totalChrs; ?></td>
        <td align='right' valign='top'><?php echo Statuses::getTotalGradePoints($student->getEnrollmentInfos(), $sectionDetail->getYear(), $sectionDetail->getSemester() )//$totalGpts =  $enrollment->getTotalGradePoints() + $leftoutTotalGp - $leftoutTotalRGp; echo $totalGpts; ?></td>
        <td align='right' valign='top'>
            <?php
                echo Statuses::getCGPA($student->getEnrollmentInfos() , $sectionDetail->getYear(), $sectionDetail->getSemester() ); 
            ?>              
        </td>
      </tr>
    </table></td>
  </tr>

</table>
<table width='686' style='font-size:11px;' cellpadding='5px'>
  <tr>
    <td colspan='2'>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='2'>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='2'>&nbsp;</td>
  </tr>
  <tr>
    <td width='311' align='center' valign='top'> ___________________________________ </td>
    <td width='281' align='center' valign='top'>___________________________________</td>
  </tr>
  <tr>
    <td align='center' valign='top'>Date</td>
    <td align='center' valign='top'>Department</td>
  </tr>
  <tr>
    <td colspan='2' align='left' valign='top'>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='2' align='left' valign='top'>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='2' align='left' valign='top'>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='2' align='left' valign='top' style='font-size:11px;'>THIS IS NOT AN OFFICIAL TRANSCRIPT. </td>
  </tr>
</table>

<?php endforeach; ?>

<br />
<br />

<a href="<?php echo url_for('programsection/sectiondetail?id='.$programSectionId) ?>"> << Back to section detail </a>

