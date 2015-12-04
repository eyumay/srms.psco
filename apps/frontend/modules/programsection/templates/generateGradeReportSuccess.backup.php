<?php foreach($enrollments as $enrollment): ?>
<?php 
    $count      = 1 ;
    $totalChr   = 0 ;    
    $totalGp    = 0 ; 
?> 
<table width='686' style='font-size:11px;'>
  <tr>
    <td colspan='2'>
		<div align='center' style='margin-bottom:10px;'> 
		<h5 style='margin:0px; padding:0px;'>Public Service College of Oromia</h5>
		<h5 style='margin:0px; padding:0px;'>Education Team of <?php echo $departmentName;  ?> </h5>
		<h5 style='margin:0px; padding:0px;'>Student Grade Report</h5>
		</div>	</td>
  </tr>
  <tr>
    <td width='311' align='left' valign='top'>Student Name: <?php echo $enrollment->getStudent()->getName().' '.$enrollment->getStudent()->getFathersName().' '.$enrollment->getStudent()->getGrandfathersName(); ?> <br>
      Major: <?php $enrollment->getProgram()->getName(); ?> <br>
      Academic Year: <?php echo $enrollment->getProgramSection()->getAcademicYear() ?> </td>
    <td width='281' align='left' valign='top'>ID No. <?php echo $enrollment->getStudent()->getStudentUid(); ?> <br>
      Program: <?php echo $enrollment->getProgram()->getName(); ?> <br>
      Year: <?php echo $sectionDetail->getYear(); ?> , Semester: <?php echo $sectionDetail->getSemester(); ?>  </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<table width='686' border='1' cellspacing='0' style='font-size:11px;' cellpadding='4px'>
  <tr style='background-color:#000099; color:white; font-weight: bold;' >
    <td width='278'>Title of Course </td>
    <td width='134'>Course Number </td>
    <td width='89'>Credit Hours </td>
    <td width='52'>Grade</td>
    <td width='109'>Grade Point </td>
  </tr>
  <?php foreach($enrollment->getRegistrations() as $registration): ?>
  <?php foreach($registration->getStudentCourseGrades() as $scg): ?>
  <tr>
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
        <?php 
           $gradePoint = $scg->getGrade()->getMaxValue()*$scg->getCourse()->getCreditHoure();
           $totalGp   += $gradePoint;
           echo $gradePoint; 
        ?>
    </td>
  </tr>
  <?php endforeach; ?>
  <?php endforeach; ?> 
  <tr>
    <td colspan='5' align='right'><br>
      Semester Total Chrs: <em> <?php echo $enrollment->getSemesterTotalChrs(); ?> </em> <br>
      Semester Total Grade Pt:  <em> <?php echo $enrollment->getSemesterTotalGradePoints(); ?> </em> <br /> <br />
      <?php 
        if($enrollment->getSemesterGradePoints() == 0 || $enrollment->getSemesterChrs() == 0)
          echo "cannot determine S.GPA";
        else
        {
            echo round($enrollment->getSGPA(), 2).'<br />';
        }

    ?>
    </td>
  </tr>
</table>

<table width='686' style='font-size:11px;'>
  <tr>
    <td colspan='2'>&nbsp;</td>
  </tr>
  <tr>
    <td width='311' align='left' valign='top'><?php echo $departmentName;  ?> Department______________ </td>
    <td width='281' align='right' valign='top'>Date______________</td>
  </tr>
  <tr>
    <td align='left' valign='top'>Academic Status: <span style='color: red; font-weight:bold; '>
        <?php                     
                    echo Statuses::getStudentStatus($enrollment);
        ?> </span> 
    </td>
    <td align='right' valign='top'>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='2' align='left' valign='top' style='font-size:11px;'>
		Note:- 1. This grade is invalid unless it bears the official seal of the college<br>
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			   2. There must be no eraser        
	</td>
  </tr>
</table>
<br /> <br /> 
<?php endforeach; ?> 
<a href="<?php echo url_for('programsection/sectiondetail?id='.$programSectionId) ?>"> << Back to section detail </a>