<div align="center" style="margin:75px;">
<h1 style="margin-bottom:25px;"> Login here </h1> 
<form action=" action="<?php echo url_for('index/dologin') ?>"" method="post">
<label> User name <input type="text" name="user_name" value="" /> </label> <br />
<label> Password: <input type="password" name="password" value="" /> </label> <br /> 
<input type="submit" name="login" value="Login" />

</form>
</div>