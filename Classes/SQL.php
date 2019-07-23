<?php
class SQL
{
	//Constants
	
	const HOST = 'localhost';
	// const ROOT = 'root';
	// const PASSWORD = '';
	// const BDDNAME = 'shop';
	const ROOT = 'XXX';
	const PASSWORD = 'XXX';
	const BDDNAME = 'shop';

	private $dns;
	private $PDO;
	

	
	public function __construct(){
		try	{
			$this->dns = "mysql:host=".self::HOST.";dbname=".self::BDDNAME.";charset=utf8;";
			$this->PDO = new PDO($this->dns, self::ROOT, self::PASSWORD);
			$this->PDO->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
			$this->PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			
		}
		catch(PDOException $e){
			echo 'Erreur : '.$e->getMessage().'<br />';
			echo 'N° : '.$e->getCode();
		}
	
	}
	private function parseData($data){
		
		$line = '';
		foreach ($data as $cle => $val){
			
			$line.= " $cle=:$cle,";
			
		}
		$line = substr($line, 0, -1);
		return $line;
	}
	public function insert($tableName, $data){
		
		$line = $this->parseData($data);
		$sql = "INSERT INTO $tableName SET$line";
		$request = $this->PDO->prepare($sql);
		return $request->execute($data);
		
		
	}	
	public function insertIgnore($tableName, $data){
		
		$line = $this->parseData($data);
		$sql = "INSERT IGNORE INTO $tableName SET$line";
		$request = $this->PDO->prepare($sql);
		return $request->execute($data);
		
		
	}
	public function deleteFromTable($tableName, $cond){
		
		$sql = "DELETE FROM $tableName WHERE $cond";
		$request = $this->PDO->prepare($sql);
		return $request->execute();
		
	}
	public function update($tableName, $data, $cond){
		
		$line = $this->parseData($data);
		$sql = "UPDATE $tableName SET$line WHERE $cond";
		$request = $this->PDO->prepare($sql);
		return $request->execute($data);
		
		
	}
	public function updateTime($tableName, $line, $cond){
		
		$sql = "UPDATE $tableName SET $line WHERE $cond";
		$request = $this->PDO->prepare($sql);
		return $request->execute();
		
		
	}
	public function selectOneLine($tableName, $condData, $fields = null){
	
		if(isset($fields)){
		$strFields = $fields;
		}
		else $strFields = '*';
		
		
		$line = $this->parseData($condData);
		$sql = "SELECT $strFields FROM $tableName WHERE$line";
		
		$request = $this->PDO->prepare($sql);
		$request->execute($condData);
		$count = $request->rowCount();
		$result = $request->fetch();
		if ($count > 0){
			return $result;
			
		}
		else return false;
		
	}
	public function selectWithCondition($tableName, $condition, $orders = null, $fields = null){
		
		if(isset($fields)){
			// $strFields = explode(", ", $fields);
			$strFields = $fields;
		}
		else $strFields = '*';
		if(isset($orders)){
			$strOrders = " ORDER BY $orders";
		}
		else $strOrders = '';
		$sql = "SELECT $strFields FROM $tableName WHERE $condition$strOrders";
		$request = $this->PDO->prepare($sql);
		$request->execute();
		$count = $request->rowCount();
		if ($count > 0){
			
			return $request->fetchAll();
			
		}
		else return false;
		
	}	
	public function selectAll($tableName, $fields = null){
		
		if(isset($fields)){
		$strFields = explode(", ", $fields);
		}
		else $strFields = '*';
		$sql = "SELECT $strFields FROM $tableName";
		$request = $this->PDO->prepare($sql);
		$request->execute();
		$count = $request->rowCount();
		if ($count > 0){
			
			return $request->fetchAll();
			
		}
		else return false;
		
		
	}
	public function selectAllWithLimit($tableName, $limits, $orders = null, $fields = null){
		
		if(isset($fields)){
			$strFields = explode(", ", $fields);
		}
		else $strFields = '*';
		if(isset($orders)){
			$strOrders = " ORDER BY $orders";
		}
		else $strOrders = '';
		$sql = "SELECT $strFields FROM $tableName$strOrders LIMIT $limits";
		
		$request = $this->PDO->prepare($sql);
		$request->execute();
		$count = $request->rowCount();
		if ($count > 0){
			
			return $request->fetchAll();
			
		}
		else return false;
		
		
	}
	public function selectWithLimitAndCond($tableName, $limits, $condData, $orders = null, $fields = null){
		
		if(isset($fields)){
			$strFields = explode(", ", $fields);
		}
		else $strFields = '*';
		if(isset($orders)){
			$strOrders = " ORDER BY $orders";
		}
		else $strOrders = '';
		$line = $this->parseData($condData);
		$sql = "SELECT $strFields FROM $tableName WHERE $line$strOrders LIMIT $limits ";
		$request = $this->PDO->prepare($sql);
		$request->execute($condData);
		$count = $request->rowCount();
		if ($count > 0){
			
			return $request->fetchAll();
			
		}
		else return false;
		
		
	}
	public function countLines($tableName, $field = null){
		
		if(isset($field)){
		$fieldCount = explode(", ", $fields);
		}
		else $fieldCount = '*';
		
		$sql = "SELECT COUNT($fieldCount) as count FROM $tableName";
		$request = $this->PDO->prepare($sql);
		$request->execute();
		$count = $request->rowCount();
		if ($count > 0){
			
			$countLines =  $request->fetch();
			return $countLines['count'];
			
		}
		else return false;
		
		
	}public function countLinesWithCond($tableName, $condData, $field = null){
		
		if(isset($field)){
		$fieldCount = explode(", ", $fields);
		}
		else $fieldCount = '*';
		
		$line = $this->parseData($condData);		
		$sql = "SELECT COUNT($fieldCount) as count FROM $tableName WHERE$line";
		$request = $this->PDO->prepare($sql);
		$request->execute($condData);
		$count = $request->rowCount();
		if ($count > 0){
			
			$countLines =  $request->fetch();
			return $countLines['count'];
			
		}
		else return false;
		
		
	}
	public function command($command){
		
		$request = $this->PDO->prepare($command);
		$request->execute();
		$result = $request->fetchAll();
		return $result;		
		
	}

	public function getTime(){
		
		$request = $this->PDO->query("SELECT NOW()");
		$request->execute();
		return $request->fetch();		
		
	}
	public function getLastInsertId(){
		
		return  $this->PDO->lastInsertId();
		
	}
}