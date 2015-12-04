<h4> Manage Section Students </h4> 

<!-- Section Detail Start -->
<table border="1" style="font-size:11px; background-color:white;" cellpadding="4px" width="800px">
    
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
    <h4> Student Information </h4>
    Name: <?php echo $student->getName().' '.$student->getFathersName().' '.$student->getGrandfathersName() ?> <br />
    IDNo. <?php echo $student->getStudentUid(); ?> <br />
    <a href="<?php echo url_for('transfer/edit/?sectionId='.$sectionDetail->getId().'&studentId='.$student->getId()); ?>"> Edit Profile </a>  | 
    <a href="<?php echo url_for('transfer/deletestudent/?sectionId='.$sectionDetail->getId().'&studentId='.$student->getId()); ?>"> Delete </a>    
    
    
  <h4>Actions</h4>               
                <div>                
                    <ul>
                        <li> <a href="<?php echo url_for('transfer/new/?sectionId='.$sectionDetail->getId()); ?>"> Add New Transfer </a>  </li>                                                 
                        <li> <a href="<?php echo url_for('transfer/newexemption/?sectionId='.$sectionDetail->getId().'&studentId='.$student->getId()); ?>"> Define Course To Exempt </a>  </li>                       
                        <?php if($showExemptions): ?>
                        <li> <a href="<?php echo url_for('transfer/exemptiongradesubmission/?sectionId='.$sectionDetail->getId().'&studentId='.$student->getId()); ?>"> Enter Exemption Grade </a>  </li>                       
                        <?php endif; ?> 
                    </ul>  
                    <br />
                </div>            
</div>
    
    
<div id='left'>
<h4> Exempted Courses </h4>

<table width="463" border="1px" cellspacing="0" cellpadding="3px" style="font-size: 12px;">
  <tr>
    <td align="center"><strong> S/No. </strong></td>  
    <td align="center"><strong> Course Name</strong></td>
    <td align="center"><strong> Code </strong></td>
    <td align="center"><strong> Chrs  </strong></td>
    <td align="center"><strong> Grade  </strong></td>
    <td align="center"><strong> Actions  </strong></td>
  </tr>     
  <?php if($showExemptions): ?>
  <?php $count = 1; ?> 
    <?php foreach($exemptions as $exemption ): ?>    
        <tr>
          <td align="center"><?php echo $count; ?> </td>  
          <td align="center"><?php echo $exemption->getCourse()->getName();  ?>  </td>
          <td align="center">  <?php echo $exemption->getCourse()->getCourseNumber(); ?>  </td>
          <td align="center">  <?php echo $exemption->getCourse()->getCreditHoure();  ?>  </td>
          <td align="center">  
              <?php echo $exemption->getGrade();  ?>  </td>
          <td align="center">  
              <a href="<?php echo url_for('transfer/deleteExemptedCourse/?exemptionId='.$exemption->getId().'&studentId='.$student->getId().'&sectionId='.$sectionDetail->getId()); ?>"> Delete </a>
          </td>
        </tr>
        <?php $count++; ?> 
    <?php endforeach; ?> 
  <?php else: ?>
        <tr><td colspan="4"> No Exempted Courses </td></tr>
  <?php endif; ?> 
</table>
   
<br /> <br /> <br /><br /><br /><br />
</div>
</div>
<a href="<?php echo url_for('transfer/sectiondetail/?id='.$sectionDetail->getId() ) ?>" class="btn"> << Back </a> 
