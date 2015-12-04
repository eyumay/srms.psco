<h4> Manage <span style="color:red;"> Student Withdrawal </span> </h4>

<div class="filter" style="font-size:11px;"> 
<form action="<?php echo url_for('withdraw/filter') ?>" method="get">
<fieldset>
<legend> Filter to withdraw </legend>
<table>
<tr> 
    <td>ID NO.:</td><td><input type="text" id="txtbox" name="student_uid" name="student_uid" title="Enter Student Id" value="Enter Student Id"  
                  
                  onfocus="if(this.value == $(this).attr('title')) {
                  this.value = '';
              }" 
                  onblur=" 
                    if(this.value == '') {
                        this.value = $(this).attr('title');
                    }"/></td> 

<td>&nbsp;&nbsp;&nbsp;Father Name :</td> <td><input type="text" id="txtbox" name="fstudentname" value="Enter Father Name" title="Enter Father Name"   onfocus="if(this.value == $(this).attr('title')) {
                  this.value = ''; 
              }" 
                  onblur="
                    if(this.value == '') {
                        this.value = $(this).attr('title');
                    }"/> </br></td>
</tr>  
<tr>
    <td>Name :</td> <td> <input type="text" id="txtbox" name="studentname" value="Enter Student Name" title="Enter Student Name"   onfocus="if(this.value == $(this).attr('title')) {
                  this.value = '';
              }" 
                  onblur="
                    if(this.value == '') { 
                        this.value = $(this).attr('title');
                    }" /> </td>

<td> &nbsp;&nbsp;&nbsp;Grand Father Name :</td> <td><input type="text" id="txtbox" name="fgstudentname" value="Enter GFather Name" title="Enter GFather Name"   onfocus="if(this.value == $(this).attr('title')) {
                  this.value = '';
              }" 
                  onblur=" 
                    if(this.value == '') {
                        this.value = $(this).attr('title');
                    }" /> </td>
</tr>
</table>
</fieldset> 
</br>
<fieldset>
<table>
<tr> <td colspan="2"> <input type="checkbox" name="workingprogramme" value="workingprogramme"> Show Students only in the working programme </td> 
</tr>
<tr> 

</tr>
</table>
</fieldset>
<p class="submit"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="submit" value="Search"> </p>
</form>
</div>