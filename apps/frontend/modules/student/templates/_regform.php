<h1>New Student</h1>

<?php include_partial('regform', array('regform' => $registrationForm(array(
        'courseIds' => $courseIds,
        'studentIds' => $studentIds
)))); ?>