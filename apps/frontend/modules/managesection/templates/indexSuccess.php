<?php use_stylesheet('instr.css') ?>

<h4> Manage Program Sections </h4> 
<?php use_stylesheet('instr.css') ?> 
<?php include_partial('sectionfilterform', array('programs'        => $programs, 
					  'years'           => $years,
					  'semesters'       => $semesters, 
					  'academicYears'   => $academicYears, 	
					  'centers'         => $centers													
					)) ?>

<table>
  <thead>
    <tr>

    </tr>
  </thead>
  <tbody>
    <tr>

    </tr>
  </tbody>
</table>

<div id='dropaddcontainer' style="width:100%;">

    
    
<div id='left' style="width:100%;border:none;" style="font-size: 11px;">
<table width="100%" class="table table-hover table-condensed ">        
    <thead>
    <tr>
        <td> <strong> <a href="<?php echo url_for('managesection/index?sortBy=program') ?>">Program </a></strong> </td>
        <td> <strong> <a href="<?php echo url_for('managesection/index?sortBy=center') ?>"> Center </a></strong>  </td>
        <td>  <strong> <a href="<?php echo url_for('managesection/index?sortBy=academicYear') ?>"> Academic Year  </a></strong> </td>
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
        <td> <a href="<?php echo url_for('managesection/delete?programSectionId='.$ps->getId()) ?>"> Delete </a> | 
            <a href="<?php echo url_for('managesection/removeEnrollments?programSectionId='.$ps->getId()) ?>"> Remove Enrollments </a> |
            <a href="<?php echo url_for('managesection/edit?programSectionId='.$ps->getId()) ?>"> Edit </a> 
            <?php if($ps->showToggleStatus()): ?>
               |  <a href="<?php echo url_for('managesection/toggleStatus?programSectionId='.$ps->getId()) ?>"> Toggle Status </a> 
            <?php endif; ?>
        </td>
    </tr>    
<?php endforeach; ?>
</table>
</div>
</div>