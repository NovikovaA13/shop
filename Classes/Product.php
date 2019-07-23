<?php 
class Product 
{

	protected $productId;
	protected $subCategoryId;
	protected $name;
	protected $price;
	protected $info;
	protected $image;
	
	
	
	
	public function __construct($id){
		$select = new SQL();
		$this->productId = $id;
		$data = $select->selectOneLine('product', ['id' => $this->productId]);
		$this->subCategoryId = $data['subCategoryId'];
		$this->name = $data['name'];
		$this->price = $data['price'];
		$this->info = $data['info'];
		$this->image = $data['image'];
		return $this;
	
	}
	public function getName(){
		
		return $this->name;
	}
	public function getPrice(){
		
		return $this->price;
	}
	public function getInfo(){
		
		return $this->info;
	}
	public function getCategory(){
		
		return $this->subCategoryId;
	}
	public function getImage(){
		
		return $this->image;
	}
	public function getProductId(){
		
		return $this->productId;
	}
	
	public function deleteProduct(){
		$sqlDelete = new SQL();
		$result = $sqlDelete->deleteFromTable('product', "id={$this->productId}");
		return $result;
	}
	public function modifyProduct($name, $price, $info, $subCategoryId){		
	
		$img = new Image();
		$imageUploaded = $img->upload();
		if (is_string($imageUploaded)){
			$fileName = $imageUploaded;		
			$sqlUpdateProduct = new SQL();
			$reqModifyProduct = $sqlUpdateProduct->update('product', [		'name' => $name,
																			'price' => $price,
																			'info' => $info,
																			'image' => $fileName,
																			'subCategoryId' => $subCategoryId
																			], "id = {$this->productId}");
			
					if ($reqModifyProduct) {
						$_SESSION['message'] = [
							'text' => 'Product is modified succesfully!', 
							'status' => 'primary'
							];
					}
					
				
				}
				elseif ($imageUploaded = -1){
					$_SESSION['message'] = [
												'text' => 'Image isn\'t moved corretly!', 
												'status' => 'danger'
												];
				}
			
			elseif (is_array($imageUploaded)){
					$_SESSION['message'] = [
											'text' => $imageUploaded[0], 
											'status' => 'danger'
											];
			}
		
		elseif ($imageUploaded = -2){
			$_SESSION['message'] = [
										'text' => 'Image of product isn\'t uploaded correctly', 
										'status' => 'danger'
										];
		}
		
		
	}
	
	public static function createProduct($name, $price, $info, $subcategoryId){	
		
		$img = new Image();
		$imageUploaded = $img->upload();
		
		if (is_string($imageUploaded)){
			$fileName = $imageUploaded;		
			$sqlCreateProduct = new SQL();
			$reqInsertNewProduct = $sqlCreateProduct->insert('product', [ 
																			'name' => $name,
																			'price' => $price,
																			'info' => $info,
																			'image' => $fileName,
																			'subCategoryId' => $subcategoryId
																			]);
			
					if ($reqInsertNewProduct) {
						$_SESSION['message'] = [
							'text' => 'Product is added succesfully!', 
							'status' => 'primary'
							];
					}
					
				
				}
				elseif ($imageUploaded = -1){
					$_SESSION['message'] = [
												'text' => 'Image isn\'t moved corretly!', 
												'status' => 'danger'
												];
				}
			
			elseif (is_array($imageUploaded)){
					$_SESSION['message'] = [
											'text' => $imageUploaded[0], 
											'status' => 'danger'
											];
			}
		
		elseif ($imageUploaded = -2){
			$_SESSION['message'] = [
										'text' => 'Image of product isn\'t uploaded correctly', 
										'status' => 'danger'
										];
		}
		
		
	}
	
}
?>