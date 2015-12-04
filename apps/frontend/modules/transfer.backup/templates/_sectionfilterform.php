<div class="filter"> 
<form action="<?php echo url_for('programsection/sectionformfilter') ?>" name="form_filter">
<fieldset>
<table style="font-size:11px;" cellpadding="4px">
<tr>
 <td valign="top">Program:   <select name="program_id">
        <?php
        foreach ($programs as $id => $programName) {
        ?>
            <option value="<?php 
        echo $id;
            ?>"><?php
                echo $programName; 
            ?>
            </option>
            <?php 
        }
        ?>
    </select> <br />
 Center:   <select name="center_id">        
        <?php
        foreach ($centers as $center) {
        ?>
            <option value="<?php 
        echo $center->getId();
            ?>"><?php
                echo $center->getName(); 
            ?>
            </option>
            <?php 
        }
        ?>
    </select>     
 </td> 
  <td>Year:   <select name="year">
       

        <?php
        foreach ($years as $year) {
        ?>
            <option value="<?php echo $year ?>"> <?php echo $year; ?>
            </option>
            <?php 
        }
        ?>
    </select>   <br />
Semester:   <select name="semester">
        

        <?php
        foreach ($semesters as $semester) {
        ?>
            <option value="<?php 
        echo $semester;
            ?>"><?php
                echo $semester; 
            ?>
            </option>
            <?php 
        }
        ?>
    </select>   <br />    
  Academic Year:   <select name="academic_year">        
        <?php
        foreach ($academicYears as $academicYear) {
        ?>
            <option value="<?php 
        echo $academicYear;
            ?>"><?php
                echo $academicYear; 
            ?>
            </option>
            <?php 
        }
        ?>
        
    </select>   <br />
 </td> 

</tr>
</table>
</fieldset>
<p class="submit"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="submit" value="Search" name="submit"> </p>
</form>
</div>