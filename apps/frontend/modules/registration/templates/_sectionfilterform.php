<div class="filter"> 
<form action="<?php echo url_for('registration/index') ?>" name="form_filter">
<fieldset>
<table style="font-size:11px;" cellpadding="4px">
<tr>
 <td valign="top">Program:   <select name="program_id">
         <option value=""> Select Program </option>
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
     <option value=""> Select Center </option>
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
    </select>   <br />
    
    <input type="checkbox" name="active_class" value="active"> &nbsp; Display Active Class Only
 </td> 
  <td>Year:   <select name="year">
       <option value=""> Select Year </option>

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
        <option value=""> Select Semester </option>

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
      <option value=""> Select Academic Year </option>
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
<p class="submit"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="submit" value="Filter Program Sections" name="submit"> </p>
</form>
</div>