<?php
include('biblioPOO.php');

	
if (!empty($_SESSION['status']) && ($_SESSION['status'] == 'admin')) {
		$userId = $_SESSION['userId'];
		$userLogin = $_SESSION['login'];
		$content = '';
		//delete
		if (isset($_GET['delete_Id'])) {
		$deleteId = $_GET['delete_Id'];
		$deleteUser = new User($deleteId);
		$result = $deleteUser->deleteUser();
	
		if ($result) {
			$_SESSION['message'] = [
									'text' => 'User is deleted succesfully', 
									'status' => 'primary'
							];
			}
		}
		//status
		if (isset($_GET['changeStatus'])) {
			
		$statusUserId = $_GET['changeStatus'];
		$user = new User($statusUserId);
		
		$reqUpdateUserStatus = $user->changeStatus();
			if ($reqUpdateUserStatus)
			$_SESSION['message'] = [
							'text' => 'User\'s status is modified succesfully!', 
							'status' => 'primary'
							];
			
		}
				//baned
		if (isset($_GET['bannedId'])) {
		$userBannedId = $_GET['bannedId'];
		$userBanned = new User($userBannedId);
		$reqUpdateBanStatus = $userBanned->changeStatusBanned();
		var_dump($reqUpdateBanStatus);
		if ($reqUpdateBanStatus)
			$_SESSION['message'] = [
									'text' => 'User\'s ban is modified succesfully!', 
									'status' => 'primary'
									];
		
			
		}
		
	$table = new Menu();
	$content .= $table->showAdminUsersPage($userId);
	$title = 'ADMIN LISTE USERS';
	
	include('assets/elems/layout.php');
}
else {
	$_SESSION['message'] = [
					'text' => 'This Page only for admins!', 
					'status' => 'danger'
					];
	header('Location: login.php'); die();
}