Passed Parameters <br />
enrollmentId: <?php echo $enrollmentId; ?>  <br />
sectionId: <?php echo $sectionId; ?>  <br />
studentId: <?php echo $studentId; ?>  <br />

<br />
Config app.yml files: <br />
normal registration :  <?php echo $normal; ?> <br />
drop registration : <?php echo $drop; ?> <br />

<br />
<!--
Checking registration types <br />
Normal Registration : <?php //echo $normalReg; ?>  <br />
add Registration : <?php //echo $addReg; ?>  <br />
drop Registration : <?php //echo $dropReg; ?>  <br />
exemption Registration : <?php //echo $exemptionReg; ?>  <br />
reexam Registration : <?php //echo $reexamReg; ?>  <br />
makeup Registration : <?php //echo $makeupReg; ?>  <br />
grade complain Registration : <?php //echo $gradeComplainReg; ?>  <br />
null Registration : <?php //echo $nullReg; ?>  <br />
-->

doRegistration() returns <br />
<?php print_r($semesterCourseIdsArray); ?>