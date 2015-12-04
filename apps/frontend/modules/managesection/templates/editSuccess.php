<?php use_stylesheet('instr.css') ?>

<h4> Manage Program Sections </h4> 
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

<div id='dropaddcontainer' style="width:100%;">

    
    
<div id='left' style="width:100%;border:none;" style="font-size: 11px;">
<table>
        <tr align="center"> 
            <td align="center" colspan="2"> 
                <h4> Editing Section Information  </h4>
                **Please review all fields before saving. ** All fields marked as (*) are important! 
            </td> 
        </tr>
    <tfoot>   
    <form action="<?php url_for('managesection/edit?programSectionId='.$sf_request->getParameter('programSectionId')) ?>" method="post"> 
        <?php echo $programSectionForm; ?> 
        <tr><td colspan="2"><input type="submit" value="Save" /> <a href="<?php echo url_for('managesection/index') ?>">Cancel </a></td></tr>
    </form>
    </tfoot>
</table>
</div>
</div>