<?php use_stylesheet('instr.css') ?> 
<?php include_partial('sectionfilterform', array('programs'        => $programs, 
					  'years'           => $years,
					  'semesters'       => $semesters, 
					  'academicYears'   => $academicYears, 	
					  'centers'         => $centers													
					)) ?>

<?php if($showRegistrationForm): ?>
<?php use_stylesheets_for_form($registrationForm) ?>
<?php use_javascripts_for_form($registrationForm) ?>
<?php use_stylesheet('ins_up.css') ?>
<?php endif; ?> 
    
<h3 align="center"> Student Registration    </h3> 

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
    
    
    
    
    
    
    
    
    
<h4>Students Registration</h4>
<?php if(!$sectionIsPromoted): ?>
        <?php if($courseOfferingDefined): ?> 
        <?php if($showRegistrationForm): ?>
        <form action="<?php echo url_for('registration/registration'); ?>" method="post">
        <?php echo $registrationForm;  ?>
        <input type="submit" value="Register"><br/>
        </form> 
        <table  width="100%" class="table table-hover table-condensed ">
          <?php else: ?>
          <tr>
              <td colspan="2"> No Students to Register </td>
          </tr>
          <?php endif; ?>
          <?php else: ?>
          <tr>
            <td> 
                <ul> <li> Course has not been offered for this section, please goto Courses > Course Offering for Section </li> </ul>
            </td>
          </tr>
          <?php endif; ?> 
  <?php else: ?>
        <tr>
          <td> 
              <ul> <li> This Section Is Promoted </li> </ul>
          </td>
        </tr>
  <?php endif; ?> 
</table>

<h5>Manage ADD Enrollments </h5>
<?php if($showAddEnrollments): ?>
<table  width="100%" class="table table-hover table-condensed ">
    <tr>
        <td align="center"> <strong> Student Name </strong> </td>
        <td align="center"> <strong>  Program  </strong> </td>
        <td align="center"> <strong>  Added Course  </strong> </td>
        <td align="center"> <strong>  Action   </strong> </td>
    </tr>
    <?php foreach($addEnrollments->getEnrollmentInfos() as $enrollmentInfo): ?>
    <tr>
        <td> <?php echo $enrollmentInfo->getStudent() ?> </td>
        <td> <?php echo $enrollmentInfo->getProgram() ?> </td>
        <?php foreach($enrollmentInfo->getCoursePools() as $coursePool ): ?>
            <td> <?php echo $coursePool->getCourse(); ?> </td>
        <?php endforeach; ?>
        
        <td> 
            
                       
            <?php if($enrollmentInfo->getSemesterAction() == sfConfig::get('app_registered_semester_action')): ?>            
                ADD Registered
            <?php else: ?>
                <a href="<?php echo url_for('registration/registerwithadd/?enrollmentId='.$enrollmentInfo->getId().'&courseId='.$coursePool->getCourseId()) ?>"> Allow ADD Registration   </a>
            <?php endif; ?>
            
        </td>
    </tr>        
    <?php endforeach; ?> 
    
</table>
<?php else: ?>
<p style="font-size:12px"> No ADD Enrollments Available </p>
<?php endif; ?>    
</div>
</div>



