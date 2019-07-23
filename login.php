<?php
require_once("biblioPOO.php");
$content = '';
if ((!empty($_POST['login'])) && (!empty($_POST['password']))) {
	$userId = User::verifyUserLoginPassword($_POST['login'], $_POST['password']);
	
	if($userId > 0){
		$user = new User($userId);
		$_SESSION['auth'] = true;
		$_SESSION['userId'] = $userId;
		$_SESSION['status'] = $user->getStatus();
		$_SESSION['login'] =  $user->getLogin();
		$_SESSION['message'] = [
			'text' => 'Your are logined succesfully!', 
			'status' => 'primary'
			];
		//basket
		$session = new Session();
		$session->modifyTempBasket($userId);
		
		header('Location: basket.php'); die();
	} else {
		
		$_SESSION['message'] = [
			'text' => 'Wrong login or password!', 
			'status' => 'danger'
			];
	}
	
	
	$login = $_POST['login'];
	$password = $_POST['password'];
}
else {

	$login = '';
	$password = '';
	}
	
$paging = '';	
$title = 'Log In User';
ob_start();
include('assets/elems/formLogin.php');
$content .= ob_get_clean();
include('assets/elems/layout.php');
