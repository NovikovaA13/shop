<?php 
class User
{
	use Country;
	protected $id;
	protected $login;
	protected $statusId;
	protected $statusName;	
	protected $name;
	protected $surName;
	protected $password;	
	protected $dateBirthday;	
	protected $email;	
	protected $dateRegistration;	
	protected $adresse;
	protected $town;
	protected $countryId;
	protected $banned;
	
	public function __construct($id){
		
		$this->id = $id;
		$this->init();
		return $this;
	}
	
	public function getId(){
		
		return $this->id;
	}
	public function getLogin(){
		
		return $this->login;
	}
	public function getStatus(){
		
		$getStatus = new SQL();
		$data = $getStatus->selectOneLine("statuses", ["status_id" => $this->statusId]);
		return $data["status_name"];
	}
	public function getName(){
		
		return $this->name;
	}
	public function getSurName(){
		
		return $this->surName;
	}
	public function getPassword(){
		
		return $this->password;
	}
	public function getDateBir(){
		
		return $this->dateBirthday;
	}
	public function getEmail(){
		
		return $this->email;
	}
	public function getDateReg(){
		
		return $this->dateRegistration;
	}
	public function getAdresse(){
		
		return $this->adresse;
	}
	public function getTown(){
		
		return $this->town;
	}
	public function getcountryId(){
		
		return $this->countryId;
	}
	public function getBanned(){
		
		return $this->banned;
	}
	private function init(){
		$loginSQL = new SQL();
		$data = $loginSQL->selectOneLine('users', ['id' => $this->id]);
		$this->login = $data['login'];
		$this->statusId = $data['status'];		
		$this->name = $data['name'];
		$this->surName = $data['surname'];
		$this->password = $data['password'];
		$this->dateBirthday =  $data['dateBirthday'];
		$this->email =  $data['mail'];
		$this->dateRegistration =  $data['dateRegistration'];
		$this->adresse =  $data['adresse'];
		$this->town =  $data['town'];
		$this->countryId =  $data['country'];
		$this->banned =  $data['banned'];
	}
	public static function verifyUserLoginPassword($login, $password){
		
		
		$sql = new SQL();
		$data = $sql->selectOneLine('users', ["login" => $login]);
		$hashPassword = $data['password'];
		if (($login == $login) && (password_verify($password , $hashPassword))){
			
			return $data['id'];
		}
		else return false;
	}
	public function logOut($login){
		//$logout = new PDO();
		return true;
	}
	public function updateUser($name, $surname, $dateBirthday, $email, $adresse, $town, $country){

		$sqlUpdate = new SQL();
		$result = $sqlUpdate->update('users', ['name' => $name,
														'surname' => $surname,
														'dateBirthday' => $dateBirthday,
														'mail' => $email, 
														'adresse' => $adresse, 
														'town' => $town, 
														'country' => $country],
														"id = {$this->id}");
		$this->init();
		return $result;
	}
	public function updatePassword($oldPassword, $newPassword){
		if (password_verify($oldPassword, $this->password)) {
			
			$hashpassword = password_hash($newPassword, PASSWORD_DEFAULT);
			$sqlUpdatePassword = new SQL();
			$resultPassword = $sqlUpdatePassword->update('users', ['password' => $hashpassword], "id={$this->id}");
			if ($resultPassword){
				
				$this->password = $hashpassword;
				return true;
			}
			
		}
		else {
			
			return false;
		}
	}
	public function deleteUser(){
		$deleteSQL = new SQL();
		$result = $deleteSQL->deleteFromTable('users', "id = {$this->id}");
		return $result;
	}
	public function changeStatus(){
		
		if ($this->statusId == '0'){
			$status = 1;
		}
		elseif ($this->statusId == '1'){
			$status = 0;
		}
		$updateUserStatus = new SQL();
		$reqUpdateUserStatus = $updateUserStatus->update('users', ["status" =>$status], "id={$this->id}");
		return $reqUpdateUserStatus;
	
	}
	public function changeStatusBanned(){
	
		if ($this->banned == 0){
			$userBanStatus = 1;
		}
		elseif ($this->banned == 1){
					$userBanStatus = 0;
		}
					
		$updateBanStatus = new SQL();
		$reqUpdateBanStatus = $updateBanStatus->update('users', ["banned" => $userBanStatus], "id={$this->id}");
		return $reqUpdateBanStatus;
	
	}
	
	public static function createNewUser($login, $name, $surname, $password, $dateBirthday, $mail, $dateRegistration, $adresse, $town, $country){
		$sql = new SQL();
		$result = $sql->insert('users', ['login' => $login,
											  'name' => $name,
											  'surname' => $surname,
											  'password' => $password,
											  'dateBirthday' => $dateBirthday,
											  'mail' => $mail,
											  'dateRegistration' => $dateRegistration,
											  'adresse' => $adresse,
											  'town' => $town,
											  'country' => $country]);
		$lastInsertedId = $sql->getLastInsertId();
		return $lastInsertedId;
	}
											
	public static function verifyLoginExisted ($login){
		$sql = new SQL();
		$result = $sql->selectOneLine('users', ['login' => $login]);
		return $result;
	}

}