<?php
include('biblioPOO.php');

	
if (!empty($_SESSION['status']) && ($_SESSION['status'] == 'admin')) {
	
	
	if (isset($_GET['modifyProductId'])) {	//modify existed product
		
		$product = new Product ($_GET['modifyProductId']);
		
		if (isset($_POST['name']))
			$name = $_POST['name'];
		else $name = $product->getName();
		if (isset($_POST['price']))
			$price = $_POST['price'];
		else $price = $product->getPrice();
		if (isset($_POST['info']))
			$info = $_POST['info'];
		else $info = $product->getInfo();
		if (isset($_POST['subcategory']))
			$subCategoryId = $_POST['subcategory'];
		else $subCategoryId = $product->getCategory();
			
	
	}
else {//create new product
		if (isset($_POST['name']))
			$name = $_POST['name'];
		else $name = '';
		if (isset($_POST['price']))
			$price = $_POST['price'];
		else $price = '';
		if (isset($_POST['info']))
			$info = $_POST['info'];
		else $info = '';
		if (isset($_POST['subcategory']))
			$subCategoryId = $_POST['subcategory'];
		else $subCategoryId = '';
	
	}
	
	$select = '';
	$menuSubcategory = new Menu();
	$select = $menuSubcategory->showSelectSubcategory();
	

	if (!empty($_POST['submit'])) {
		if (isset($_GET['modifyProductId'])) {
			
			$product->modifyProduct($name, $price, $info, $subCategoryId);
		}
		else{
		
			$productCreatedId = Product::createProduct($name, $price, $info, $subCategoryId);
		}
	}
	

	ob_start();
	include('assets/elems/formProduct.php');
	$content = ob_get_clean();

	$title = 'ADMIN, MODIFY PRODUCTS';
	
	include('assets/elems/layout.php');

}
else {
	$_SESSION['message'] = [
					'text' => 'This Page only for admins!', 
					'status' => 'danger'
					];
	header('Location: login.php'); die();
}