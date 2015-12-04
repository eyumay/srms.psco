<?php use_stylesheet('instr.css') ?> 
<?php include_partial('sectionfilterform', array('programs'        => $programs, 
					  'years'           => $years,
					  'semesters'       => $semesters, 
					  'academicYears'   => $academicYears, 	
					  'centers'         => $centers													
					)) ?>

<h3 align="center"> Grade Submission    </h3> 
<div id='dropaddcontainer' style="width:100%;">

    
    
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
        <td colspan="6"> <a href="<?php echo url_for('submitgrade/sectiondetail?sectionId='.$program_section->getId()) ?>" > << Back To Sections List </a> </td>

    </tr>     
</table>
    
    
    
    
    
    
    <h4> Course: <em>  <?php echo $course->getName(); ?>  - <?php echo $course->getCourseNumber(); ?> </em> </h4>     
 <table width="100%" class="table table-hover table-condensed ">        
    <thead>
    <tr>
        <td> <strong> S.No </strong> </td>
        <td> <strong> Full Name </strong> </td>
        <td> <strong>  ID No. </strong>  </td>
        <td>  <strong> Letter Grade  </strong> </td>
        <td> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </td> 
    </tr> 
    </thead> 
        <?php $count = 1; ?>
        <?php foreach($program_section->getEnrollmentInfos() as $ei): ?>
            <?php foreach($ei->getRegistrations() as $rg): ?>
                <?php foreach($rg->getStudentCourseGrades() as $scg): ?>
                    <?php if($scg->getCourseId() == $course->getId()): ?>
                        <tr>
                            <td> <?php echo $count; ?>. </td>
                           <td>  
                               <?php echo $ei->getStudent();  ?>  
                           </td>
                           <td> <?php echo $ei->getStudent()->getStudentUid(); ?>  </td>
                           <td>  <?php echo $scg->getGrade(); ?> </td>
                           
                       </tr>
                       <?php $count++; ?>
                   <?php endif; ?>
                <?php endforeach; ?>   
           <?php endforeach; ?>                
        <?php endforeach; ?>
 </table>    
</div>
</div>

    