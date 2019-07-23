<?php
include('biblioPOO.php');

if (!empty($_POST['submit'])) {

	$dateRegistration = date('Y-m-d H:i:s');
	$login = $_POST['login'];
	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$password = $_POST['password'];
	$confirm = $_POST["confirm"];
	$dateBirthday = $_POST['dateBirthday'];
	$mail = $_POST['mail'];
	$adresse = $_POST['adresse'];
	$town = $_POST['town'];
	$country=$_POST['country'];
	$errorLogin = '';
	$errorPassword = '';
	$errorMail = '';
	$errorAdresse = '';
	$errorTown = '';
	if (($_POST['password'] == $_POST['confirm'])){
		
		$isLogin = User::verifyLoginExisted($login);
		if (!$isLogin){
			
			if (preg_match("#^[ A-Za-z0-9]{4,10}$#", $_POST['login']) == 0){
				
				$errorLogin = 'Login must be latin 4-10 characters';
				
			}
				 elseif(preg_match("#[A-Za-z0-9]{4,10}#", $_POST['password']) == 0){
					
					$errorPassword = '<kbd>Password must be latin 4-10 characters</kbd>';
				}
					 elseif(preg_match("#^[-._A-Za-z0-9]*@[-_A-Za-z0-9]*\.[-_A-Za-z0-9]{2,4}$#", $_POST['mail']) == 0){
						
						$errorMail = '<kbd>Incorrect email</kbd>';
					} 
						elseif(preg_match("#^[ -._A-Za-z0-9*]{2,100}$#", $_POST['adresse']) == 0){
						
							$errorAdresse = '<kbd>Incorrect adresse</kbd>';
						}
						elseif(preg_match("#^[ -._A-Za-z0-9*]{2,100}$#", $_POST['town']) == 0){
						
							$errorTown = '<kbd>Incorrect town</kbd>';
						}
						else {
							$hashPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
								
								$lastInsertedId = User::createNewUser($login, $name, $surname, $hashPassword, $dateBirthday, $mail, $dateRegistration, $adresse, $town, $country); 
							
							if ($lastInsertedId) {
								$userId = $lastInsertedId;
								$user = new User($userId);
								$_SESSION['auth'] = true;
								$_SESSION['userId'] = $userId;
								$_SESSION['login'] = $login;
								$_SESSION['status'] = $user->getStatus();
								// basket
								$session = new Session();
								$session->modifyTempBasket($userId);
								
								$_SESSION['message'] = [
									'text' => 'Your are registered succesfully!', 
									'status' => 'primary'
									];
								header('Location: basket.php'); die();
							 }
						}
					}
			else{		$_SESSION['message'] = [
					'text' => 'This login is already exist', 
					'status' => 'danger'
					];
		}
	} else {$_SESSION['message'] = [
				'text' => 'Confirm your password', 
				'status' => 'danger'
				];
	}
	
} else {
	
	$login = '';
	$name = '';
	$surname = '';
	$password = '';
	$confirm = '';
	$dateBirthday = '';
	$mail = '';
	$country = '';
	$adresse = '';	
	$town = '';	
	$errorLogin = '';
	$errorPassword = '';
	$errorMail = '';
	$errorAdresse = '';
	$errorTown = '';
}
$paging = '';
$select = User::showSelectCountry();
$title = 'Create Account';
ob_start();
include('assets/elems/formRegister.php');
$content = ob_get_clean();
include('assets/elems/layout.php');