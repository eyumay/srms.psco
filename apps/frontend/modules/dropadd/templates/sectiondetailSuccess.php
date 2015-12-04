<?php use_stylesheet('instr.css') ?> 
<?php include_partial('sectionfilterform', array('programs'        => $programs, 
					  'years'           => $years,
					  'semesters'       => $semesters, 
					  'academicYears'   => $academicYears, 	
					  'centers'         => $centers													
					)) ?>
<h3 align="center"> Student Registration    </h3> 

<div id='dropaddcontainer' style="width:100%;">

<div id='left' style="width:100%; border:none;" style="font-size: 11px;">    
    

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
        <td colspan="6"> 
            <a href="<?php echo url_for('dropadd/index') ?>" >     << Sections List </a>  | 
            <a href="<?php echo url_for('dropadd/add?id='.$program_section->getId() ) ?>" > + ADD </a> | 
            <a href="<?php echo url_for('dropadd/drop?id='.$program_section->getId() ) ?>" > - DROP   </a>
        </td>

    </tr>     
</table>
    
 <table width="100%" class="table table-hover table-condensed ">   
  
    <tr>
        <td> <strong> SNo. </strong> </td>
        <td> <strong>  Student Name </strong>  </td>
        <td>  <strong> ID  </strong> </td>
        <td>  <strong> Semester Status  </strong>  </td>
        <td>  <strong> Action   </strong> </td>
    </tr> 
    <?php $count = 1; ?>
    <?php foreach($program_section->getEnrollmentInfos() as $ei ): ?>  
    <tr>
        <td> 
            <?php echo $count; ?>.
        </td>
        <td>  
            <?php echo 
                $ei->getStudent()->getName().' '.$ei->getStudent()->getFathersName().' '.$ei->getStudent()->getGrandfathersName();
            ?>            
        </td>
        <td> <?php echo $ei->getStudent()->getStudentUid(); ?> </td>
        <td> <?php echo $ei->getEnrollmentStatus(); ?>  </td>
        <td> 
            <a href="<?php echo url_for('registration/studentdetail?sectionId='.$program_section->getId().'&studentId='.$ei->getStudentId()); ?>">   
                View Detail  
            </a> |
            <a href="<?php echo url_for('dropadd/studentadd?studentId='.$ei->getId().'&sectionId='.$program_section->getId() ) ?>" > + ADD   </a> |
            <a href="<?php echo url_for('dropadd/studentdrop?studentId='.$ei->getStudentId().'&sectionId='.$program_section->getId() ) ?>" > - DROP   </a>
        </td>
    <?php $count++; ?>
    </tr> 
    <?php endforeach; ?>
         
</table>  
    
</div>
</div>