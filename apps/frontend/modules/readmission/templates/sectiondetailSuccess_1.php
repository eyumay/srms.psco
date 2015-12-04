<?php if($courseCheclistIsDefined): ?>
<?php use_stylesheets_for_form($courseChecklistForm) ?>
<?php use_javascripts_for_form($courseChecklistForm) ?>
<?php endif; ?>
<?php use_stylesheet('ins_up.css') ?><h4> Course Offering </h4> 

<div style="font-size:12px;"> 
    <table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="800px">    
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
        <tr style="background-color: #000099; color: white;">
            <td colspan="2"> Courses to assign </td> 
        </tr>                            
    </table>
              <?php if( $courseCheclistIsDefined): ?>                                     
                    <form action="<?php echo url_for('sectioncourseoffering/doSectionCourseOffering'); ?>" method="post">
                    <?php echo $courseChecklistForm; ?>
                    <input type="submit" value="Offer Course for Current Section"><br/>
                    </form>
                <?php else: ?>
                No  course checklist defined!
                <?php endif; ?>    
</div>


<a href="<?php echo url_for('sectioncourseoffering/index') ?>"> << Back </a>