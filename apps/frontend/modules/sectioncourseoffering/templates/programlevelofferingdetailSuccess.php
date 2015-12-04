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
    <li> <?php echo link_to('Delete Semester Courses', 'sectioncourseoffering/deletesemestercourses/?sectionId='.$sectionDetail->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?> </li>
    <?php endif; ?>
</ul>
</div>
    
    
<div id='left'>
<h4>Offered Courses </h4>
<table width="463" border="1px" cellspacing="0" cellpadding="0" style="font-size: 12px;">
  <?php if($showCourseOfferings): ?>
  <tr>
    <td align="center"><strong> Course Name </strong></td>
    <td align="center"><strong> Course Code </strong></td>
    <td align="center"><strong> Chrs </strong></td>
  </tr>
  <?php foreach($sectionSemesterCourses as $ssc): ?>
  <tr>
    <td align="center"> <?php echo $ssc->getCourse(); ?> </td>
    <td align="center"> <?php echo $ssc->getCourse()->getCourseNumber(); ?></td>
    <td align="center"> <?php echo $ssc->getCourse()->getCreditHoure(); ?></td>

  </tr>
  <?php endforeach; ?>
  <?php else: ?>
  <tr>
      <td colspan="2"> <ul> <li> None </li> </ul> </td>
  </tr>
  <?php endif; ?>
</table>
</div>








<a href="<?php echo url_for('sectioncourseoffering/index') ?>" class="btn"> << Back </a>