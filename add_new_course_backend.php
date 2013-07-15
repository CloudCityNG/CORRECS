<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in()){
	Header("Location: index.php");
}
else{
	$db = DatabaseWrapper::getInstance();
	$using_lecturer = initLecturer();
	
}

if(isset($_POST["create"])){

 	$precode  = $_POST["precode"];
 	$code = $_POST["code"];
 	$coursecode = $precode.$code;
 	$name = $_POST["name"];
 	$units = $_POST["units"];
 	$status = $_POST["status"];
 	$level;
 	$semester = $_POST["semester"];
 	$description = $_POST["description"];
 	$lecturer = $_POST["lecturer"];
 	$programme = $_POST["programme"];
 	$department = $using_lecturer->deptId;
 	$college = $using_lecturer->collegeId;
 	$code_regExp = "([a-zA-Z]{3,3})";
 	$check_previous = $db->query("select * from courses where code = '{$coursecode}' and programmeId = '{$programme}' and departmentId = '{$department}';", "select");
 	
 	if(!empty($check_previous)){
 		$error_array[] = "A course with the same code, department and programme has already been created";
 	}
 	if(empty($precode) || empty($code)){
 		$error_array[] = "Please Input the course code fields completely, the first field for the alphabetic part and the other for the numbers";
 	}
 	
 	elseif(!preg_match($code_regExp, $precode)){
 		$error_array[] = "Please input a valid alphabetic code in the alphabetic area";
 	}
 	elseif(!is_numeric($code) || ($code > 999) || ($code < 100)){
 		$error_array[] = "Please input a valid numeric code in the numeric area of the course code";
 	}
 	if(empty($name)){
 		$error_array[] = "Please input a name for the course";
 	}
 	if($units == ""){
 		$error_array[] = "Please select a valid Unit";
 	}
 	
 	if($status == ""){
 		$error_array[] = "Please select the status of the course";
 	}
 	if(empty($description)){
 		$error_array[] = "Please enter a description of the course";
 	}
 	if($semester == ""){
 		$error_array[] = "Please select a semester";
 	} 
 	elseif(($code % 2 == 0) && $semester == 1 ){
 		$error_array[] = "Even course codes are meant only for second semester";
 		
 	}
 	elseif(($code % 2 != 0) && $semester == 2){
 		$error_array[] = "Odd course codes are meant only for first semester";
 	}
 	
 	if(($code >= 101) && ($code < 200)){
 		$level = 100;
 	}
 	elseif(($code >= 201) && ($course < 300)){
 		$level = 200;
 	}
 	elseif(($code >= 301) && ($course < 400)){
 		$level = 300;
 	}
 	elseif(($code >= 401)){
 		$level = 400;
 	}
 	if($lecturer == ""){
 		$error_array[] = "Please select a lecturer to handle the course";
 	} 
 	if($programme == ""){
 		$error_array[] = "Please select a Programme";
 	}
 	
 	if($level == ""){
 		$error_array[] = "Please select a level";
 	}
 	
 
 	
if(empty($error_array)){
	$lecturer = $_POST["lecturer"];
	$programme = $_POST["programme"];
	$update = $db->query("insert into courses values (?,?,?,?,?,?,?,?,?,?,?,?);", $coursecode, $name, $units, $status, $level, $semester, $description, $lecturer, $programme, $department, $college, null, "insert");
	if($update){
	$error_messages = FlashMessages::getInstance();
	$type = "notify";
	$key = "course";
	$success_message = "Course Created Successfully <br />";
	$success_message .= "To assign the course a Prerequisite course, go to the course list and click on the course <br />";
	$success_message .= "<a href = \"department_admin_page.php\">Go Back </a>";
	$error_messages->setMessages($success_message, $type, $key);
	header("Location: add_new_course.php");
	}
	else{
		echo "failed";
	}
	
}
else{
	$error_messages = FlashMessages::getInstance();
	$type = "error";
	$key = "course";
	$error_messages->setMessages($error_array, $type, $key);
	header("Location: add_new_course.php");
}
 }
 ?>
