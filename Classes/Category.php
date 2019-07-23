<?php
class Category
{
	
	protected $id;
	protected $name;
	protected $tableName;
	
	public function __construct($id, $tableName){
		
		$this->tableName = $tableName;
		$sql = new SQL();
		$data = $sql->selectOneLine($this->tableName, ['id' => $id]);
		$this->name = $data['title'];
		return $this;
		
	}
	
	public function getName(){
		
		return $this->name;
		
	}
}