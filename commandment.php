<?php
include('biblioPOO.php');
$content = '';


if (isset($_SESSION["auth"])){
	if (isset($_SESSION['userId'])){
		
		$userId = $_SESSION['userId'];
	}
}
else { 		
	$_SESSION['message'] = [
				'text' => 'Before payement, log in, please!', 
				'status' => 'danger'
				];
	header('Location: login.php') or die();
}
	
if (isset($_POST['payNow'])){	
	
	$newOrderId = Order::createNewOrder($userId);
 	$productsFromCommandement = new ProductInBasket($userId);
 	$productsFromCommandement->payNow($newOrderId);
	
	header('Location: personalArea.php?commandment=succes') or die();
	
	
	
}
		$productInBasket = new ProductInBasket($userId);
		$content .= $productInBasket->showProductInCommandement();
		

				
	$title = 'Your commandment';
	include('assets/elems/layout.php');