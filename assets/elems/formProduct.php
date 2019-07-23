<form action="" method="POST" enctype="multipart/form-data">
	Name:     <br><br><input type='text' name="name" value="<?=$name?>"><br><br>
	Price	<br><br><input type="number" name="price" value="<?=$price?>"><br><br>
	Info:     	<br><br><input type='text' name="info" value="<?=$info?>"><br><br>
	SubCategory:	<br><br>

	<?php
if(!empty($select))
echo $select;
	?><br><br>
	<input type="file" name="fileToUpload"><br><br>
	<input type="submit" name="submit">
</form>

