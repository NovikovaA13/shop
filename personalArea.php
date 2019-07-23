<?php
include('biblioPOO.php');

if (isset($_SESSION["auth"])) {
	$userId = $_SESSION["userId"];
	$content = '';
	if (isset($_GET['commandment'])) 
		$content .= '<div class="alert alert-primary" role="alert">Your order is confirmed</div>';
	

	$content .= Order::showOrders($userId, 1);
	$content .= Order::showOrders($userId, 2);

	
	
	
	$title = 'Your Personal Area';
	include('assets/elems/layout.php');
} 
else { 		
	$_SESSION['message'] = [
				'text' => 'This page only for registered users!', 
				'status' => 'danger'
				];
	header('Location: login.php') or die();
}
?>