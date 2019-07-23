<?php
include('biblioPOO.php');
if (isset($_SESSION['userId'])) {
	
	$content = '';
	$user = new User($_SESSION['userId']);
	if($user) {
		
		if ((!empty($_POST['submit']))) {
			
			$resultPassword = $user->updatePassword($_POST['oldpassword'], $_POST['newpassword']);
			if ($resultPassword){
				$_SESSION['message'] = [
							'text' => 'Password is chanded succesfully!', 
							'status' => "success"
							];
			}
			else{
				$_SESSION['message'] = [
							'text' => 'Password current is wrong!', 
							'status' => 'danger'
							];
			}
			
		}
		
	}
	$paging = '';	
	$title = 'Change Your Password';
	ob_start();
	include('assets/elems/formChangePassword.php');
	$content .= ob_get_clean();
	include('assets/elems/layout.php');
}
else {		
		$_SESSION['message'] = [
				'text' => 'Page is only for registered users!', 
				'status' => 'error'
				];
		header('Location: login.php') or die();
}