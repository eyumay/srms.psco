<?php if($studentsCanRegister): ?>
<?php use_stylesheets_for_form($registrationForm) ?>
<?php use_javascripts_for_form($registrationForm) ?>
<?php use_stylesheet('ins_up.css') ?>
<?php endif; ?> 
<h4> Manage Registration </h4> 

<div style="font-size:12px;"> 
<table border="1" style="font-size:12px; background-color:white" cellpadding="4px" width="600px">
    
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
<h5>Manage Normal Registration</h5>
<?php if(!$sectionIsRegistered): ?> 
     <table border="1" style="font-size:12px; background-color:white" cellpadding="4px" width="600px">     
        <tr>
            <td valign="top" colspan ="2">
                
                <?php if($courseHasPrerequisite): ?>
                The following are courses having prerequisites:  <br />
                    <?php foreach($coursesWithPrerequisites as $prerequisiteCourse): ?>
                        <?php echo $prerequisiteCourse->getCourse(); ?> <br />
                    <?php endforeach; ?>                      
                <?php else: ?>
                    <?php echo "There are no courses with prerequisites!"; ?>
                <?php endif; ?>
            </td>
        </tr>   
        <?php if($studentsCanNotRegister): ?>
        <tr style="background-color: #000099; color: white;">
            <td colspan="2"> Students with Prerequisite course problem </td> 
        </tr>         
        <tr>
            <td valign="top" colspan ="2">
                <?php foreach($enrollmentsCannotRegister as $key=>$studentNotToEnroll): ?>
                <?php echo $studentNotToEnroll; ?> &nbsp; <br />
                <?php endforeach; ?>
            </td>
        </tr>         
        <?php endif; ?>
        
    </table> 
</div>
<?php if($studentsCanRegister): ?>
<form action="<?php echo url_for('registration/registration'); ?>" method="post">
<?php echo $registrationForm;  ?>
<input type="submit" value="Register"><br/>
</form> 
<?php else: ?>
All Normal Registrations are Completed. <br />
<?php endif; ?>
<a href="<?php echo url_for('registration/index') ?>"> << Back </a>
<?php else: ?>
<p> This section students are Registered! </p>
<?php endif; ?>
<h5>Manage ADD Enrollments </h5>
<?php if($showAddEnrollments): ?>
<table border="1" style="font-size:12px; background-color:white" cellpadding="4px" width="800px">
    <tr>
        <td align="center"> <strong> Student Name </strong> </td>
        <td align="center"> <strong>  Program  </strong> </td>
        <td align="center"> <strong>  Added Course  </strong> </td>
        <td align="center"> <strong>  Action   </strong> </td>
    </tr>
    <?php foreach($addEnrollments->getEnrollmentInfos() as $enrollmentInfo): ?>
    <tr>
        <td> <?php echo $enrollmentInfo->getStudent() ?> </td>
        <td> <?php echo $enrollmentInfo->getProgram() ?> </td>
        <?php foreach($enrollmentInfo->getCoursePools() as $coursePool ): ?>
            <td> <?php echo $coursePool->getCourse(); ?> </td>
        <?php endforeach; ?>
        
        <td> 
            
                       
            <?php if($enrollmentInfo->getSemesterAction() == sfConfig::get('app_registered_semester_action')): ?>            
                ADD Registered
            <?php else: ?>
                <a href="<?php echo url_for('registration/registerwithadd/?enrollmentId='.$enrollmentInfo->getId().'&courseId='.$coursePool->getCourseId()) ?>"> Allow ADD Registration   </a>
            <?php endif; ?>
            
        </td>
    </tr>        
    <?php endforeach; ?> 
    
</table>
<?php else: ?>
<p style="font-size:12px"> No ADD Enrollments Available </p>
<?php endif; ?>    