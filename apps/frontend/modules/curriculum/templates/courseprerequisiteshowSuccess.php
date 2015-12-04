<h4> Manage Program Curriculum:   <span style="color:red;font-style: italic;"><?php echo $program->getName(); ?> </span> </h4>

<p style="font-size:12px; margin-bottom:3px; margin-top: 20px;">
    <span style="color:red;font-style: italic;"> 
    <?php echo $program->getName();  ?>
    </span>  Modifying Course Checklist / Breakdown </p>
<table width="666" border="1" cellspacing="0" style="font-size:12px">
  <tr>
    <th width="200" scope="col"> 
        Courses with Prerequisite list
    </th>
    <th width="200" scope="col"> Actions </th>
  </tr>  
  <?php if($showProgramCourseChecklists): ?>
  
  <tr>
    <td align="center">
        
        <ol>
            <?php foreach($programCourseChecklists as $pcChecklist ): ?>
            <?php if(Doctrine_Core::getTable('RelatedCourses')->checkIfCourseHasPrerequisites($pcChecklist->getCourseId()) ): ?> 
            <li>                 
                <strong> <?php echo $pcChecklist->getCourse() ?> <?php echo link_to('Delete', 'curriculum/courseprerequisitedelete?courseId='.$pcChecklist->getCourseId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?></strong> <br >
                <?php 
                    $prerequisiteCourses = Doctrine_Core::getTable('RelatedCourses')->getPrerequisiteCoursesList($sf_user->getAttribute('departmentId'), $pcChecklist->getCourseId()); 
                ?>
                <?php foreach($prerequisiteCourses as $pCourse ): ?> 
                &nbsp; &nbsp; <?php echo $pCourse->getName(); ?> <br />
                <?php endforeach; ?> 
            </li>
            <?php endif; ?>
            <?php endforeach; ?> 
        </ol>
        
    </td>
    <td valign="top"> 
        <div style="margin:10px; ">
        <a href="<?php echo url_for('curriculum/courseprerequisite?year='.$year.'&semester='.$semester.'&programId='.$programId) ?>">
            >> &nbsp; Define Prerequisites
        </a> <br />          
        </div>
    </td>
  </tr>  
  
  <?php else: ?>
  <tr>
    <td align="center" colspan="2"> No courses yet defined ...  </td>
  </tr>
  <?php endif; ?>
</table>
 <a href="<?php echo url_for('curriculum/programDetail?programId='.$pcChecklist->getProgramId() )?>"> << Back to Curriculum </a> 