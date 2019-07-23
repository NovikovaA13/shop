<?php 
class Cookie
{
	
	public function set_Cookie($varCoookie){
		setcookie('basket', 'session_id');
	}
	public function verifyExistedBasket(){
		
		if(isset($_COOKIE['PHPSESSID'])){
			
		$newBasket = new Basket($_COOKIE['PHPSESSID']);
		if ($newBasket instanceOf Basket)
				return $newBasket;
		
		}
	}
	
	
}