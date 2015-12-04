<h4> Manage Program Curriculum for <span style="color: red;"> <?php echo $departmentDetail->getName(); ?> Department </span> </h4> 
<p style='font-size: 12px; '> NOTE: <em>This module will give you Administration interface where Team Leaders of the education team  will define Curriculum </em> </p> 
<table width="666" border="0" cellspacing="0" style="font-size:12px">
  <tr>
    <th width="36" scope="col">S.No.</th>
    <th width="400" scope="col">Program Name </th>
    <th width="241" scope="col">Actions</th>
  </tr>
   
  <?php foreach($departments as $department ): ?> 
  <?php $count=1; ?>
  <tr>
      <td colspan='3'> <?php echo $department->getName(); ?> </td>
  </tr> 
  <?php 
  $showPrograms = FALSE;
  if( Doctrine_Core::getTable('Program')->checkIfProgramIsCreated($department->getId() ) )
      $showPrograms = TRUE;
  ?>
  <?php if($showPrograms):?>  
  <?php foreach(Doctrine_Core::getTable('Program')->getDeparmentPrograms($department->getId())  as $program ): ?>
  <tr>
    <td align="center"><?php echo $count.'.'; ?> </td>
    <td><?php echo $program->getName(); ?></td>
    <td align="center"><a href="<?php echo url_for('curriculum/programDetail?programId='.$program->getId()); ?>">View full curriculum</a> | 
        <a href="<?php echo url_for('program/edit?id='.$program->getId()); ?>">Edit</a> | 
        <a href="<?php echo url_for('curriculum/programDetail?programId='.$program->getId()); ?>">Delete</a>   </td>
  </tr>
  <?php $count++;  ?>
  <?php endforeach; ?>
  
  <?php else: ?>
  <tr>
    <td colspan="3"> No programs yet created ... </td>
  </tr>
  <?php endif; ?>
  <?php endforeach; ?>
</table>