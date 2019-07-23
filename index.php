<?php
include('biblioPOO.php');

	if (isset($_GET['page']))
		$page = $_GET['page'];
	else $page = '/';


if (!isset($_GET['page'])) { 
	$page = 1;
}
else {
	$page = $_GET['page'];
}



$numberOfLines = 6;

$index = new Paging ($numberOfLines, $page, 'product');

$content = $index->showPage();
$paging = $index->showPaging();




	$title = 'SHOP';

include('assets/elems/layout.php');
