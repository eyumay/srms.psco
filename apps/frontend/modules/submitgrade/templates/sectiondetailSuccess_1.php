<?php $count=1; ?> 
<h4> Grade Submission Subsystem </h4> 

<div style="font-size:11px;"> 
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
            <td colspan="2"> Courses to submit grade, </td> 
        </tr> 
        <tr> 
            <th> Semester Courses </th><th> Actions</th>
        </tr>
        
        <?php if($courseIsDefined): ?>
        <?php foreach($coursesToOffer as $courseToOffer): ?>
        <tr style="background-color: #FFFFFF; color: black;">
            <td>                                                                           
                 <?php echo $count.'. '.$courseToOffer->getCourse(); ?> <br />
            </td> 
            <td> 
                <?php if(!Doctrine_Core::getTable('SectionCourseOffering')->checkIfCourseGradeSubmitted($sectionDetail->getId(), $courseToOffer->getCourseId())): ?> 
                    <a href="<?php echo url_for('submitgrade/entergrade/?sectionId='.$sectionDetail->getId().'&courseId='.$courseToOffer->getCourseId()) ?>">Submit grade for this course </a> 
                <?php else: ?>
                    Submit grade for this course
                <?php endif; ?>
            </td>
        </tr>
        <?php $count++; ?> 
        <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td> 
                No  course checklist defined!                                  
            </td>
        </tr>
        <?php endif; ?>            
                 
    </table>
    <div > 
  
    </div>
</div>


<a href="<?php echo url_for('submitgrade/index') ?>" class ="btn"> << Back </a>