<?php if($studentHasCourseToRegister): ?>
<?php use_stylesheets_for_form($registrationForm) ?>
<?php use_javascripts_for_form($registrationForm) ?>
<?php use_stylesheet('ins_up.css') ?>
<?php endif; ?> 
<h4> Registration </h4> 

<div style="font-size:12px;"> 
    <table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="450px">    
        <tr style="background-color: #000099; color: white;">
            <td colspan="2"> Class Information </td> 
        </tr> 
        <tr>
            <td valign="top" colspan ="2">
                Program: <span style="color:red"> <i> <?php echo $sectionDetail->getProgram(); ?> </i> </span> 
                Center: <span style="color:red"> <i> <?php echo $sectionDetail->getCenter(); ?> </i> </span>   <br />
                Academic Year: <span style="color:red"> <i> <?php echo $sectionDetail->getAcademicYear(); ?></i> </span>  <br />
                Year: <span style="color:red"> <i> <?php echo $sectionDetail->getYear(); ?> </i> </span> 
                Semester: <span style="color:red"> <i> <?php echo $sectionDetail->getSemester(); ?> </i> </span>  <br />
            </td>
        </tr>                                     
    </table> 
</div>
<?php if($studentHasCourseToRegister): ?>
<form action="<?php echo url_for('registration/registration'); ?>" method="post">
<?php echo $registrationForm;  ?>
<input type="submit" value="Register"><br/>
</form> 
<a href="<?php echo url_for('dropadd/sectiondetail/?id='.$sectionDetail->getId()) ?>"> << Back </a>
<?php endif; ?> 