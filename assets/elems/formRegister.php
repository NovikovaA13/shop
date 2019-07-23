<form action="" method="POST">
	Login:     <br><br>	<?=$errorLogin?><input type='text' name='login' value="<?=$login?>"><br><br>
	Your name:     <br><br><input type='text' name='name' value="<?=$name?>"><br><br>
	Your first name:	<br><br><input type='text' name='surname' value="<?=$surname?>"><br><br>
	Password:     	<br><br><?=$errorPassword?><input type='password' name='password' value="<?=$password?>"><br><br>
	Confirm password:	<br><br><input name="confirm" type='password' value="<?=$confirm?>"><br><br>
	Date of Birth day:	<br><br><input type="date" name='dateBirthday' value="<?=$dateBirthday?>"><br><br>
	Adresse:	<br><br><?=$errorAdresse?><input type='text' name='adresse' value="<?=$adresse?>"><br><br>
	Town:	<br><br><?=$errorTown?><input type='text' name='town' value="<?=$town?>"><br><br>
	Country:	<br><br>

	<?php
if(!empty($select))
echo $select;
	?>
	<br><br>

	Email:<br><br>      	<?=$errorMail?><input type='mail' name='mail' value="<?=$mail?>">
	<br><br><input type="submit" name="submit"><br><br>
</form>

