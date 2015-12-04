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
<div> 
    <h6> Your selection: </h6> 
    Program: <b> <?php echo Doctrine_Core::getTable('Program')->getProgramById($sf_user->getAttribute('selectedProgramId'))->getName(). ' Program'; ?>  </b> <br />    
    Center:  <b> <?php echo Doctrine_Core::getTable('Center')->getCenterById($sf_user->getAttribute('selectedCenterId'))->getName(); ?>  </b>  <br />    
    Academic Year:  <b> <?php echo $sf_user->getAttribute('selectedAcademicYear'); ?> </b> , 
    Year:  <b> <?php echo $sf_user->getAttribute('selectedYear'); ?> </b> , 
    Semester:  <b> <?php echo $sf_user->getAttribute('selectedSemester'); ?>  </b> 

</div>

<h6> Search result: Active Classes/Sections </h6> 
<p style="font-size:11px; color:#000000;">  
<?php if($oneSectionDetail): ?>
    

<?php 
$count=1;
echo $count.'. '. $oneSectionDetail->getProgram(). ' class at '.$oneSectionDetail->getCenter(); 
$count++; 
?> 
    <a href="<?php echo url_for('sectioncourseoffering/sectiondetail?id='.$oneSectionDetail->getId()) ?>">  <em> - Go to class </em> </a> <br />
<?php else: ?> 
    No section created yet!!!
<?php endif; ?>

</p>