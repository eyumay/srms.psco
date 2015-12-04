<h4> Manage Readmission </h4>
<?php use_stylesheet('instr.css') ?>
<?php include_partial('filterform', array('departments' => $departments)) ?>
<div class="space">&nbsp;</div>


<table class="table table-hover table-condensed ">
    <thead>
        <tr>
            <th>Student ID</th>
            <th>First Name</th>
            <th>Father Name</th>
            <th>Grand Father Name</th>
            <th>Action</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($pager->getResults() as $student): ?>

            <tr class="info">
                <td> <?php echo $student->getStudentUid() ?>  </td>


                <td> <?php echo $student->getNameByUid($student->getStudentUid()) ?>  </td>
                <td> <?php echo $student->getFatherNameByUid($student->getStudentUid()) ?>  </td>

                <td> <?php echo $student->getGrandfatherNameByUid($student->getStudentUid()) ?>  </td>

                <td>  
                    <?php if(!$student->checkIfEnrolled() ): ?>
                    <?php echo link_to('Delete', 'student/delete?id='.$student->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>   | 
                    <?php endif; ?>
                    <a href="<?php echo url_for('student/show/?id='.$student->getId()) ?>"> View </a>
                </td>

            </tr>
        <?php endforeach; ?>
        <tr><td colspan="7"></td></tr>
    </tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
    <div class="pagination">
        <ul>
            <li>
                <a href="<?php echo url_for('student/index') ?>?page=1">
                    first
                </a>
            </li>

            <li>    <a href="<?php echo url_for('student/index') ?>?page=<?php echo $pager->getPreviousPage() ?>">
                    prev
                </a>
            </li>

            <?php foreach ($pager->getLinks() as $page): ?>
                <li>
                    <?php if ($page == $pager->getPage()): ?>
                        page <?php echo $page ?>
                    <?php else: ?>
                        <a href="<?php echo url_for('student/index') ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>

            <li>
                <a href="<?php echo url_for('student/index') ?>?page=<?php echo $pager->getNextPage() ?>">
                    Next
                </a>
            </li>
            <li>
                <a href="<?php echo url_for('student/index') ?>?page=<?php echo $pager->getLastPage() ?>">
                    Last
                </a>
            </li>
        </ul>
    </div>
<?php endif; ?>


