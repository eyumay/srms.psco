<?php use_stylesheet('instr.css') ?> 
<h1>Filtered Students </h1>
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
            <th>Make View</th>
            <th>Make Edit</th>
        </tr>
    </thead>
    <tbody>
         <?php foreach ($students as $student): ?>
            <tr>
                <td> <?php echo $student->getId() ?>  </td>
                 
                
                <td> <?php echo $student->getName()?>  </td>
                <td> <?php echo $student->getFathersName()?>  </td>
               
                <td> <?php echo $student->getGrandfathersName()?>  </td>
               
                <td> <a href="<?php echo url_for('student/show/?id='.$student->getId()) ?>"> View </a> </td>
                <td> <a href="<?php echo url_for('student/edit/?id='.$student->getId()) ?>"> Edit </a> </td>
            </tr>
        <?php endforeach; ?> 
    </tbody>
</table>

<a href="<?php echo url_for('student/new') ?>">New</a>  