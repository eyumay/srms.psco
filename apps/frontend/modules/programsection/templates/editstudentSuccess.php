<?php 

$count                              = 1; 

?>

<h3 align="center"> Manage Section Students </h3> 

<!-- Section Detail Start -->
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
        <td colspan="6"> <a href="<?php echo url_for('programsection/index') ?>" > << Back To Sections List </a> </td>

    </tr>     
</table>
<!-- Section Detail End -->
        <h4> Edit Student Profile Information  </h4>
        <form action="<?php echo url_for('programsection/editstudent?sectionId='.$sf_request->getParameter('sectionId').'&studentId='.$sf_request->getParameter('studentId')) ?>" method="post"> 
    <table width="100%" class="table table-hover table-condensed ">  
   
        <?php echo $frontendStudentForm ;   ?>
        <tr><td colspan="2"><input type="submit" value="Save" /> <a href="<?php echo url_for('programsection/sectiondetail?id='.$sf_request->getParameter('sectionId')) ?>">Cancel </a></td></tr>
    
  
    </table>
     </form>
</div>