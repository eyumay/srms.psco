<h4> Manage Program Curriculum:   <span style="color:red;font-style: italic;"><?php echo $program->getDepartment().': '.$program->getName(). ' Program'; ?> </span> </h4>
<table width="666" border="1" cellspacing="0" style="font-size:12px">
  <tr>
    <th colspan="2" scope="col">Program Detail </th>
  </tr>
  <tr>
    <td>Program Name: <?php echo $program->getName(); ?></td>
    <td>Credit hours: Min=<?php echo $program->getTotalMinChr() ?>, Max=<?php echo $program->getTotalMaxChr() ?> </td>
  </tr>
  <tr>
    <td>Department: <?php echo $program->getDepartment(); ?> </td>
    <td>Number of Years: Min=<?php echo $program->getNumberOfYears() ?>, Max=<?php echo $program->getMaxNumberOfYears() ?> </td>
  </tr>
  <tr>
    <td>Program Type: <?php echo $program->getProgramType() ?> </td>
    <td>Status: <?php echo $program->getStatus() ?></td>
  </tr>
  <tr>
    <td>Enrollment Type: <?php echo $program->getEnrollmentType() ?> </td>
    <td>Approval Date: <?php echo $program->getApprovalDate() ?> </td>
  </tr>
  <tr>
    <td>Number of Semesters: <?php echo $program->getNumberOfSemesters() ?> </td>
    <td>&nbsp;</td>
  </tr>
</table>
<span style="font-size:12px; margin-bottom:3px;">
    <a href="<?php echo url_for('program/edit?id='.$program->getId()); ?>">Edit</a> | 
    Delete | 
    <a href="<?php echo url_for('curriculum/index')?>"> Cancel </a>  </span>







<br />
<p style="font-size:12px; margin-bottom:3px; margin-top: 20px;"><span style="color:red;font-style: italic;"><?php echo $program->getName(); ?> </span>  Program Checklists </p>
<table width="666" border="1" cellspacing="0" style="font-size:12px">
  <tr>
    <th width="31" scope="col">S.No.</th>
    <th width="47" scope="col">Year</th>
    <th width="72" scope="col">Semester</th>
    <th width="190" scope="col">Semester Type </th>
    <th width="304" scope="col">Actions</th>
  </tr>  
  <?php $count=1; ?> 
  <?php if($showChecklist): ?>
  <?php foreach($pChecklistBreakdowns as $pcb ): ?>
  <tr>
    <td align="center"> <?php echo $count.'.'; ?> </td>
    <td align="center"> <?php echo $pcb->getYear(); ?> </td>
    <td align="center"> <?php echo $pcb->getSemester(); ?> </td>
    <td align="center"> <?php echo $pcb->getSemesterType(); ?> </td>
    <td align="center">        
        <a href="<?php echo url_for('programchecklistbreakdown/delete?id='.$pcb->getId()) ?>">Delete</a> </td>
  </tr>
  <?php $count++; ?> 
  <?php endforeach; ?>
  <?php else: ?>
  <tr>
    <td align="center" colspan="5"> No checklist breakdown created yet!  </td>
  </tr>
  <?php endif; ?>
</table>
<a href="<?php echo url_for('curriculum/programchecklistbreakdownnew?programId='.$program->getId()) ?>"> Add New Checklist Breakdown</a> |
 <a href="<?php echo url_for('curriculum/index')?>"> Cancel </a> 
 

 

 <!-- PROMOTION RULE --> 
