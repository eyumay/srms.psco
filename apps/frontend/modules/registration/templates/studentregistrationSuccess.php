<?php use_stylesheet('instr.css') ?> 
<?php include_partial('sectionfilterform', array('programs'        => $programs, 
					  'years'           => $years,
					  'semesters'       => $semesters, 
					  'academicYears'   => $academicYears, 	
					  'centers'         => $centers													
					)) ?>
    
<h3 align="center"> Student Registration    </h3> 

<div id='dropaddcontainer' style="width:100%;">

<div id='left' style="width:100%;border:none;" style="font-size: 11px;">    
    

    <h4>  <?php echo $program_section->getProgram()->getEnrollmentType(); ?>  Program At <?php echo $program_section->getCenter()->getName(); ?> Center </h4>
<table width="100%" class="table table-hover table-condensed ">   
    <?php if(!$program_section->hasCourseOffers()): ?>
    <tr>        
        <td colspan="7">
            <span style="color: red;"> Please Offer Semester Courses To This Section To Examine Student Prerequisite Status. </span>
        </td>        
    </tr>
    <?php endif; ?>
    <tr>
        <td> <strong> Program </strong> </td>
        <td> <strong>  Center </strong>  </td>
        <td>  <strong> Academic Year  </strong> </td>
        <td>  <strong> Year </strong>  </td>
        <td>  <strong> Semester  </strong> </td>
        <td>  <strong> Status  </strong> </td>
        <td>  <strong> Semester Course  </strong> </td>
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
        <td> 
            <?php if($program_section->hasCourseOffers()): ?>
                <span style="color: green;"> Offered </span>
            <?php else: ?>
                <span style="color: red;"> Not Offered </span>
            <?php endif; ?>
        </td>
    </tr>  
    <tr>
        <td colspan="7"> <a href="<?php echo url_for('registration/sectiondetail?id='.$program_section->getId() ) ?>" > << Back  </a> </td>

    </tr>     
</table>
    
    
    
    
    
    
    
    
<!-- #########  STUDENT IS REGISTERED  -->    
<h4>Student Registration Info.</h4>
<table width="100%" class="table table-hover table-condensed ">   
  
    <tr>
        <td> <strong> Full Name </strong> </td> 
        <td> <?php echo $student->getName().' '.$student->getFathersName().' '.$student->getGrandfathersName(); ?> </td>
    </tr>
    <tr>
        <td> <strong> ID </strong> </td>
        <td> <?php echo $student->getStudentUid();  ?> </td>        
    </tr>
    <tr>
        <td> <strong> Last Status </strong> </td>
        <td> <?php echo $studentEnrollment->getEnrollmentStatus();  ?> </td>        
    </tr>    
    
    
    <?php if($isRegistered): ?>
        <tr>
        <td> <strong> Courses </strong> </td>
        <td> 
            <table>
                <tr>
                    <td> <strong> Course Name </strong> </td><td> <strong> Status </strong> </td>
                </tr>
                <?php foreach($studentEnrollment->getRegistrations() as $registration ): ?>
                <?php foreach($registration->getStudentCourseGrades() as $scg): ?>
                <tr>
                    <td> <?php echo $scg->getCourse()->getName(); ?> </td><td> <?php echo $scg->getCourseStatus(); ?> </td>
                </tr>              
                <?php endforeach; ?>
                <?php endforeach; ?>
            </table>
        </td>        
    </tr>   

    <?php else: ?>
        <?php if($hasDrops): ?>
            <tr>
                <td> Courses To Drop  </td>
               <td>
                   <ul>
                       <?php foreach($droppableCourses as $courseId=>$courseName): ?>
                       <span style="color:red; "><li>  <?php echo $courseName;  ?>   </li></span>
                       <?php endforeach; ?>
                   </ul>
               </td>
           </tr> 
            <tr>
                <td> Courses To Register  </td>
               <td>
                   <ul>
                       <?php foreach($registrationCourses as $courseId=>$courseName): ?>
                       <li> <span style="color:green; "> <?php echo $courseName;  ?> </span>  </li>
                       <?php endforeach; ?>
                   </ul>
               </td>
           </tr>           
            <tr>
               <td>

                   <a href="<?php echo url_for('registration/registerwithdrop?sectionId='.$program_section->getId().'&studentId='.$student->getId() ) ?>" class="btn btn-primary">Register With Drop </a>
                   <a href="<?php echo url_for('registration/sectiondetail?sectionId='.$program_section->getId() ) ?>"> Cancel </a> 
               </td>
               <td></td>
           </tr>       
        <?php else: ?>
            <tr>
                <td> Courses To Drop  </td>
               <td>
                   <ul>
                       <li> None  </li>
                   </ul>
               </td>
           </tr> 
            <tr>
                <td> Courses To Register  </td>
               <td>
                   <ul>
                       <?php foreach($registrationCourses as $courseId=>$courseName): ?>
                       <li> <span style="color:green; "> <?php echo $courseName;  ?> </span>  </li>
                       <?php endforeach; ?>
                   </ul>
               </td>
           </tr>            
            <tr>           
            <tr>
               <td>
                   <a href="<?php echo url_for('registration/register?sectionId='.$program_section->getId().'&studentId='.$student->getId() ) ?>" class="btn btn-primary"> Register </a>
                   <a href="<?php echo url_for('registration/sectiondetail?sectionId='.$program_section->getId() ) ?>"> Cancel </a> 
               </td>
               <td></td>
           </tr>           
        <?php endif; ?>
        
    <?php endif; ?>
    
    
    
    
    
</table>     
</div>
</div>



