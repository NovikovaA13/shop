<form action="" method="POST">
	
	Your name:     	<br><input type='text' name='name' value="<?=$name?>"><br><br>
	Your first name:	<br><input type='text' name='surname' value="<?=$surname?>"><br><br>
	Date of Birth day:<br><input type="date" name='dateBirthday' value="<?=$dateBirthday?>"><br><br>
	Email:<br>      	<?=$errorMail?><input type='mail' name='mail' value="<?=$mail?>"><br><br>
	Adresse:<br>      	<input type='text' name='adresse' value="<?=$adresse?>"><br><br>
	Town:<br>      	<input type='text' name='town' value="<?=$town?>"><br><br>
	Country:<br> 
		<?php
		if(!empty($select)){
			echo $select;
		}
		?>
	<input type="submit" name="submit"><br><br>
	
</form>

