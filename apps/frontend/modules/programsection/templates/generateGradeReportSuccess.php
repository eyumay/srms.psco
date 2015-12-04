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
<table width='666' border='1' cellspacing='0' style='font-size:11px;' cellpadding='5px'>
  <tr style='background-color:#000099; color: #FFFFFF;'>
    <td width='134' align="center"> Course Number </td>
    <td width='498'> Course Title</td>
    <td width='89' align="center">Credit Hours </td>
    <td width='52' align="center">Grade</td>
    <td width='109' align="center">Grade Point </td>
  </tr>
  <?php foreach($enrollment->getRegistrations() as $registration ): ?>
  <?php foreach($registration->getStudentCourseGrades() as $scg): ?>
    <?php if($scg->getIsCalculated()): ?>
    <tr>
      <td align="center"> <?php echo $scg->getCourse()->getCourseNumber(); ?>  </td>
      <td> <?php echo $scg->getCourse()->getName(); ?></td>
      <td align="center"> <?php echo $scg->getCourse()->getCreditHoure();
                      $totalChr += $scg->getCourse()->getCreditHoure();
      ?> </td>
      <td align="center"> 
                      <?php
                          if($scg->getGradeId() != '')
                                  echo $scg->getGrade();
                          else
                              echo '--';
                      ?>
      </td>
      <td align="center">  
          <?php $gradePoint = $scg->getGrade()->getValue()*$scg->getCourse()->getCreditHoure(); ?>
          <?php $totalGp   += $gradePoint; ?> 
          <?php echo $gradePoint; ?> 
      </td>
    </tr>
    <?php   $count++; ?>
    <?php endif; ?>
  <?php endforeach; ?>
  <?php endforeach;  ?>
    <tr> 
        <td></td>
        <td align="center"> <strong> Total </strong> </td>
        <td align="center"> <strong>  <?php echo $totalChr; ?> </strong> </td>
        <td align="center"> <strong>  </strong> </td>
        <td align="center"> <strong>  <?php echo $totalGp;  ?> </strong> </td>
    </tr>
</table>
<?php endif; ?>
<?php endforeach; ?>
<!-- ##################################### END OF NORMAL ENROLLMENTS ################################## -->
<!-- ##################################### END OF NORMAL ENROLLMENTS ################################## -->
<!-- ##################################### END OF NORMAL ENROLLMENTS ################################## -->


<!-- ##################################### ADDED ENROLLMENTS ################################## -->
<!-- ##################################### ADDED ENROLLMENTS ################################## -->
<!-- ##################################### ADDED ENROLLMENTS ################################## -->
<?php foreach($student->getEnrollmentInfos() as $enrollment): ?> 
<?php if($enrollment->getLeftout()): ?>
<table width='666' border='1' cellspacing='0' style='font-size:11px;' cellpadding='5px'>
  <tr style='background-color:#000099; color: #FFFFFF;'>
    <td width='134' align="center"> Course Number </td>
    <td width='498'> Course Title</td>
    <td width='89' align="center">Credit Hours </td>
    <td width='52' align="center">Grade</td>
    <td width='109' align="center">Grade Point </td>
  </tr>
  <?php foreach($enrollment->getRegistrations() as $registration ): ?>
  <?php foreach($registration->getStudentCourseGrades() as $scg): ?>
  <tr>
    <td align="center"> <?php echo $scg->getCourse()->getCourseNumber(); ?>  </td>
    <td> <?php echo $scg->getCourse()->getName(); ?></td>
    <td align="center"> <?php echo $scg->getCourse()->getCreditHoure();
                    $totalChr += $scg->getCourse()->getCreditHoure();
    ?> </td>
    <td align="center"> 
                    <?php
                        if($scg->getGradeId() != '')
                                echo $scg->getGrade();
                        else
                            echo '--';
                    ?>
    </td>
    <td align="center">  
        <?php $gradePoint = $scg->getGrade()->getValue()*$scg->getCourse()->getCreditHoure(); ?>
        <?php $totalGp   += $gradePoint; ?> 
        <?php echo $gradePoint; ?> 
    </td>
  </tr>
  <?php   $count++; ?>
  <?php endforeach; ?>
  <?php endforeach;  ?>
</table>
<?php endif; ?>

<?php endforeach; ?>
<!-- ##################################### END OF ADDED ENROLLMENTS ################################## -->
<!-- ##################################### END OF ADDED ENROLLMENTS ################################## -->
<!-- ##################################### END OF ADDED ENROLLMENTS ################################## -->











<table width='666' style='font-size:11px;' cellpadding='5px'>

  <tr>
    <td width='147' align='left' valign='top'>
    </td>
    <td width='511' align='right' valign='top'><table width='509' border='1' cellpadding='5px' cellspacing='0' style='font-size:11px;'>
      <tr>
        <td width='124' valign='top'>&nbsp;</td>
        <td width='210' align='center'> Semester Chrs </td>
        <td width='170' align='center'>Semester Gpts </td>
        <td width='160' align='center'>Semester GPA</td>
      </tr>
      <tr>
        <td align='left' >Current Semester </td>
        <td  align='center'><?php echo Statuses::getSemesterCreditHours($student->getEnrollmentInfos(), $sectionDetail->getYear(), $sectionDetail->getSemester()); ?> </td>
        <td  align='center'><?php echo Statuses::getSemesterGradePoints($student->getEnrollmentInfos(), $sectionDetail->getYear(), $sectionDetail->getSemester()); ?> </td>
        <td  align='center'>
            <?php echo Statuses::getGPA($student->getEnrollmentInfos(), $sectionDetail->getYear(), $sectionDetail->getSemester() ) ?>
        </td>

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
    <td colspan='2'> 
Academic Status:         
        <span style='color:red;'> <?php echo Statuses::getStudentStatus($student->getEnrollmentInfos(), $sectionDetail->getyear(), $sectionDetail->getSemester()) ?>  </span>         
    </td>
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

