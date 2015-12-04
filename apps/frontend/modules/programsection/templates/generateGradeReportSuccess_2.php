<?php foreach($enrollments as $enrollment): ?>
    <?php echo $enrollment->getStudent()->getName().' '.$enrollment->getStudent()->getFathersName().' '.$enrollment->getStudent()->getGrandfathersName();?> <br />
    <?php foreach($enrollment->getRegistrations() as $registration): ?>
        <?php foreach($registration->getStudentCourseGrades() as $scg): ?>
            <?php echo $scg->getCourse(). ' ' ?>
            <?php 
                if($scg->getGradeId()==NULL)
                        echo '--';
                else
                    echo $scg->getGrade();
            ?>
            <br />
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endforeach; ?>