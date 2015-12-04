<?php use_stylesheets_for_form($courseChecklistForm) ?>
<?php use_javascripts_for_form($courseChecklistForm) ?>
<?php use_stylesheet('ins_up.css') ?>

<h4> Manage Program Curriculum:   <span style="color:red;font-style: italic;"><?php echo $program->getName(); ?> </span> </h4>

<p style="font-size:12px; margin-bottom:3px; margin-top: 20px;">
    <span style="color:red;font-style: italic;"> 
        <?php echo $program->getName();  ?>
    </span>  Modifying Course Checklist / Breakdown <br />
    Year - <?php echo $year; ?>, Semester <?php echo $semester; ?> Courses
</p>
<p style="font-size:12px; margin-bottom:3px; "> Course Redefine Panel </p>
<hr />
<form action="<?php echo url_for('curriculum/coursechecklistredefine?programId='.$program->getId().'&year='.$year.'&semester='.$semester); ?>" method="post">
    <?php echo $courseChecklistForm; ?> 
    <input type="submit" value="Save"> | 
    <a href="<?php echo url_for('curriculum/programDetail?programId='.$program->getId() )?>" style="font-size: 12px;"> Cancel </a>
</form>