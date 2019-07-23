<?php
class ProductInBasket
{
	
	protected $content;
	protected $userId;
	
	public function __construct($userId){
		$this->content = '';
		$this->userId = $userId;
		return $this;
	}
	public function modifyUserId($userId){
		
		$sqlModifyUserId = new SQL();
		$sqlModifyUserId->update('product_user', ["userId" => $userId], "userId=\"{$this->userId}\"");
		
	}
	public function showProductsInBasket(){
		
		$productsInBasket = [];
		$quantities = [];
		$sqlProductsForBasket = new SQL();
		$productsForBasket = $sqlProductsForBasket->selectWithCondition('product_user', "userId=\"{$this->userId}\"");
		if(!empty($productsForBasket)){
			foreach ($productsForBasket as $row){
				$productsInBasket[] = $row['productId'];
				$quantities[] = $row['quant'];
				
			}
		}
	

		if(!empty($productsInBasket)){
			$this->content .= '<table>';
			for ($i = 0; $i < count($productsInBasket); $i++){
			
				$productInBasket = new Product($productsInBasket[$i]);
				$image = $productInBasket->getImage();
				$name = $productInBasket->getName();
				$price = $productInBasket->getPrice();
				$this->content .= "<tr><td><img src=\"images1/$image\" class=\"smallimage\"></td><td>$name</td><td>$price $</td>";
				
				$this->content .= "<td><div class=\"dropdown\">
					<button class=\"btn btn-primary dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\">$quantities[$i]</button>
					<ul class=\"dropdown-menu\">";
					  for ($j = 1; $j <= 5; $j++){
						 
					  $this->content .=  "<li><a href=\"basket.php?productIdQuant=$productsInBasket[$i]&quant=$j\">$j</a></li>";
					  }
				
				 
				$this->content .= '</ul></div></td>';
				$this->content .= "<td><a href=\"?deleteId=$productsInBasket[$i]\"><img src=\"assets/glyph-iconset-master/png/trash.png\" class=\"gliph\"></a></td></tr>";
			}
			$this->content .= '</table>';	
		}
		
		else{
			$this->content .= '<div>Your basket is empty!</div>';
		}
			$this->content .= "<div class=\"padding\">
						<form method=\"POST\">
						 <a href=\"index.php\" type=\"sumbit\" class=\"btn btn-primary btn-lg padding left\" name=\"continueshopping\">CONTINUE SHOPPING</a>
						 <button type=\"sumbit\" class=\"btn btn-primary btn-lg padding right\" name=\"buynow\">Buy NOW</button>
						</form>
						</div>";
		
		return $this->content;
	}
	public function showProductInCommandement(){
		
		$sqlProductsForBasket = new SQL();
		$allProducts = $sqlProductsForBasket->selectWithCondition('product_user', "userId = {$this->userId}"); 
		
		$this->content .= '<table>';
		$sumTotal = 0;
		foreach ($allProducts as $productInCommandement){
			$product = new Product($productInCommandement["productId"]);
			$name = $product->getName();
			$image = $product->getImage();
			$price = $product->getPrice();
			$quant = $productInCommandement["quant"];
		
			$this->content .= "<tr><td><img src=\"images1/$image\" class=\"smallimage\"></td><td>$name</td><td>Quantity: $quant<td><mark>$price $</mark></td></tr>";
			$sumTotal += $price * $quant;
			}
			
		$this->content .= "<tr><td colspan=5 class=\"bg-primary\">Total to pay $sumTotal $</td><tr>";
		$this->content .= '</table>';
		$this->content .= "<div class=\"padding\">
				<form method=\"POST\">
				 <a href=\"index.php\" type=\"sumbit\" class=\"btn btn-primary btn-lg padding left\" name=\"continueshopping\">RETOURN TO SHOPPING</a>
				 <button type=\"sumbit\" class=\"btn btn-primary btn-lg padding right\" name=\"payNow\">BUY NOW</button>
				</form>
				</div>";
		return $this->content;
	}
	public function payNow($newOrderId){
		
		$sqlProductsFromBasket = new SQL();
		$reqProductsFromBasket = $sqlProductsFromBasket->selectWithCondition('product_user', "userId = {$this->userId}");
		$sumTotal = 0;
		
		foreach ($reqProductsFromBasket as $productFromBasket){
			$quant = $productFromBasket["quant"];
			$productId = $productFromBasket["productId"];
			$product = new Product($productId);
			$price = $product->getPrice();
			$orderProduct = new OrderProduct($newOrderId);
			$orderProduct->addProducts($quant, $productId);			
			$result = $orderProduct->save();
			$sumTotal += $price * $quant;
											
		
	}
	$sqlModifyOrder = new OrderProduct($newOrderId);
	$sqlModifyOrder->updateOrder(1, $sumTotal);
	
	
	$sqlDeleteFromBasket = new Basket($this->userId);
	$sqlDeleteFromBasket->deleteALL();
	
	}
}