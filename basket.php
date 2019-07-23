<?php
include('biblioPOO.php');
$content = '';
$products_InBasket = [];

if (isset($_SESSION['userId'])){
	$userId = $_SESSION['userId'];
	
}
else {
	$sessionId = session_id();
	$userId = $sessionId;
	
}

if (isset($_GET['productIdQuant'])){
	$productIdQuant = $_GET['productIdQuant'];
	$quant = $_GET['quant'];
	$updateBasket = new Basket($userId);
	$updateBasket->addToBasket($productIdQuant);
	$resultUpdateQuant = $updateBasket->updateBasketQuant($quant);
	
	if ($resultUpdateQuant){
		$_SESSION['message'] = [
								'text' => 'Quantity of the Product is modified succesfully', 
								'status' => 'primary'
								];
	}
}
if (isset($_GET['delete_Id'])){
			$deleteId = $_GET['delete_Id'];
			$basketDelete = new Basket($userId);
			$result = $basketDelete->deleteBasketByproductId($deleteId);
							
			
			if ($result){
				$_SESSION['message'] = [
									'text' => 'Product is deleted from your Basket succesfully', 
									'status' => 'primary'
									];
			}
			else {
				$_SESSION['message'] = [
									'text' => 'Anything\'s is wrong', 
									'status' => 'error'
									];
			}
					
			
}

if (isset($_POST['buynow'])){
	if (isset($_SESSION['auth'])){		
		header('Location: commandment.php') or die();
	}
	else {
		 $_SESSION['message'] = [
				'text' => 'Before payement, log in, please!', 
				'status' => 'danger'
				];
	header('Location: login.php') or die();
	}
	
	
}
if(isset($_GET['id'])){
		
		$productId = $_GET['id'];
		$basket = new Basket($userId);
		$basket->addToBasket($productId);
		$product = new Product($productId);
		$name = $product->getName();
		$content .= "<div class=\"alert alert-primary\" role=\"alert\">The product <b>$name #$productId</b> is added to your basket!</div>";
		
		
			
	}
	

	$cookie = new Cookie();
	$newBasket = $cookie->verifyExistedBasket();
	if(isset($newBasket)){
		$newBasket->modifyUserId($userId);
	}
	
	$productInBasket = new ProductInBasket($userId);
	$content .= $productInBasket->showProductsInBasket();
	
	$title = 'Your basket';
	include('assets/elems/layout.php');