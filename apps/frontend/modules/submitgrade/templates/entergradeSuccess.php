<?php use_stylesheet('instr.css') ?> 
<?php include_partial('sectionfilterform', array('programs'        => $programs, 
					  'years'           => $years,
					  'semesters'       => $semesters, 
					  'academicYears'   => $academicYears, 	
					  'centers'         => $centers													
					)) ?>
<h3 align="center"> Grade Submission </h3> 

<div id='dropaddcontainer' style="width:100%;">
    
    
<div id='left' style="width:100%;border:none;" style="font-size: 11px;">

 <h4>  <?php echo $program_section->getProgram()->getEnrollmentType(); ?>  Program At <?php echo $program_section->getCenter()->getName(); ?> Center </h4>
<table width="100%" class="table table-hover table-condensed ">   
  
    <tr>
        <td> <strong> Program </strong> </td>
        <td> <strong>  Center </strong>  </td>
        <td>  <strong> Academic Year  </strong> </td>
        <td>  <strong> Year </strong>  </td>
        <td>  <strong> Semester  </strong> </td>
        <td>  <strong> Status  </strong> </td>
    </tr> 
   
    <tr>
        <td> <?php echo $program_section->getProgram()->getEnrollmentType(); ?> </td>
        <td> <?php echo $program_section->getCenter()->getName(); ?> </td>
        <td> <?php echo $program_section->getAcademicYear(); ?> </td>
        <td> <?php echo $program_section->getYear(); ?> </td>
        <td> <?php echo $program_section->getSemester(); ?> </td>
        <td> 
            <?php echo $program_section->getSectionStatus(); ?>
        </td>

    </tr>  
    <tr>
        <td colspan="6"> <a href="<?php echo url_for('submitgrade/index') ?>" > << Back To Courses List </a> </td>

    </tr>     
</table>
 
<h5> Select grades for each student </h5> 
<table width="100%" class="table table-hover table-condensed ">
<form action="<?php echo url_for('submitgrade/dogradesubmission') ?>" method="post" >
    <?php echo $gradeForm; ?>
    <tr> <td> <input type="submit" value="Save" name="submit" /> </td> <td> &nbsp;  </td> </tr>
</form>

</table> 


<a href="<?php echo url_for('submitgrade/index') ?>"> << Back </a>
</div>
</div>