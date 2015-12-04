<?php use_stylesheet('instr.css') ?> 
<h3 align="center"> Student Admission  </h3> 
<p style="font-size: 12px;"> Choose Available Programs To Register. </p>
<?php include_partial('sectionfilterform', array('programs'        => $programs, 
					  'years'           => $years,
					  'semesters'       => $semesters, 
					  'academicYears'   => $academicYears, 	
					  'centers'         => $centers													
					)) ?>

<div id='dropaddcontainer' style="width:100%;">

    
    
<div id='dropaddcontainer' style="width:100%;">

    
    
<div id='left' style="width:100%;border:none;" style="font-size: 11px;">
<table width="100%" class="table table-hover table-condensed ">        
    <thead>
    <tr>
        <td> <strong> <a href="<?php echo url_for('programsection/index?sortBy=program') ?>">Program </a></strong> </td>
        <td> <strong> <a href="<?php echo url_for('programsection/index?sortBy=center') ?>"> Center </a></strong>  </td>
        <td>  <strong> <a href="<?php echo url_for('programsection/index?sortBy=academicYear') ?>"> Academic Year  </a></strong> </td>
        <td>  <strong> Year </strong>  </td>
        <td>  <strong> Semester  </strong> </td>
        <td>  <strong> Status  </strong> </td>
        <td>  <strong> Actions  </strong> </td>
    </tr> 
    </thead>
<?php foreach($program_sections as $ps): ?>    
    
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
            <?php if($ps->checkToAdmit()): ?>
                <a href="<?php echo url_for('student/admissionList?sectionId='.$ps->getId()) ?>"> Go To Student Admission </a> 
            <?php elseif($ps->checkIfGradeIsSubmitted() ):  ?>
                <?php if($ps->checkIfGradeIsSubmittedForAllCourses()): ?>
                    None: Grade Submitted 
                <?php else: ?>
                    None: At Grade Submission
                <?php endif; ?>
            <?php else: ?>
                None 
            <?php endif; ?>
        </td>
    </tr>    
    
<?php endforeach; ?>
</table>
</div>
</div>
