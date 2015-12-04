<?php use_stylesheet('instr.css') ?> 
<?php include_partial('sectionfilterform', array('programs'        => $programs, 
					  'years'           => $years,
					  'semesters'       => $semesters, 
					  'academicYears'   => $academicYears, 	
					  'centers'         => $centers													
					)) ?>

<h3 align="center"> Course Offering     </h3> 

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
        <td>  <strong> Class Status  </strong> </td>
        <td>  <strong> Semester Courses Status  </strong> </td>
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
            <?php if($hasCourseOffers): ?>
                Offered 
            <?php else: ?>
                Not Offered
            <?php endif; ?>            
                
        </td>
    </tr>  
    <tr>
        <td colspan="6">             
            <a href="<?php echo url_for('sectioncourseoffering/index') ?>" > << Back To Sections List </a> 
            <?php if(!$hasCourseOffers): ?>
                <a href="<?php echo url_for('sectioncourseoffering/offersemestercourses?sectionId='.$program_section->getId() ) ?>"> 
                    | Offer Semester Courses
                </a>
            <?php else: ?>
                <a href="<?php echo url_for('sectioncourseoffering/deletesemestercourses?sectionId='.$program_section->getId()) ?>" > 
                    | Delete Course Offers
                </a>
            <?php endif; ?>
        </td>

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
    <?php if($hasCourseOffers): ?>
        <?php $count = 1; ?>
        <?php foreach($program_section->getSectionCourseOfferings() as $courseToOffer): ?>
            <tr>
                <td> <?php echo $count; ?>. </td>
               <td>  <?php echo $courseToOffer->getCourse()->getName();  ?>  </td>
               <td> <?php echo $courseToOffer->getCourse()->getCourseNumber(); ?>  </td>
               <td>  <?php echo$courseToOffer->getCourse()->getCreditHoure(); ?> </td>
               <td>                   
                    <a href="<?php echo url_for('sectioncourseoffering/deletesemestercourse?sectionId='.$program_section->getId().'&course='.$courseToOffer->getCourse()->getId()) ?>"> 
                        Delete 
                    </a>                                     
               </td>
           </tr>   
           <?php $count++; ?>
        <?php endforeach; ?>
    <?php else: ?>
    <tr>
        <td colspan="6">
            
            No Courses Offered. <br />              
            
        </td>
    </tr>
    <?php endif; ?>
 </table>    
</div>
</div>

    