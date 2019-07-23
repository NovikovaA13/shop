<?php
include('biblioPOO.php');
session_destroy();

$_SESSION['message'] = [
					'text'=>"Your are anonymus!", 
					'status'=>"success"
					];
header("Location: index.php");
