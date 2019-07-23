<?php
class OrderProduct
{
	protected $orderId;
	protected $quant;
	protected $productId;
	protected $content;

	public function __construct($newOrderId = null){
		$this->content = '';
		$this->orderId = $newOrderId;
		return $this;
	
	}
	public function addProducts($quant, $productId){
		
		$this->quant = $quant;
		$this->productId = $productId;
		return $this;

	
	}
	private function save(){
		$sql = new SQL();
		$result = $sql->insert('order_product', ['orderId' => $this->orderId, 'quant' => $this->quant, 'productId' => $this->productId]);
		return $result;
	}
	public function updateOrder($status, $sumTotal){
		$sql = new SQL();
		$result = $sql->update('orders', ['status' => $status, 'sumTotal' => $sumTotal], "Id = {$this->orderId}");
		return $result;
	}
	
}