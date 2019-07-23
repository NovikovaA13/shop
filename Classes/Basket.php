<?php 
class Basket{
	
	protected $productId;
	protected $quant;
	protected $userId;
	
	public function __construct($userId){
		
		$this->userId = $userId;
		return $this;
	}
	public function modifyUserId($userId){
		
		$sqlModifyUserId = new SQL();
		$sqlModifyUserId->update('product_user', ["userId" => $userId], "userId=\"{$this->userId}\"");
		
	}
	public function addToBasket($productId, $quant = 1){
		$this->productId = $productId;
		$this->quant = $quant;
		$this->save();		
		return $this;
	}
	private function save(){
		$this->clearBasket();
		$sql = new SQL();
		$sql->insert('product_user', ['productId' => $this->productId, 'quant' => $this->quant, 'userId' => $this->userId]);
		return $this;
	}
	public function deleteBasketByproductId($deleteIdProduct){
		$delete = new SQL();
		$result = $delete->deleteFromTable('product_user', "userId=\"{$this->userId}\" AND productId=$deleteIdProduct");
		return $result;
	}
	public function deleteALL(){
		$delete = new SQL();
		$result = $delete->deleteFromTable('product_user', "userId=\"{$this->userId}\"");
		return $result;
	}
	public function clearBasket(){
		$delete = new SQl();
		$delete->deleteFromTable('product_user', "userId=\"{$this->userId}\" AND productId={$this->productId}");
		
	}
	public function deleteBasket(){
		$delete = new SQl();
		$delete->deleteFromTable('product_user', "userId=\"{$this->userId}\"");
		
	}

	
	public function updateBasketQuant($quant){
		$this->quant = $quant;
		$result = $this->save();
		return $result;
	}
	public static function createNewBasket($userId, $productId, $quant = 1){
		
		$insertNewBasket = new SQl();
		$insertNewBasket->insert('product_order', ['id_product' => $productId, 'quant' => $quant, 'id_user' => $userId]);
		
		
	}
}