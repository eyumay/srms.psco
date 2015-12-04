<h4> Manage Program Curriculum:   <span style="color:red;font-style: italic;"><?php echo $program->getName(); ?> </span> </h4>

<p style="font-size:12px; margin-bottom:3px; margin-top: 20px;">
    <span style="color:red;font-style: italic;"> 
    <?php echo $program->getName();  ?>
    </span>  Modifying Course Checklist / Breakdown </p>
<table width="666" border="1" cellspacing="0" style="font-size:12px">
  <tr>
    <th width="200" scope="col"> 
        Year - <?php echo $year; ?>, Semester <?php echo $semester; ?> Courses 
    </th>
    <th width="200" scope="col"> Actions </th>
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
    <td valign="top"> 
        <div style="margin:10px; ">
        >> <a href="<?php echo url_for('curriculum/coursechecklistredefine?year='.$year.'&semester='.$semester.'&programId='.$program->getId()) ?>"> Redefine Semester Courses </a> <br >
        >> <a href="<?php echo url_for('curriculum/coursechecklistadd?year='.$year.'&semester='.$semester.'&programId='.$program->getId()) ?>" > Add Courses </a> <br >
        >> <a href="<?php echo url_for('curriculum/coursechecklistremove?year='.$year.'&semester='.$semester.'&programId='.$program->getId()) ?>" > Remove Courses </a> <br >
        </div>
    </td>
  </tr>  
  
  <?php else: ?>
  <tr>
    <td align="center" colspan="2"> No courses yet defined  </td>
  </tr>
  <?php endif; ?>
</table>
 <a href="<?php echo url_for('curriculum/programDetail?programId='.$sCourse->getProgramId() )?>"> << Back to Curriculum </a> 