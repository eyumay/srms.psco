<?php if($showSectionCourseOfferingForm): ?>
<?php use_stylesheets_for_form($courseChecklistForm) ?>
<?php use_javascripts_for_form($courseChecklistForm) ?>
<?php endif; ?>
<h4> Manage Section Semester Course Offerings </h4> 
 
<!-- Section Detail Start -->
<table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="800px">
    
    <tr style="background-color: #000099; color: white;">
        <td align="center"> Program Information </td>
    </tr>

    <tr>
        <td valign="top">
            Program: <span style="color:red"> <i> <?php echo $program->getname(); ?> </i> </span> 
            Center: <span style="color:red"> <i> <?php echo $program->getEnrollmentType(); ?> </i> </span>  
            Academic Year: <span style="color:red"> <i> <?php echo $program->getProgramType(); ?></i> </span>
        </td>
    </tr>
</table>
<!-- Section Detail End -->

<div id='dropaddcontainer'>
<div id='right'>
  <h4>Actions</h4>
  <ul>
    <li> None </li>
</ul>
</div>
    
    
<div id='left'>
<h4>Course Offering at Program Level </h4>
** With this action, you are offering courses for all Program Sections

  <?php if($showSectionCourseOfferingForm): ?>
                    <form action="<?php echo url_for('sectioncourseoffering/programlevelofferingnew/?programId='.$program->getId().'&year='.$year.'&semester='.$semester); ?>" method="post">
                    <?php echo $courseChecklistForm; ?>
                    <input type="submit" value="Offer Program Level Course"><br/>
                    </form>
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





<a href="<?php echo url_for('sectioncourseoffering/index') ?>" class="btn"> << Back </a>