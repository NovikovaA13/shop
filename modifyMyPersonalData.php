<?php
include('biblioPOO.php');

if (isset($_SESSION['userId'])) {
	
	$content = '<a href="changePassword.php\">Change password</a>';
	$select = '';
	$errorLogin = '';
	$errorMail = '';
	
	$infoUser = new User($_SESSION['login']);
		
		$login = $infoUser->getLogin();
		$name = $infoUser->getName();
		$surname = $infoUser->getSurname();
		$dateBirthday = $infoUser->getDateBir();
		$mail = $infoUser->getEmail();
		$adresse = $infoUser->getAdresse();
		$town = $infoUser->getTown();
		$country = $infoUser->getcountryId();
		

	if ((!empty($_POST['submit']))) {
	
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$dateBirthday = $_POST['dateBirthday'];
		$email = $_POST['mail'];
		$adresse = $_POST['adresse'];
		$town = $_POST['town'];
		$country = $_POST['country'];
		$resUpdateUser = $infoUser->updateUser($name, $surname, $dateBirthday, $email, $adresse, $town, $country);
							if ($resUpdateUser) {
								$_SESSION['message'] = [
									'text' => 'Change is successfully!', 
									'status' => 'primary'
								];
								
							}
		}
	$paging = '';	
	$select = $infoUser->showSelectCountry($infoUser->getCountryId());
	$title = 'Modyfy Your Personal Data';
	ob_start();
	include('assets/elems/formEdit.php');
	$content .= ob_get_clean();
	include('assets/elems/layout.php');

}
else { 		
	$_SESSION['message'] = [
				'text' => "This page only for registered users!", 
				'status' => "warning"
				];
	header("Location: login.php") or die();
}
?>