<br />
<p style="font-size:12px; margin-bottom:3px; margin-top: 20px;"><span style="color:red;font-style: italic;"><?php echo $program->getName(); ?> </span>  Program PROMOTION RULES </p>
<table width="666" border="1" cellspacing="0" style="font-size:12px">
  <tr>
    <th width="200" scope="col"> From </th>
    <th width="200" scope="col"> To </th>
    <th width="266" scope="col"> Action  </th>
  </tr>  
  <?php if($showPromotionSetting): ?>
  <?php foreach($promotionSettings as $pSetting ): ?>
  <tr>
    <td align="center"> 
        Year <?php echo $pSetting->getCurrentYear(); ?>
        Semester <?php echo $pSetting->getCurrentSemester(); ?>
    </td>
    <td align="center"> 
        Year <?php echo $pSetting->getToYear(); ?>
        Semester <?php echo $pSetting->getToSemester(); ?>
    </td>
    <td align="center"> 
        <a href="<?php echo url_for('promotionsetting/delete?id='.$pSetting->getId()) ?>">Delete</a> 
    </td>
  </tr>  
  <?php endforeach; ?>
  <?php else: ?>
  <tr>
    <td align="center" colspan="8"> No promotion setting created yet!  </td>
  </tr>
  <?php endif; ?>
</table>
<a href="<?php echo url_for('curriculum/promotionsettingnew?programId='.$program->getId()) ?>"> Add New Promotion Rule</a> |
 <a href="<?php echo url_for('curriculum/index')?>"> Cancel </a> 
 
 
 
 
 
<!-- COURSE BREAKDOWN ................................................................... -->
<p style="font-size:12px; margin-bottom:3px; margin-top: 20px;"><span style="color:red;font-style: italic;"><?php echo $program->getName(); ?> </span>  Program Curriculum Course Breakdowns  </p>
<table border="0" cellspacing="0" style="font-size:12px">
    <tr>
        <th> Course Breakdowns </th> <th align="left"> Actions  </th>
    </tr>
    <tr> 
    <td> 
    <table width="300" border="0" cellspacing="0" style="font-size:12px">
      <?php if($showCourseChecklist): ?> 
      <?php foreach($courseBreakdowns as $cbd): ?>
      <tr>
        <td>
            <strong> Year <?php echo $cbd->getYear();  ?>, Semester <?php echo $cbd->getSemester();  ?> courses: </strong>  <br />
            <?php foreach(Doctrine_Core::getTable('CourseChecklist')->getSemesterCourseChecklists($cbd->getProgramId(),$cbd->getYear(),$cbd->getSemester() )as $cBreakdowns):  ?>  
            &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $cBreakdowns->getCourse(); ?> <br />
            <?php endforeach; ?> 
        </td>
      </tr>
      <?php endforeach; ?> 
      <?php else: ?>
      <tr>
        <td> No course breakdown defined for this program </td>
      </tr>
      <?php endif; ?> 
    </table>
    </td>
    <td valign="top"> 
        <a href="<?php echo url_for('curriculum/coursechecklistnew?programId='.$program->getId()) ?>">
            >> &nbsp; Add New Course Breakdown
        </a> <br />
        <?php if($showCourseChecklist): ?> 
        <a href="<?php echo url_for('curriculum/courseprerequisiteshow?year='.$cbd->getYear().'&semester='.$cbd->getSemester().'&programId='.$cbd->getProgramId()) ?>">
            >> &nbsp; Manage Prerequisites
        </a> <br />            
        <a href="<?php echo url_for('curriculum/coursechecklistcategory?year='.$cbd->getYear().'&semester='.$cbd->getSemester().'&programId='.$cbd->getProgramId()) ?>">
            >> &nbsp; Categorize to Major/Supportive/Common </a> <br />
        <a href="#"> >> &nbsp; Print Curriculum Courses to PDF </a> <br />
        
          <div style="margin-top: 20px;"> <b> Modify course breakdowns for  </b> </div>
        <?php foreach($courseBreakdowns as $cbd): ?>
          >> &nbsp Year <?php echo $cbd->getYear(); ?> Semester <?php echo $cbd->getSemester(); ?> &nbsp; &nbsp; 
          <a href="<?php echo url_for('curriculum/coursechecklistshow?year='.$cbd->getYear().'&semester='.$cbd->getSemester().'&programId='.$cbd->getProgramId()) ?>"> 
            Modify   
          </a> <br />
        <?php endforeach;  ?> 
        <?php endif; ?>   
          
          
    </td> 
    </tr>
</table>