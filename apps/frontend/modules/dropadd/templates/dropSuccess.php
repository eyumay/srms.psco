    <?php use_stylesheets_for_form($studentCourseDropForm) ?>
    <?php use_javascripts_for_form($studentCourseDropForm) ?>
    <?php use_stylesheet('ins_up.css') ?>
<h4> Add and Drop </h4> 
 
<div style="font-size:12px;"> 
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
        <form action="<?php echo url_for('dropadd/drop?id='.$program_section->getId() ); ?>" method="post">
        <?php echo $studentCourseDropForm; ?>
        <input type="submit" value="Drop course"><br/>
        </form>
  
</div>


