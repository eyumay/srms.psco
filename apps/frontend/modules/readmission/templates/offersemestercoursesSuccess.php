<?php if($showSectionCourseOfferingForm): ?>
<?php use_stylesheets_for_form($courseChecklistForm) ?>
<?php use_javascripts_for_form($courseChecklistForm) ?>
<?php endif; ?>
<h4> Manage Section Semester Course Offerings </h4> 

<div style="font-size:12px;"> 
<!-- Section Detail Start -->
<table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="800px">
    
    <tr style="background-color: #000099; color: white;">
        <td align="center"> Class Information </td>
    </tr>

    <tr>
        <td valign="top">
            Program: <span style="color:red"> <i> <?php echo $sectionDetail->getProgram(); ?> </i> </span> 
            Center: <span style="color:red"> <i> <?php echo $sectionDetail->getCenter(); ?> </i> </span>  
            Academic Year: <span style="color:red"> <i> <?php echo $sectionDetail->getAcademicYear(); ?></i> </span>
            Year: <span style="color:red"> <i> <?php echo $sectionDetail->getYear(); ?> </i> </span> 
            Semester: <span style="color:red"> <i> <?php echo $sectionDetail->getSemester(); ?> </i> </span> 
        </td>
    </tr>
</table>
<!-- Section Detail End -->

<div id='dropaddcontainer'>
<div id='right'>
  <h4>Actions</h4>
  <ul>
    <li> <a href="<?php echo url_for('sectioncourseoffering/offersemestercourses/?sectionId='.$sectionDetail->getId()) ?>"> Offer Semester Courses </a> </li>
    <?php if($sf_user->getAttribute('credential') == 'hod'): ?> 
    <li> <?php echo link_to('Delete Semester Courses', 'deletesemestercourses/offersemestercourses/?sectionId='.$sectionDetail->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?> </li>
    <?php endif; ?>
</ul>
</div>
    
    
<div id='left'>
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








<a href="<?php echo url_for('sectioncourseoffering/index') ?>" class="btn"> << Back </a>