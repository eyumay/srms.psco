
<div style="font-size:12px;"> 
    <table border="1" style="font-size:11px; background-color:white" cellpadding="4px">    
        <tr style="background-color: #000099; color: white;">
            <td> Class Information </td> 
            <td> Students able to be promoted  </td> 
            <td> <b> Promotion Information  </b>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  </td> 
        </tr> 
        <tr>
            <td valign="top">
                Program: <span style="color:red"> <i> <?php echo $sectionDetail->getProgram(); ?> </i> </span> <br />
                Center: <span style="color:red"> <i> <?php echo $sectionDetail->getCenter(); ?> </i> </span>   <br />
                Academic Year: <span style="color:red"> <i> <?php echo $sectionDetail->getAcademicYear(); ?></i> </span>  <br />
                Year: <span style="color:red"> <i> <?php echo $sectionDetail->getYear(); ?> </i> </span> <br />
                Semester: <span style="color:red"> <i> <?php echo $sectionDetail->getSemester(); ?> </i> </span>  <br />
            </td>
            <td valign="top">    
                <h4> These students will be promoted</h4>                                
                <?php $count=1; ?>
                <?php foreach($students as $student): ?>
                    <?php foreach($student->getEnrollmentInfos() as $enrollment ): ?> 

                        <?php if(!$enrollment->getLeftout()): ?>
                            <?php $status = Statuses::getStudentStatus($student->getEnrollmentInfos(), $sectionDetail->getYear(), $sectionDetail->getSemester()); ?>

                            <?php if($status == 'PASS' || $status == 'WARNING'): ?>
                                <?php echo $count.'. '; ?>
                                <?php echo $student->getName().' '.$student->getFathersName().' '.$student->getGrandfathersName(); ?>  
                                <span style="color:red"> <?php echo Statuses::getStudentStatus($student->getEnrollmentInfos(), $sectionDetail->getYear(), $sectionDetail->getSemester()); ?>   </span>    <br />    
                                <?php $count++; ?>
                            <?php endif; ?>                
                        <?php endif; ?>
                    <?php endforeach; ?>  
                <?php endforeach; ?>
                                
                <h4> These students will be promoted</h4>                                
                <?php $count=1; ?>
                <?php foreach($students as $student): ?>
                    <?php foreach($student->getEnrollmentInfos() as $enrollment ): ?> 

                        <?php if(!$enrollment->getLeftout()): ?>
                            <?php $status = Statuses::getStudentStatus($student->getEnrollmentInfos(), $sectionDetail->getYear(), $sectionDetail->getSemester()); ?>

                            <?php if($status != 'PASS' && $status != 'WARNING'): ?>
                                <?php echo $count.'. '; ?>
                                <?php echo $student->getName().' '.$student->getFathersName().' '.$student->getGrandfathersName(); ?>     
                                <span style="color:red"> <?php echo Statuses::getStudentStatus($student->getEnrollmentInfos(), $sectionDetail->getYear(), $sectionDetail->getSemester()); ?>   </span>    <br />    
                                <?php $count++; ?>
                            <?php endif; ?>                
                        <?php endif; ?>
                    <?php endforeach; ?>  
                <?php endforeach; ?>                                
            </td>
            <td valign="top"> 
                <strong> Current class: </strong> <br />
                Current Academic Year: <?php echo $sectionDetail->getAcademicYear(); ?> <br />
                Current Year: <?php echo $promotionInfo->getCurrentYear(); ?> <br />
                Current Semester: <?php echo $promotionInfo->getCurrentSemester(); ?> <br /> <br />
                
                <strong> To next level class: </strong> <br />
                To Academic Year: <?php /*echo $promotionInfo->getToAcademicYear(); */ 
                                    echo ProgramSectionActions::getNextACYearForSection($promotionInfo->getCurrentYear(),
                                                                                    $promotionInfo->getCurrentSemester(), 
                                                                                    $sectionDetail->getAcademicYear()
                                            );
                                  ?> <br />
                To Year: <?php echo $promotionInfo->getToYear(); ?> <br />
                To Semester: <?php echo $promotionInfo->getToSemester(); ?> <br /><br /><br /><br />
                
                
                <a href="<?php echo url_for('programsection/doPromotion?id='.$sectionDetail->getId()) ?>" class="btn"> >> Proceed with promotion  </a>
            </td>
        </tr> 
    </table> 
</div>


<a href="<?php echo url_for('programsection/index') ?>" class="btn"> << Back </a>
