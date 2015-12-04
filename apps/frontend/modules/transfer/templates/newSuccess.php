<h4> Manage Student Transfers </h4> 

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
  <h4>Actions</h4>               
                <div>                
                    <ul>
                        <li> <a href="<?php echo url_for('transfer/new/?sectionId='.$sectionDetail->getId()); ?>"> Add New Transfer </a>  </li>                       
                    </ul>                              
                </div>            
</div>
    
    
<div id='left'>

<h4> Add New Transfer  </h4>
<form action="<?php echo url_for('transfer/new/?sectionId='.$sectionDetail->getId()); ?>" method="post">
<table width="490" border="0" cellspacing="0" cellpadding="2px" style="font-size: 12px;">
    
        <?php echo $studentForm; ?>
</table>
    <input type="submit" value="Enroll" /> <a href="<?php echo url_for('transfer/index') ?>" > cancel  </a>
</form>

   
<br /> <br /> <br />
</div>
</div>
<a href="<?php echo url_for('transfer/sectiondetail/?id='.$sectionDetail->getId() ) ?>" class="btn"> << Back </a> 