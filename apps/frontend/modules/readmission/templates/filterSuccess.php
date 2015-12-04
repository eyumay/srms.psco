<?php use_stylesheet('instr.css') ?> 
<h4> Manage Readmission </h4>
<?php include_partial('filterform', array('departments' => $departments)) ?>
<div class="space">&nbsp;</div>

<div id="instr">
<table class="instr">
    <thead>
        <tr calss="tablehead">
            <th>Student ID</th> 
            <th>First Name</th>
            <th>Father Name</th>
            <th>Grand Father Name</th>
            <th>Readmission  </th>
        </tr>
    </thead>
    <tbody>
         <?php foreach ($students as $student): ?>
            <tr>
                <td> <?php echo $student->getStudentUid() ?>  </td>
                 
                
                <td> <?php echo $student->getName()?>  </td>
                <td> <?php echo $student->getFathersName()?>  </td>
               
                <td> <?php echo $student->getGrandfathersName()?>  </td>
               
                <td> <a href="<?php echo url_for('readmission/readmissiondetail/?id='.$student->getId()) ?>"> Goto Readmission </a> </td>                
            </tr>
        <?php endforeach; ?> 
    </tbody>
</table>
</div>