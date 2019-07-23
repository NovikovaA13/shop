<?php
class Image
{

	protected $errors = [];
	protected $permitedExtensions = ['.jpg', '.JPG', '.jpeg', '.JPEG', '.png', '.PNG', '.gif', 'GIF'];


	public function upload(){
		if ($_FILES['fileToUpload']['error'] == 0){
			
			$target_file = IMAGES .'/'. basename($_FILES['fileToUpload']['name']);
			$fileName = $_FILES['fileToUpload']['name'];
			$fileTmpName = $_FILES['fileToUpload']['tmp_name'];
			$fileSize = $_FILES['fileToUpload']['size'];
			$fileExtension = strrchr($fileName, '.');			
			
			if (!in_array($fileExtension, $this->permitedExtensions))
				$this->errors = ['Allowed are only .jpg, .JPG, .jpeg, .JPEG, .png, .PNG, .gif, GIF'];
			if ($fileSize > 2097152)
				$this->errors = ['Max size allowed is 2 Mb'];
			if (!$this->errors) {
				$imageUploaded = move_uploaded_file($fileTmpName, $target_file);
				if ($imageUploaded){
					
					return $fileName;
				}
				else {
					return -1;
				}
			}
			else{
				$this->errors;
			}
		}
		
		else {
			return -2;
		}
	}
}