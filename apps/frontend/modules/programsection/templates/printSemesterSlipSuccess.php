<?php 
    $count      = 1 ; 
    $totalChr   = 0 ; 
?>
<table width='686' style='font-size:11px;'>
  <tr>
    <td colspan='2'>
		<div align='center'> 
		<h5 style='margin:0px; padding:0px;'>Public Service College of Oromia</h5>
		<h5 style='margin:0px; padding:0px;'>Education Team of <?php echo $departmentName;  ?>  </h5>
                <h5 style='margin:0px; padding:0px;'>  Program: <?php echo $programName;  ?></h5>
		<h5 style='margin:0px; padding:0px;'>Registration Slip</h5>
		
		</div>	</td>
  </tr>
  <tr>
    <td align='left' valign='top'>&nbsp;</td>
    <td align='left' valign='top'>&nbsp;</td>
  </tr>
  <tr>
    <td width='311' align='left' valign='top'>
      First Name: _________________________<br>
      Father's Name: _______________________<br>
      G.Fathers Name: ______________________ <br>
      ID.No: _____________________________<br>
      Signature: ___________________________<br>
      Date: ______________________________ </td>
    <td width='281' align='left' valign='top'>      Program: <?php echo $programName ?> <br>
    Year: <?php echo $sectionDetail->getYear(); ?> <br> 
    Semester: <?php echo $sectionDetail->getSemester(); ?> <br />    
    Academic Year: <?php echo $sectionDetail->getAcademicYear(); ?>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<table width='687' border='1' cellspacing='0' style='font-size:11px;'  cellpadding='5px'>
  <tr style='background-color: #000099; color:#FFFFFF'>
    <td width='36' align="center">  No. </td>
    <td width='138' align="center"> Course Code  </td>
    <td width='409' align="center"> Course Title </td>
    <td width='86' align="center">  Credit Hours </td>
  </tr>
    <?php foreach($sectionCourses as $course ): ?>
    <tr>        
        <td align="center"> <?php echo $count.'. '; ?> </td> 
        <td align="center"> <?php echo $course->getCourseNumber(); ?>  </td>
        <td> <?php echo $course->getName(); ?></td>
        <td align="center"> <?php echo $course->getCreditHoure(); 
                        $totalChr += $course->getCreditHoure();
        ?> </td>        
    </tr>    
    <?php 
    $count++;
    endforeach; ?>
    <tr> 
        <td colspan='4' align='right'> Total credit hours: <?php echo $totalChr; ?> </td> 
    </tr>    
</table>

<table width='686'  style='font-size:11px;'>
  <tr>
    <td colspan='3'>&nbsp; </td>
  </tr>
  <tr>
    <td colspan='3'>&nbsp;</td>
  </tr>
 
  <tr>
    <td width='311' align='center' valign='top'>Finance Officer</td>
    <td width='281' align='center' valign='top'>Student Advisor (Center coordinator) </td>
    <td width='281' align='center' valign='top'>Education Team </td>
  </tr>
  <tr>
    <td align='center' valign='top'>&nbsp;</td>
    <td align='center' valign='top'>&nbsp;</td>
    <td align='center' valign='top'>&nbsp;</td>
  </tr>
  <tr>
    <td align='center' valign='top'>________________________________</td>
    <td align='center' valign='top'>________________________________</td>
    <td align='center' valign='top'>________________________________</td>
  </tr>
  <tr>
    <td align='center' valign='top'>Date &amp; Signature </td>
    <td align='center' valign='top'>Date &amp; Signature</td>
    <td align='center' valign='top'>Date &amp; Signature</td>
  </tr>
  <tr>
    <td align='left' valign='top'>&nbsp;</td>
    <td align='right' valign='top'>&nbsp;</td>
    <td align='right' valign='top'>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='3' align='left' valign='top' style='font-size:11px;'>Note:- - This Registration Form is invalid without the stamp of the education team <br>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Tution fee will be calculated based on credit hours. <br>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- One copy should be submitted to education team (department) </td>
  </tr>
</table>
<br /> <br />
<a href="<?php echo url_for('programsection/sectiondetail?id='.$programSectionId) ?>"> << Back to section detail </a> | 
<a href="<?php echo url_for('programsection/generateSemesterSlipPdf?id='.$programSectionId) ?>"> Print to PDF </a>