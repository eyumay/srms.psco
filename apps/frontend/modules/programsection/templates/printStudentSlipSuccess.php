<?php $count=1; ?>
<table style='font-size:11px;' width='400px' border='1px' cellpadding='5px;'>
    <tr>
        <td colspan='4' align='center'>  
            <h5 style='margin:0px; padding:0px;'> Public Service College of Oromia </h5>
            <h5 style='margin:0px; padding:0px;'> Department of <?php echo $departmentName;  ?> </h5>
            <h5 style='margin:0px; padding:0px;'> <?php echo $programName; ?> Program </h5>
            <h5 style='margin:0px; padding:0px;'> Students List </h5> 
            
            <div align="left"  style="margin-top: 20px; font-style: oblique;"> 
                Year: <?php echo $sectionDetail->getYear(); ?> 
                Semester: <?php echo $sectionDetail->getSemester(); ?> 
                Academic Year: <?php echo $sectionDetail->getAcademicYear(); ?>
            </div>          
        </td>                    
    </tr>
    <tr>
        <th> No. </th> 
        <th> Student Name </th>
        <th> ID. </th>
        <th> Sex. </th>
    </tr>
    <?php foreach($students as $student ): ?>
    <tr>        
        <td> <?php echo $count.'. '; ?> </td> 
        <td> <?php echo $student->getName().' '.$student->getFathersName().' '.$student->getGrandfathersName(); ?> </td>
        <td> <?php echo $student->getStudentUid(); ?> </td>
        <td> <?php echo ($student->getSex()==1)?'Male':'Female'; ?> </td>        
    </tr>    
    <?php 
    $count++;
    endforeach; ?>
</table>
<a href="<?php echo url_for('programsection/sectiondetail?id='.$programSectionId) ?>"> << Back to section detail </a>