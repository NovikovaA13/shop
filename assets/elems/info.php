<?php 
if (isset($_SESSION['message'])) {
	$status=$_SESSION['message']['status'];
	$text=$_SESSION['message']['text'];
	echo "<div class=\"alert alert-$status\" role=\"alert\">$text</div>";
	unset($_SESSION['message']);
}