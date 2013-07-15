<?php
require_once("initialize.php");

class Student {
	public $fname;
	public $lname;
	public $onames;
	public $matricNo;
	public $sex;
	public $deptId;
	public $collegeId;
	public $programmeId;
	public $photograph;
	public $level;
	public $entryYear;
	
	public $modeOfEntry;
	public $id;		
	public $loginId;
	
	public $currentSemester;
	/*public static $studentId = 1001;
	public static $loginId = 101;*/
	public static  $main_table = "student_bio";
 	//db_fields array for instantiating object attributes
	public static $db_fields = array('fname', 'lname','onames', 'matricNo','sex','deptId', 'collegeId', 'photograph', 'level', 'entryYear','modeOfEntry', 'id',  'currentSemester', 'loginId', 'programmeId');
	//public static $db_fields2 = array('loginId', 'loginType', 'id', 'password');
	public $primaryKey;
	
	public $table_name = "student_profile";
	
	function __construct(){
		
	}

	public static function incrementStudentId(){
		self::$studentId = self::$studentId + 1;
		return self::$studentId;
	}
	public static function incrementLoginId(){
		self::$loginId = self::$loginId + 1;
		return self::$loginId;
	}
	public static function authenticate($id, $password){
		//authenticate method
		$db = DatabaseWrapper::getInstance();
		$is_user = $db->query("select * from login where id = '{$id}' and password = '{$password}' and loginType = 'student';", "select");
		return !empty($is_user)? array_shift($is_user) : false;
		
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

	public static function find_by_id ($id){
		$db = DatabaseWrapper::getInstance();
		$result_array = $db->query("select * from student_info where id = '{$id}' ;", "select");
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	public static function find_by_matricNo ($matric){
		$db = DatabaseWrapper::getInstance();
		$result_array = $db->query("select * from student_info where matricNo = '{$matric}' ;", "select");
		return !empty($result_array) ? array_shift($result_array) : false;
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
	
	public function fullName(){
		echo $this->fname . " " . $this->lname;
	}
	public function create(){
		$db = DatabaseWrapper::getInstance();
		
		$execute = $db->query("insert into student_info values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);", $this->id, $this->lname, $this->fname, $this->onames, $this->matricNo, $this->sex,
		$this->level, $this->modeOfEntry, $this->entryYear, $this->deptId, $this->collegeId, $this->programmeId, $this->photograph, $this->loginId,  $this->currentSemester, "insert");
		if($execute){
			return true;
		}
		else{
			return false;
		}
	}
	public function update(){
		$db = DatabaseWrapper::getInstance();
		$execute = $db->query("update student_info set id=?, lname=?, fname=?,onames=?, matricNo=?, sex=?,level=?,entryLevel=?,modeOfEntry=?,entryYear=?, deptId=?, collegeId=?, programmeId=?, photograph=?, login=?, resultId=?, currentSemester=?
		 where id=? ;",$this->id, $this->lname, $this->fname, $this->onames, $this->matricNo, $this->sex,
		$this->level, $this->entryLevel, $this->modeOfEntry, $this->entryYear, $this->deptId, $this->collegeId, $this->programmeId, $this->photograph, $this->loginId,  $this->resultId, $this->currentSemester, "update");
		if($execute){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function delete(){
		/* nothing much has changed */
		$db = DatabaseWrapper::getInstance();
		$delete = $db->query("delete from student_info where id=? LIMIT 1;", $this->id, "delete");
		if($delete){
			return true;
		}
		else{
			return false;
		}
		
	}
	
	
}
