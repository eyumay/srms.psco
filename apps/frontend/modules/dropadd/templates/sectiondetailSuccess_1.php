<h4> Manage Add and Drop </h4> 
<?php $check = $sectionDetail->getEnrollmentInfos();  ?>


<div style="font-size:12px;"> 
<!-- Section Detail Start -->
<table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="800px">
    
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


<?php if( $check[0] != ''): ?>     
    <p style="font-size:12px; margin-bottom: 0px; margin-top: 15px;"> Student list for Drop/ADD  </p>
    <?php if(!$courseOfferingDefined): ?>
    <p style="font-size:12px; margin-bottom: 0px; margin-top: 15px; color:red;"> 
        <strong> **Please define Semester Course Offering to see students with drop cases! </strong> 
    </p>
    <?php endif; ?>
    <table border="1" style="font-size:11px; background-color:white" cellpadding="4px" width="800px"> 
        <tr style="background-color: #000099; color: white;">
            <td> Section Students </td>
            <td> DROPS </td>
            <td> ADDS  </td>
            <td> Drop Registrations </td>
        </tr>            
        <?php $count=1;  ?>
        <?php  foreach($sectionDetail->getEnrollmentInfos() as $enrollment ): ?>                 
         
        <tr>
            <td valign="top">                   
                <?php echo $count.'. '; ?> 
                <?php echo $enrollment->getStudent(); ?>     <br />  
            </td> 
            <td>
                <ul> 
                <?php if($courseOfferingDefined): ?>
                <?php $studentHasDropRegistration =  $enrollment->checkIfStudentHasDropRegistration(); ?>
                <?php if($studentHasDropRegistration): ?>
                
                    <?php foreach($enrollment->getCoursesToDrop() as $course): ?>
                    <li> <?php echo $course->getName();  ?> </li> 
                    <?php endforeach; ?>
                <?php else: ?>
                    <li> None </li>
                <?php endif; ?>
                
                <?php else: ?> 
                    <li> None </li>
                <?php endif; ?>
                </ul> 
            </td>            
            <td>
                <?php $coursePoolArray = array();  ?>
                <?php if($enrollment->getStudent()->checkIfActiveCoursesHaveGrades()): ?>
                    <?php foreach($enrollment->getStudent()->getWithActiveCourses()->getEnrollmentInfos() as $enrollmentWithCourseGrades ): ?>
                        <?php foreach( $enrollmentWithCourseGrades->getRegistrations() as $registration ): ?>
                            <?php foreach($registration->getStudentCourseGrades() as $scg): ?>
                                <?php if($scg->checkIfStudentCourseIsFailed() ): ?>

                                        <?php if($enrollment->getStudent()->getCoursesInCoursePool() != '' ): ##if there are courses in pool ?>

                                            <?php foreach($enrollment->getStudent()->getCoursesInCoursePool()->getEnrollmentInfos() as $enrollment): ?>
                                                <?php foreach($enrollment->getCoursePools() as $coursePool ): ?>
                                                    <?php $coursePoolArray[] = $coursePool->getCourseId(); ?>                                        
                                                <?php endforeach; ?>                                              
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                
                                        <?php if(!(in_array($scg->getCourseId(), $coursePoolArray)) ): ?>
                                            <a href="<?php echo url_for('dropadd/add?sectionId='.$sectionDetail->getId().'&studentId='.$enrollment->getStudentId().'&courseId='.$scg->getCourseId()); ?>"> 
                                                &nbsp;&nbsp; +ADD &nbsp;&nbsp;
                                            </a> 
                                        <?php else: ?>
                                            <strong> <em> <span style="color:green;"> &nbsp;&nbsp; +ADDED &nbsp;&nbsp; </span> </em> </strong> 
                                        <?php endif; ?>
                                        <?php echo $scg->getCourse(); ?> <br />                
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                                            <ul>
                                                <li> None </li>
                                            </ul>
                <?php endif; ?>                                        

            </td>
            <td>
                
                <?php if($courseOfferingDefined): ?>                
                    <?php if($studentHasDropRegistration): ?> 
                        <?php if($enrollment->getSemesterAction() == sfConfig::get('app_enrolled_semester_action') ): ?>                
                        <a href="<?php echo url_for('dropadd/registrationwithdrop?enrollmentId='.$enrollment->getId().'&sectionId='.$sectionDetail->getId().'&studentId='.$enrollment->getStudentId()); ?>">
                            - Register with Drop  
                        </a>
                        <?php else: ?>
                         - None
                        <?php endif; ?>
                    <?php else: ?>
                        <ul>
                            <li> None </li>
                        </ul>                           
                    <?php endif; ?>
                <?php else: ?>
                    <ul>
                        <li> None </li>
                    </ul>        
                <?php endif; ?> 
            </td>
                <?php $count++;   ?>
                <?php endforeach; ?> 
        </tr> 
    </table> 
</div>

<?php else: ?>
    <?php echo 'No Enrolled Students';  ?>
<?php endif; ?> 
<a href="<?php echo url_for('dropadd/index') ?>"> << Back </a>