<?php use_stylesheet('instr.css') ?> 
<?php include_partial('sectionfilterform', array('programs'        => $programs, 
					  'years'           => $years,
					  'semesters'       => $semesters, 
					  'academicYears'   => $academicYears, 	
					  'centers'         => $centers													
					)) ?>

<table>
  <thead>
    <tr>

    </tr>
  </thead>
  <tbody>
    <tr>

    </tr>
  </tbody>
</table>
<?php if($showPrograms): ?>
<table style="font-size:12px;" border="1px" cellpadding="5x; ">
    <tr>
        <?php foreach($departmentPrograms as $program): ?>
            <td> 
                <?php echo $program->getName(); ?> Program 
                <ul>
                <?php foreach($program->getProgramSections() as $ps ): ?>
                    <li> 
                        <?php echo 'Year '. $ps->getYear(). ', Semester '.$ps->getSemester();  ?> Class <br />
                        <a href="<?php echo url_for('sectioncourseoffering/programlevelofferingnew?programId='.$program->getId().'&year='.$ps->getYear().'&semester='.$ps->getSemester()) ?>">  
                            Offer Course
                        </a>
                    </li>
                <?php endforeach; ?>
                </ul>
            </td>
        <?php endforeach; ?>
    </tr>
</table>
<?php else: ?>
No Active Programs.
<?php endif; ?>
