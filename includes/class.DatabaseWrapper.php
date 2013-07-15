<?php 
require_once("includes/config.php");
class DataBaseWrapper {
	public static $_instance = null;
	public $_db;
	
	private function __construct(){
		try{
			//create a connection to MySQL and select a database;
			$dsn = 'mysql:host='.DB_SERVER.';dbname='.DB_NAME;
			$this->_db = new PDO($dsn, DB_USER, DB_PASS);
		}catch (PDOException $e){
			echo "Error : ". $e->getMessage();
		}
		
	}
	
	public static function getInstance() {
		return new DatabaseWrapper();
	}
	//parse and process query strings
	//uses a token that would be passed as the last argument to the function when called to determine if
	//its a select
	public function query(){
		$arguments = func_get_args();
		
		
		$query = $arguments[0];
		$token = $arguments[count($arguments) - 1];
		array_pop($arguments);
		array_shift($arguments);
		$argument = @$arguments[0];
		
		$numArgs = count($arguments);
		
		if($this->_db instanceof PDO) {
			if(!empty($query)){
				if(strtolower($token) == "select"){
					$stmt = $this->_db->prepare($query);
					$stmt->execute();
					if(!$stmt){
						return $this->_db->errorInfo();
					}
					return $stmt->fetchAll();
				}
				elseif(strtolower($token) == "insert"){
					try{
						$stmt = $this->_db->prepare($query);
						if($numArgs >= 1){
							for($i=0; $i < $numArgs; $i++){
							$counter = $i + 1;
							$stmt->bindParam($counter, mysql_real_escape_string($arguments[$i]));
							}
							if($stmt->execute()){
								return true;
							}else{
								var_dump($stmt->errorInfo());
								return false;
							}
						}
						
					}catch(PDOException $e){
						$e->getMessage();
						
					}
				}
				elseif(strtolower($token) == "update"){
					
					try{
						$stmt = $this->_db->prepare($query);
						if($numArgs >= 1){
							for($i = 0; $i < $numArgs; $i++){
								$counter = $i + 1;
								$stmt->bindParam($counter, mysql_real_escape_string($arguments[$i]));
							}
							
							if($stmt->execute($arguments)){
								//var_dump($stmt->errorInfo());
								return true;
							}else{
								var_dump($stmt->errorInfo());
								return false;
							}
							
						}
					}catch (PDOException $e){
						
						$e->getMessage();
					}
				}
				elseif(strtolower($token) == "count") {
					$stmt = $this->_db->prepare($query);
					
					$stmt->execute();
					
					$count = $stmt->fetchAll();
					$count = $count[0][0];
					
					return $count;
				}
				elseif(strtolower($token) == "delete"){
					$stmt = $this->_db->prepare($query);
					$stmt->execute();
					if(!$stmt){
						var_dump($stmt->errorInfo());
						return false;
					}
					else
					return true;
				}
				
				
			}else{
				throw new Exception("Query is Empty");
			}
		}else{
			throw new Exception();
		}
		
		
	}
	
}

 ?>