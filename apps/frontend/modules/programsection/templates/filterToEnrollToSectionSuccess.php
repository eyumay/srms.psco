<?php use_stylesheet('instr.css') ?> 
<h4> New Student Enrollment </h4> 
<?php include_partial('filterform', array('programs'        => $programs, 
					  'years'           => $years,
					  'semesters'       => $semesters, 
					  'academicYears'   => $academicYears, 	
					  'centers'         => $centers													
					)) ?>

<div id='dropaddcontainer' style="width:100%;">

    
    
<div id='dropaddcontainer' style="width:100%;">

    
    
<div id='left' style="width:100%;border:none;" style="font-size: 11px;">

<?php if(!$showStudentsToEnroll): ?>    
<table width="100%" class="table table-hover table-condensed ">        
    <thead>
    <tr>
        <td> <strong> <a href="<?php echo url_for('programsection/filterToEnrollToSection?sortBy=program') ?>">Program </a></strong> </td>
        <td> <strong> <a href="<?php echo url_for('programsection/filterToEnrollToSection?sortBy=center') ?>"> Center </a></strong>  </td>
        <td>  <strong> <a href="<?php echo url_for('programsection/filterToEnrollToSection?sortBy=academicYear') ?>"> Academic Year  </a></strong> </td>
        <td>  <strong> Year </strong>  </td>
        <td>  <strong> Semester  </strong> </td>
        <td>  <strong> Status  </strong> </td>
        <td>  <strong> Actions  </strong> </td>
    </tr> 
    </thead>
<?php foreach($program_sections as $ps): ?>  
    <?php if($ps->checkToEnroll() ): ?>
    <tr <?php if(!$ps->isActivated()): ?> 
        bgcolor="#FFB9B9"
        <?php endif; ?>
        >
        <td> <?php echo $ps->getProgram()->getEnrollmentType(); ?> </td>
        <td> <?php echo $ps->getCenter()->getName();; ?> </td>
        <td> <?php echo $ps->getAcademicYear(); ?> </td>
        <td> <?php echo $ps->getYear(); ?> </td>
        <td> <?php echo $ps->getSemester(); ?> </td>
        <td> 
            <?php echo $ps->getSectionStatus(); ?>
        </td>
        <td> 
            <a href="<?php echo url_for('programsection/viewStudentsToEnroll?sectionId='.$ps->getId()) ?>"> View Students To Enroll </a> 
        </td>
    </tr>  
    <?php endif; ?>
<?php endforeach; ?>
</table>
<?php else: ?>
 <table width="100%" class="table table-hover table-condensed ">        
    <thead>
    <tr>
        <td> <strong> Program </strong> </td>
        <td> <strong>  Center </strong>  </td>
        <td>  <strong>  Academic Year  </strong> </td>
        <td>  <strong> Year </strong>  </td>
        <td>  <strong> Semester  </strong> </td>
        <td>  <strong> Status  </strong> </td>
    </tr> 
    </thead> 
    <tr>
        <td>  <?php echo $sectionDetail->getProgram()->getEnrollmentType(); ?>  </td>
        <td> <?php echo $sectionDetail->getCenter(); ?>  </td>
        <td>  <?php echo $sectionDetail->getAcademicYear(); ?> </td>
        <td> <?php echo $sectionDetail->getYear(); ?> </td>
        <td>  <?php echo $sectionDetail->getSemester(); ?> </td>
        <td>  <?php echo $sectionDetail->getSectionStatus(); ?> </td>   
    </tr>
 </table>
    
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
                   <?php if($enrollment->isEnrolled()): ?>
                        <a href="<?php echo url_for('programsection/unenroll?sectionId='.$sectionDetail->getId().'&enrollmentId='.$enrollment->getId().'&showStudentsToEnroll=YES'); ?>"> Unenroll </a>   
                   <?php elseif($enrollment->isAdmitted()): ?>
                        <a href="<?php echo url_for('programsection/enroll?sectionId='.$sectionDetail->getId().'&enrollmentId='.$enrollment->getId().'&showStudentsToEnroll=YES' ) ?>"> Enroll </a>   
                   <?php else: ?>
                        None
                   <?php endif; ?>
               </td>   
           </tr>   
        <?php endforeach; ?>
    <?php else: ?>
    <tr>
        <td colspan="6">
            No Admission Enrollments
        </td>
    </tr>
    <?php endif; ?>
 </table>
<?php endif; ?>    
</div>
</div>