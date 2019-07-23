<?php 
class Order
{
		
	protected $orderId;
	protected $status;
	protected $dateRegistration;
	protected $dateShipping;
	protected $userId;
	protected $sumTotal;
	
	public function __construct($orderId){
		$this->orderId = $orderId;
		$select = new SQL();
		$data = $select->selectOneLine('orders', ['id' => $this->orderId]);
		$this->status = $data['status'];
		$this->userId = $data['userId'];
		$this->dateRegistration = $data['dateRegistration'];
		$this->sumTotal = $data['sumTotal'];
		return $this;
	
	}
	public function getAllProduct(){
		$sql = new SQL();
		$data = $sql->selectWithCondition('order_product', "orderId = {$this->orderId}");
		return $data;
	}
	
	public function getStatus(){
		return $this->status;
	}
	public function getUserId(){
		return $this->userId;
	}
	public function getDateRegistration(){
		return $this->dateRegistration;
	}
	public function getDateShipping(){
		// return $this->dateShipping;
	}
	public function getSumTotal(){
		return $this->sumTotal;
	}

	public static function insertOrder($userId){
		
		$sql = new SQL();
		$dateRegistration = $sql->getTime()['NOW()'];
		$sql->insert('orders', ['userId' => $userId, 'dateRegistration' => $dateRegistration]);
		$lastInsertId = $sql->getLastInsertId(); 
		return $lastInsertId;
	}
	
	public static function showOrders($userId, $status){
		$content = '';
		$sqlOrders = new SQL();	
		$reqOrders = $sqlOrders->selectWithCondition('orders', "status = $status AND userId = $userId");	
		
		if (!empty($reqOrders)){
			if ($status == 1){
				$content .= "<div><h3>Currents Orders</h3></div>";
			}
			elseif ($status == 2){
				$content .= "<div><h3>Completed Orders</h3></div>";
			}
			
			foreach($reqOrders as $thisOrder){
				$order = new Order($thisOrder['id']);
				
				$dateReg = $order->getDateRegistration();
				$dateShipping = date('Y-m-d', strtotime('Tomorrow'));
				$sumTotal = $order->getSumTotal();
				$content .= "<div><h4>Your order #$thisOrder[id] is confirmed at $dateReg and ";
				if ($status == 1){
					$content .= "must be payed ";
				}
				elseif ($status == 2){
					$content .= "was payed ";
				}
				$content .= "$sumTotal $ while shipping at $dateShipping.</h4>";

				
				$customer = new User($_SESSION['userId']);
				$adresse = $customer->getAdresse();
				$town = $customer->getTown();
				if ($status == 1){
					$content .= "<p>It will be shipped ";
				}
				elseif ($status == 2){
					$content .= "<p>It was shipped ";
				}
				$content .= "at $dateShipping to $adresse, $town.</p>";
				$content .= "<table><th colspan=3>Products Of this Order In Detail: </th>";
		
				$reqCurrentsProducts = $order->getAllProduct();
				
				foreach ($reqCurrentsProducts as $currentProduct){
					$product = new Product($currentProduct["productId"]);
					$image = $product->getImage();
					$name = $product->getName();
					$price = $product->getPrice();
					$content .= "<tr><td><img src=\"images1/$image\" class=\"smallimage\"></td><td>$name</td><td>Quantity: $currentProduct[quant]<td><mark>$price$</mark></td></tr>";
				}
				
				$content .= '</table></div><hr>';
				
				
			}
		}
		return $content;
	}
	public static function createNewOrder($userId){
		$sql = new SQL();
		$sql->insert('orders', ['userId' => $userId]);
		$lastInsertId = $sql->getLastInsertId();
		return $lastInsertId;
	}		
}