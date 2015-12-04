<h4> Manage Readmission </h4> 

<div style="font-size:12px;"> 
<!-- Section Detail Start -->
<table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="800px">
    
    <tr style="background-color: #000099; color: white;">
        <td align="center"> Class Information </td>
    </tr>

    <tr>
        <td valign="top">
            ID: <span style="color:red"> <i> <?php echo $student->getStudentUid(); ?> </i> </span> &nbsp; &nbsp; &nbsp; 
            Name: <span style="color:red"> <i> <?php echo $student->getName().' '.$student->getFathersName().' '.$student->getGrandfathersName(); ?> </i> </span>  &nbsp; &nbsp; &nbsp; 
            Admission Year: <span style="color:red"> <i> <?php echo $student->getAdmissionYear(); ?> </i> </span> &nbsp; &nbsp; &nbsp; 
            Date of Birth:  <span style="color:red"> <i> <?php echo $student->getDateOfBirth(); ?> </i> </span>  &nbsp; &nbsp; &nbsp; 
        </td>
    </tr>
</table>
<!-- Section Detail End -->

<div id='dropaddcontainer'>
<div id='right'>
  <h4>Actions</h4>
  <ul>

        <li> None </li>
       
</ul>
</div>
    
    
<div id='left'>
<h4> Readmit Student </h4>

<form action="<?php echo url_for('readmission/readmitstudent/?enrollmentId='.$enrollmentDetail->getId()); ?>" method="post">
<table width="490" border="1" cellspacing="0" cellpadding="2px" style="font-size: 12px;">
    <?php if($showReadmissionForm): ?>
        <?php echo $readmissionForm; ?> 
    <?php else: ?>
        No Active Sections 
    <?php endif; ?> 
</table>
<input type="submit" value="Readmit" /> Cancel
</form>
</div>
</div>







<a href="<?php echo url_for('readmission/index') ?>" class="btn"> << Back </a> 
