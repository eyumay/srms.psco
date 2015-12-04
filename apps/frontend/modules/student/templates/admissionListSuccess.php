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
    <h4>  <?php echo $program_section->getProgram()->getEnrollmentType(); ?>  Program At <?php echo $program_section->getCenter()->getName(); ?> Center </h4>
<table width="100%" class="table table-hover table-condensed ">   
    <tr>
        <td colspan="6">
            <a href="<?php echo url_for('student/admission?sectionId='.$program_section->getId()) ?>"> + Admit New Student </a>
        </td>
    </tr>    
    <tr>
        <td> <strong> Program </strong> </td>
        <td> <strong>  Center </strong>  </td>
        <td>  <strong> Academic Year  </strong> </td>
        <td>  <strong> Year </strong>  </td>
        <td>  <strong> Semester  </strong> </td>
        <td>  <strong> Status  </strong> </td>
    </tr> 
   

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
        <td colspan="6">
            <a href="<?php echo url_for('student/admission?sectionId='.$program_section->getId()) ?>"> + Admit New Student </a>
        </td>
    </tr>
</table>
    
    
    
    
    
    
    <h4> Admissions List </h4>     
 <table width="100%" class="table table-hover table-condensed ">        
    <thead>
    <tr>
        <td> <strong> ID Number </strong> </td>
        <td> <strong>  Name </strong>  </td>
        <td>  <strong> Fathers Name  </strong> </td>
        <td>  <strong> GrandFathers Name </strong>  </td>
        <td>  <strong>  Status  </strong> </td>
        <td>  <strong> Action  </strong> </td>
    </tr> 
    </thead> 
    <?php if(!is_null($admission_enrollments)): ?>
        <?php foreach ($admission_enrollments as $enrollment): ?>
            <tr>
               <td>  <?php echo $enrollment->getStudent()->getStudentUid();  ?>  </td>
               <td> <?php echo $enrollment->getStudent()->getName(); ?>  </td>
               <td>  <?php echo $enrollment->getStudent()->getFathersName(); ?> </td>
               <td> <?php echo $enrollment->getStudent()->getGrandfathersName(); ?> </td>
               <td>  <?php echo $enrollment->getEnrollmentStatus(); ?> </td>
               <td>
                    <a href="<?php echo url_for('student/admissionEdit?studentId='.$enrollment->getStudentId().'&sectionId='.$program_section->getId() ); ?>"> Edit </a>    | 
                    <?php echo link_to('Delete', 'student/admissionDelete?studentId='.$enrollment->getStudentId().'&sectionId='.$program_section->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
               </td>   
           </tr>   
        <?php endforeach; ?>
    <?php else: ?>
    <tr>
        <td colspan="6">
            No Admitted Students
        </td>
    </tr>
    <?php endif; ?>
 </table>    
</div>
</div>

    