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

<h6> Active Classes/Sections </h6> 
<p style="font-size:11px; color:#000000;">  
<?php if($program_sections): ?>
    

<?php 
$count=1;
foreach($program_sections as $p_section ): 
    echo $count.'. '. $p_section->getProgram(); ?> <br />
    &nbsp;&nbsp; <?php echo $p_section->getCenter().' Center' ?>  <br />
    &nbsp;&nbsp; <?php echo $p_section->getAcademicYear(); ?> Year <?php echo $p_section->getYear(); ?> Semester <?php echo $p_section->getSemester();?> class. 
    
<?php 
    $count++; 
?> 
    <a href="<?php echo url_for('regrade/sectiondetail?id='.$p_section->getId()) ?>">  <em> - Go to class </em> </a> <br />
<?php endforeach;
?> 
<?php else: ?> 
    No section created yet!!!
<?php endif; ?>

</p>