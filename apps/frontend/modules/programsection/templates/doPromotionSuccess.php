<div style="font-size:12px;"> 
 <?php foreach($students as $student): ?>
    <?php foreach($student->getEnrollmentInfos() as $enrollment): ?>
           <?php $leftoutEnrollments = Doctrine_Core::getTable('EnrollmentInfo')->getLeftoutEnrollments($enrollment); ?>
           <?php if(!is_null($leftoutEnrollments)): ?>
           <?php foreach($leftoutEnrollments as $loe): ?>
            TChrs <?php echo $loe->getTotalChrs(); ?>
           <?php endforeach; ?>
           <?php endif; ?>
    <?php endforeach; ?>
 <?php endforeach; ?> 
</div>

 <?php foreach($students as $student): ?>
    <?php foreach($student->getEnrollmentInfos() as $enrollment): ?>
        <?php if(!$enrollment->getLeftout()): ?>
            Total Chrs <?php echo $enrollment->getTotalChrs(); ?> TotalR. Chrs = <?php echo $enrollment->getTotalRepeatedChrs(); ?> <br />
        <?php endif; ?>
    <?php endforeach; ?>
 <?php endforeach; ?> 

<?php 
foreach($this->students as $student) ##Promoted Enrollment Info must contain everything from previous semester(Add enrollment detail + Normal Enrollment Detail)
      {
        foreach ($student->getEnrollmentInfos() as $enrollmentObj)
        {
            if(!$enrollmentObj->getLeftout())
            {
                $leftoutEnrollments = Doctrine_Core::getTable('EnrollmentInfo')->getLeftoutEnrollments($enrollmentObj);
                if(!is_null($leftoutEnrollments))
                {
                    foreach($leftoutEnrollments as $loe)
                    {
                        ##modify existing $enrollment Module
                        $enrollmentObj->setTotalChrs($enrollmentObj->getTotalChrs() + $loe->getTotalChrs() );
                        $enrollmentObj->setTotalGradePoints($enrollmentObj->getTotalGradePoints() + $loe->getTotalGradePoints());
                        $enrollmentObj->setTotalRepeatedChrs($enrollmentObj->getTotalRepeatedChrs() + $loe->getTotalRepeatedChrs() );
                        $enrollmentObj->setTotalRepeatedGradePoints($enrollmentObj->getTotalRepeatedGradePoints() + $loe->getTotalRepeatedGradePoints() );
                    }
                }                  
            }

        }
      }   

?>

<br />
 <?php foreach($students as $student): ?>
    <?php foreach($student->getEnrollmentInfos() as $enrollment): ?>
        <?php if(!$enrollment->getLeftout()): ?>
            Total Chrs <?php echo $enrollment->getTotalChrs(); ?> TotalR. Chrs = <?php echo $enrollment->getTotalRepeatedChrs(); ?> <br />
        <?php endif; ?>
    <?php endforeach; ?>
 <?php endforeach; ?> 