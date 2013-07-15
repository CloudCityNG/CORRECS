<?php
require_once("initialize.php");
class Lecturer{
	public $id;
	public $fname;
	public $lname;
	public $onames;
	public $photograph;
	public $deptId;
	public $collegeId;
	public $yearEmployed;
	public $loginId;
	public static $db_fields = array('fname', 'lname','onames','deptId', 'collegeId', 'photograph', 'yearEnrolled', 'id', 'loginId');
	public static function authenticate($id, $password){
		//authenticate method
		$db = DatabaseWrapper::getInstance();
		$is_user = $db->query("Select * from login where id = '{$id}' and password = '{$password}' and loginType = 'lecturer';", "select");
		return !empty($is_user)? array_shift($is_user) : false;
		
	}
	private function has_attribute($attribute) {
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  	$object_vars = $this->attributes();
		return array_key_exists($attribute, $object_vars);
	}

	protected function attributes() { 
		// return an array of attribute names and their values
	    $attributes = array();
		foreach(self::$db_fields as $field) {
			if(property_exists($this, $field)) {
	      		$attributes[$field] = $this->$field;
			}
		}
	  return $attributes;
	}
	
	public static function instantiate($record) {
		// Could check that $record exists and is an array
    $object = new self;
		
		//dynamic, short-form approach:
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	public function fullName(){
		echo $this->fname . " " . $this->lname;
	}
	
	
	
}
?>