<?php use_stylesheet('instr.css') ?> 
<?php include_partial('sectionfilterform', array('programs'        => $programs, 
					  'years'           => $years,
					  'semesters'       => $semesters, 
					  'academicYears'   => $academicYears, 	
					  'centers'         => $centers													
					)) ?>
<h3 align="center"> Grade Submission </h3> 

<div id='dropaddcontainer' style="width:100%;">
    
    
<div id='left' style="width:100%;border:none;" style="font-size: 11px;">


 
<h2> Students List to Submit Grade </h2>
<?php if($gradeForm->hasErrors()): ?>
<div style="background-color: red; color: white;"> 
    <h3> The form has errors, you need to select grades for all students  </h3>
</div>
<?php endif;  ?> 
<table width="100%" class="table table-hover table-condensed ">  
<form action="<?php echo url_for('submitgrade/dogradesubmission') ?>" method="post">
    <?php echo $gradeForm; ?>
    <tr> <td> <input type="submit" value="Save" name="submit" /> </td> <td> &nbsp;  </td> </tr>
</form>

</table> 
