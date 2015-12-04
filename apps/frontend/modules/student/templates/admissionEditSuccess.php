<?php use_stylesheet('instr.css') ?> 
<h3 align="center"> Student Admission  </h3> 
<?php include_partial('sectionfilterform', array('programs'        => $programs, 
					  'years'           => $years,
					  'semesters'       => $semesters, 
					  'academicYears'   => $academicYears, 	
					  'centers'         => $centers													
					)) ?>

<div id='dropaddcontainer' style="width:100%;">

    
    
<div id='dropaddcontainer' style="width:100%;">

    
    
<div id='left' style="width:100%;border:none;" style="font-size: 11px;">
        <h4> <?php echo $program_section->getProgram()->getEnrollmentType(); ?>  Program At <?php echo $program_section->getCenter()->getName(); ?> Center Student Admission</h4>
<table width="100%" class="table table-hover table-condensed ">        
    <thead>
    <tr>
        <td> <strong> Program </strong> </td>
        <td> <strong>  Center </strong>  </td>
        <td>  <strong> Academic Year  </strong> </td>
        <td>  <strong> Year </strong>  </td>
        <td>  <strong> Semester  </strong> </td>
        <td>  <strong> Status  </strong> </td>
    </tr> 
    </thead>   

        <td> <?php echo $program_section->getProgram()->getEnrollmentType(); ?> </td>
        <td> <?php echo $program_section->getCenter()->getName();; ?> </td>
        <td> <?php echo $program_section->getAcademicYear(); ?> </td>
        <td> <?php echo $program_section->getYear(); ?> </td>
        <td> <?php echo $program_section->getSemester(); ?> </td>
        <td> 
            <?php echo $program_section->getSectionStatus(); ?>
        </td>

    </tr>  
</table>
 
        
        
        
        <br />
        <h4> Edit Student Admission Information  </h4>
        <form action="<?php echo url_for('student/admissionEdit?sectionId='.$sf_request->getParameter('sectionId').'&studentId='.$sf_request->getParameter('studentId')) ?>" method="post"> 
    <table width="100%" class="table table-hover table-condensed ">  
   
        <?php echo $frontendStudentForm ;   ?>
        <tr><td colspan="2"><input type="submit" value="Save" /> <a href="<?php echo url_for('student/chooseProgramSection') ?>">Cancel </a></td></tr>
    
  
    </table>
     </form>
</div>
</div>

    