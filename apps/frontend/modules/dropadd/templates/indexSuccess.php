<?php use_stylesheet('instr.css') ?> 
<?php include_partial('sectionfilterform', array('programs'        => $programs, 
					  'years'           => $years,
					  'semesters'       => $semesters, 
					  'academicYears'   => $academicYears, 	
					  'centers'         => $centers													
					)) ?>

<div id='dropaddcontainer' style="width:100%;">
           
    
<div id='left' style="width:100%;border:none;" style="font-size: 11px;">
    <h3 align="center"> Student ADD and DROP  </h3>
<table width="100%" class="table table-hover table-condensed ">        
    <thead>
    <tr>
        <td> <strong> <a href="<?php echo url_for('dropadd/index?sortBy=program') ?>">Program </a></strong> </td>
        <td> <strong> <a href="<?php echo url_for('dropadd/index?sortBy=center') ?>"> Center </a></strong>  </td>
        <td>  <strong> <a href="<?php echo url_for('dropadd/index?sortBy=academicYear') ?>"> Academic Year  </a></strong> </td>
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
            <a href="<?php echo url_for('dropadd/sectiondetail?id='.$ps->getId()) ?>"> Go to class </a> 
        </td>
    </tr>    
<?php endforeach; ?>
</table>
</div>
</div>