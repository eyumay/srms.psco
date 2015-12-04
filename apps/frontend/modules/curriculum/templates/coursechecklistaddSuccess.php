<?php use_stylesheets_for_form($courseChecklistForm) ?>
<?php use_javascripts_for_form($courseChecklistForm) ?>
<?php use_stylesheet('ins_up.css') ?>
<h4> Manage Program Curriculum:   <span style="color:red;font-style: italic;"><?php echo $program->getName(); ?> </span> </h4>

<p style="font-size:12px; margin-bottom:3px; margin-top: 20px;">
    <span style="color:red;font-style: italic;"> 
    <?php echo $program->getName();  ?>
    </span>  Modifying Course Checklist / Breakdown </p>
<table width="666" border="1" cellspacing="0" style="font-size:12px">
  <tr>
    <th width="200" scope="col"> 
        Year - <?php echo $year; ?>, Semester <?php echo $semester; ?> Already Defined Courses 
    </th>
  </tr>  
  <?php if($showSemesterCourse): ?>
  
  <tr>
    <td align="center">
        
        <ul>
            <?php foreach($semesterCourses as $sCourse ): ?> 
            <li>  <?php echo $sCourse->getCourse() ?> </li>
            <?php endforeach; ?> 
        </ul>
        
    </td>

  </tr>  
  
  <?php else: ?>
  <tr>
    <td align="center" colspan="2"> No courses yet defined  </td>
  </tr>
  <?php endif; ?>
</table>
 <a href="<?php echo url_for('curriculum/programDetail?programId='.$sCourse->getProgramId() )?>"> << Back to Curriculum </a> 
<form action="<?php echo url_for('curriculum/coursechecklistadd?programId='.$program->getId().'&year='.$year.'&semester='.$semester); ?>" method="post">
    <?php echo $courseChecklistForm; ?> 
    <input type="submit" value="Save"> | 
    <a href="<?php echo url_for('curriculum/programDetail?programId='.$program->getId() )?>" style="font-size: 12px;"> Cancel </a>
</form> 