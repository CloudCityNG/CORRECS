<?php
session_start();
require_once("includes/initialize.php");
$db = DatabaseWrapper::getInstance();
if(isset($_POST["submit"])){
 	$name = $_POST["name"];
 	$departments = $_POST["department"];
 	$college;
 	$duration = $_POST["duration"];
 	$last_level;
 	$error_array = array();
 	if(empty($name)){
 		$error_array[] = "Please input the name";
 	}
 	if($departments == ""){
 		$error_array[] =  "Please select a Department ";
 	}
 	else{
 		$coll = $db->query("select * from departments where deptId = '{$departments}';", "select");
 		$college = $db->query("select * from colleges where collegeId = '{$coll[0]["collegeId"]}';", "select");
 	}
 	if(empty($duration)){
 		$error_array[] = "Please input duration";
 	}
 	elseif(!is_numeric($duration)){
 		$error_array[] = "please input a numeric duration";
 		
 	}
 	elseif($duration > 7){
 		$error_array[] = "The duration entered exceeds maximum duration";
 	}
 	
 	else{
 		$last_level = $duration * 100;
 	}
 	
 	if(empty($error_array)){
 		$last_programme = $db->query("select (max(programmeId) + 1) from programmes;", "select");
 		
 		$update = $db->query("insert into programmes values(?,?,?,?,?,?);", $last_programme[0][0], $name, $duration, $departments, $college[0]["collegeId"], $last_level, "insert");
 		if($update){
 			$error_messages = FlashMessages::getInstance();
			$type = "notify";
			$key = "programme";
			$success_message  =  "Programme created successfully <br />";
 			$success_message.= "<a href = \"superuser_homepage.php\">Go back</a>";
			$error_messages->setMessages($success_message, $type, $key);
			header("Location: create_new_programme.php");
 		}
 		else{
 			echo "Operation failed;";
 		}
 	}
 	else{
 		$error_messages = FlashMessages::getInstance();
		$type = "error";
		$key = "programme";
		$error_messages->setMessages($error_array, $type, $key);
		header("Location: create_new_programme.php");
 	}
 	
 	
 }
 ?>