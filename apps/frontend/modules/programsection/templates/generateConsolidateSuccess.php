<?php $programSectionId = $sectionDetail->getId(); ?> 
<p style="font-size: 11px;"> 
    Program: <span style="color:red"> <i> <?php echo $sectionDetail->getProgram(); ?> </i> </span> 
    Center: <span style="color:red"> <i> <?php echo $sectionDetail->getCenter(); ?> </i> </span> 
    Academic Year: <span style="color:red"> <i> <?php echo $sectionDetail->getAcademicYear(); ?></i> </span>  
    Year: <span style="color:red"> <i> <?php echo $sectionDetail->getYear(); ?> </i> </span> 
    Semester: <span style="color:red"> <i> <?php echo $sectionDetail->getSemester(); ?> </i> </span> 
    
</p>

<div style="font-size:8px; margin-bottom: 10px; " > 
    <table border="1" cellpadding="5px" style="font-size:11px">    
        <tr style="color:white; background:black; font-weight: bold; ">
            <td> Full Name </td> 
            <td> Semester Chr. </td> 
            <td> Total Chr </td>
            <td> SGPA </td>
            <td> CGPA </td>
            <td> Prev. Status </td>
            <td> Current Status </td>
            <td> Remark </td>
            
        </tr> 
       <?php foreach($students as $student ): ?>
        
       <?php foreach($student->getEnrollmentInfos() as $enrollment ): ?>
           
       <?php if(!$enrollment->getLeftout() ): ?>
        <tr> 
            <td> 
                <?php echo $enrollment->getStudent(); ?>
            </td>    
            <td> 
                <?php echo Statuses::getSemesterCreditHours($student->getEnrollmentInfos()); ?>
            </td>  
            <td> 
                <?php echo Statuses::getTotalCreditHours($student->getEnrollmentInfos()); ?>
            </td>  
            <td>               
                <?php echo Statuses::getGPA($student->getEnrollmentInfos()); ?>
            </td>                  
            <?php if($sectionDetail->getYear() == 1 && $sectionDetail->getSemester() == 1): ?>
                <td> 
                    -                                 
                </td>  
            <?php else: ?>
                <td> 
                     <?php echo Statuses::getCGPA($student->getEnrollmentInfos()); ?>
                </td>                  
            <?php endif; ?>            
            <td> 
                
            </td>  
            <td> 
                <?php                     
                    echo Statuses::getStudentStatus($student->getEnrollmentInfos(), $sectionDetail->getYear(), $sectionDetail->getSemester());
                ?> 
            </td>  
            <td> 
                
            </td>              
        </tr> 
        <?php endif; ?>
        <?php endforeach; ?>
        <?php endforeach; ?>        
    </table> 
    
</div>
<a href="<?php echo url_for('programsection/sectiondetail?id='.$programSectionId) ?>" class ="btn btn-primary"> << Back to section detail </a> | <a href="#" style="font-size: 11px;">  Print to PDF </a>

