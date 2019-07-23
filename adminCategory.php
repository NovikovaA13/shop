<?php
include('biblioPOO.php');

	
if (!empty($_SESSION['status']) && ($_SESSION['status'] == 'admin')) {
	$userId = $_SESSION['userId'];
	$content = '';
	if (isset($_GET['delete_Id'])) {
			$deleteIdTest = $_GET['delete_Id'];
			$testDelete = new Test($deleteIdTest);
			$reqDeleteTest = $testDelete->deleteTest();
			
			if ($reqDeleteTest) {
					$_SESSION['message'] = [
										'text' => 'Test is deleted succesfully', 
										'status' => 'primary'
										];
				}
				else {
					$_SESSION['message'] = [
										'text' => 'Anithyng is wrong', 
										'status' => 'danger'
										];
				}
	}
		
	if (!isset($_GET['id'])) {
		$menu = new Menu();
		$content = $menu->showAdminMenuTest();
		
	
}
else {
		$subTestId = $_GET['id'];
	
	//delete
		
	
		$adminTest = new Menu();
		$content .= $adminTest->showAdminMenu($subTestId);
		

}
	

	$title = 'ADMIN Tests';
	
	include('assets/elems/layout.php');

}
else {
	$_SESSION['message'] = [
					'text' => 'This Page only for admins!', 
					'status' => 'danger'
					];
	header('Location: login.php'); die();
}