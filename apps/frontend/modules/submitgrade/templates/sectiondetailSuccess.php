<?php use_stylesheet('instr.css') ?> 
<?php include_partial('sectionfilterform', array('programs'        => $programs, 
					  'years'           => $years,
					  'semesters'       => $semesters, 
					  'academicYears'   => $academicYears, 	
					  'centers'         => $centers													
					)) ?>

<h3 align="center"> Grade Submission    </h3> 

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
        <td colspan="6"> <a href="<?php echo url_for('submitgrade/index') ?>" > << Back To Sections List </a> </td>

    </tr>     
</table>
    
    
    
    
    
    
    <h4> Semester Courses List </h4>     
 <table width="100%" class="table table-hover table-condensed ">        
    <thead>
    <tr>
        <td> <strong> S.No </strong> </td>
        <td> <strong> Course Name </strong> </td>
        <td> <strong>  Course Code </strong>  </td>
        <td>  <strong> Chr  </strong> </td>
        <td>  <strong> Action  </strong> </td>
    </tr> 
    </thead> 
    <?php if($courseIsDefined): ?>
        <?php $count = 1; ?>
        <?php foreach($program_section->getSectionCourseOfferings() as $courseToOffer): ?>
            <tr>
                <td> <?php echo $count; ?>. </td>
               <td>  <?php echo $courseToOffer->getCourse()->getName();  ?>  </td>
               <td> <?php echo $courseToOffer->getCourse()->getCourseNumber(); ?>  </td>
               <td>  <?php echo$courseToOffer->getCourse()->getCreditHoure(); ?> </td>
               <td>
                   <?php if(!$courseToOffer->getGradeStatus()): ?>
                       <?php if($program_section->courseHasStudents($courseToOffer->getCourseId())): ?>
                            <a href="<?php echo url_for('submitgrade/entergrade?sectionId='.$program_section->getId().'&courseId='.$courseToOffer->getCourse()->getId()) ?>"> 
                                Enter Grade 
                            </a>
                       <?php else: ?>
                            No Students
                       <?php endif; ?>
                   <?php else: ?> 
                            Grade Submitted | 
                            <a href="<?php echo url_for('submitgrade/viewCourseGrade?sectionId='.$program_section->getId().'&courseId='.$courseToOffer->getCourseId() );?>">
                                View Grade 
                            </a>
                   <?php endif; ?>
                   
               </td>

           </tr>   
           <?php $count++; ?>
        <?php endforeach; ?>
    <?php else: ?>
    <tr>
        <td colspan="6">
            No Courses Offered.
        </td>
    </tr>
    <?php endif; ?>
 </table>    
</div>
</div>

    