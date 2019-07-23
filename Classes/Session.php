<?php 
class Session
{
	
	protected $sessionId;
	public function __construct(){
		$this->sessionId = session_id();
		return $this;
	}
	public function modifyTempBasket($userId){
	
		$basketTemp = new ProductInBasket($this->sessionId);
		$productsTemp = $basketTemp->showProductsInBasket();
		if (!empty($productsTemp)){
			
			$basketTemp->modifyUserId($userId);		
		}
	}
} 