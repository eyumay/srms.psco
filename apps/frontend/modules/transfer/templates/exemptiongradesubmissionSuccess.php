<?php use_stylesheets_for_form($exemptionForm) ?>
<?php use_javascripts_for_form($exemptionForm) ?>
<?php use_stylesheet('ins_up.css') ?>
<h4> Manage Student Transfers  </h4> 

<!-- Section Detail Start -->
<table border="1" style="font-size:11px; background-color:white;" cellpadding="4px" width="900px">
    
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

<div id='dropaddcontainer' style="width:900px;">
<div id='right' style="width:200px; ">
  <h4>Actions</h4>               
                <div>                
                    <ul>
                        <li> <a href="<?php echo url_for('transfer/new/?sectionId='.$sectionDetail->getId()); ?>"> Add New Transfer </a>  </li>                       
                        <li> <a href="<?php echo url_for('transfer/edit/?sectionId='.$sectionDetail->getId().'&studentId='.$student->getId()); ?>"> Edit </a>  </li>  
                        <li> <a href="<?php echo url_for('transfer/delete/?sectionId='.$sectionDetail->getId().'&studentId='.$student->getId()); ?>"> Delete </a>  </li>                          
                        <li> <a href="<?php echo url_for('transfer/newexemption/?sectionId='.$sectionDetail->getId().'&studentId='.$student->getId()); ?>"> Define Course To Exempt </a>  </li>                       
                        <li> <a href="<?php echo url_for('transfer/exemptiongradesubmission/?sectionId='.$sectionDetail->getId().'&studentId='.$student->getId()); ?>"> Enter Exemption Grade </a>  </li>                       
                    </ul>                                                  
                </div>            
</div>
    
    
<div id='left' style="width:600px;">
<h4> Courses To Exempt </h4>

<form action="<?php echo url_for('transfer/exemptiongradesubmission/?sectionId='.$sectionDetail->getId().'&studentId='.$student->getId()); ?>" method="post">
<table border="0" cellspacing="0" cellpadding="2px" style="font-size: 12px;">
    
        <?php echo $exemptionForm; ?>
</table>
    <input type="submit" value="Save" /> <a href="<?php echo url_for('transfer/index') ?>" > cancel  </a>
</form>
   
<br /> <br /> <br />
</div>
</div>
<a href="<?php echo url_for('transfer/index') ?>" class="btn"> << Back </a> 
