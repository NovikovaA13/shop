<?php
include('biblioPOO.php');

if (isset($_GET['id'])){
	
	$subCategoryId = $_GET['id'];
}
else {
	header ('Location: index.php');
}


if (!isset($_GET['page'])) {
	$page = 1;
}
else {
	$page = $_GET['page'];
}
$numberOfLines = 9;

//listing
$category = new Category($subCategoryId, 'subcategory');
$title = $category->getName();
$listing = new Paging ($numberOfLines, $page, 'product', $subCategoryId, $title);
$content = $listing->showPage();
$paging = $listing->showPaging(); 



include('assets/elems/layout.php');
