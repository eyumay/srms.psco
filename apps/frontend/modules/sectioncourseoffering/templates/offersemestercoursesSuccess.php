<?php use_stylesheet('instr.css') ?> 
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
        <td colspan="6"> <a href="<?php echo url_for('sectioncourseoffering/index') ?>" > << Back To Sections List </a> </td>

    </tr>     
</table>
<?php if($showSectionCourseOfferingForm): ?>
<?php use_stylesheets_for_form($courseChecklistForm) ?>
<?php use_javascripts_for_form($courseChecklistForm) ?>
<?php endif; ?>
   
<h4>Course Offering </h4>

  <?php if($showSectionCourseOfferingForm): ?>
    <?php if($showForm): ?>
                    <form action="<?php echo url_for('sectioncourseoffering/doSectionCourseOffering'); ?>" method="post">
                    <?php echo $courseChecklistForm; ?>
                    <input type="submit" value="Offer Course for Current Section"><br/>
                    </form>
    <?php else: ?>
        Semester Course is already offered. <br />
        You may delete to define again.  <br /> <br />
    <?php endif; ?>
  <?php else: ?>
<table width="463" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;">
  <tr>
      <td colspan="2"> It seems curriculum course breakdown task not completed! </td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php endif; ?>    

</div>
</div>


