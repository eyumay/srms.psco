<h5>Registration </h5>
<form action="<?php echo url_for('student/registration'); ?>" method="post">
<table align="left">
<tbody> 
<tr>  
<td align="left"> <?php echo $filterform['program_id']->renderRow() ?> </td>
<td align="left"> <?php echo $filterform['academic_year']->renderRow() ?> </td>
</tr>
<tr> 
 <td align="left"> <?php echo $filterform['year']->renderRow() ?> </td>  
 <td align="left"> <?php echo $filterform['semester']->renderRow() ?> </td>
</tr> 
 
<tr colspan="2"> 
 <td align="left"> <input type="submit" value="Filter"><br/> </td>
</tr> 
</tbody> 
</table>
</form>
<h5>Filter to Assign Courses </h5>
<form action="<?php echo url_for('student/registration'); ?>" method="post">
<?php $registrationForm ?>
</form>