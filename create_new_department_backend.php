<?php
session_start();

require_once("includes/initialize.php");
$db = DatabaseWrapper::getInstance();
 if(isset($_POST["submit"])){
 	$name = $_POST["name"];
 	$college = $_POST["college"];
 	$lecturers = $_POST["lecturers"];
 	$error_array = array();
 	if(empty($name)){
 		$error_array[] = "Please input the name";
 	}
 	if($college == ""){
 		$error_array[] =  "Please select a Department ";
 	}
 	if($lecturers == ""){
 		$error_array[] =  "Please select a Lecturer ";
 	}
 	
 	if(empty($error_array)){
 		$hod = $db->query("select fname, lname from lecturers where id = '{$lecturers}';", "select");
 		
 		$hod_fullname = $hod[0]["fname"] . " ". $hod[0]["lname"];
 		$last_id = $db->query("select (max(deptId) + 1) from departments;", "select");
 		$update = $db->query("insert into departments values (?,?,?,?,?);", $last_id[0][0], $name, $college,$hod_fullname, $lecturers, "update" );
 		
 		if($update){
 			$error_messages = FlashMessages::getInstance();
			$type = "notify";
			$key = "department";
			$success_message  =  "Department created successfully <br />";
 			$success_message.= "<a href = \"superuser_homepage.php\">Go back</a>";
			$error_messages->setMessages($success_message, $type, $key);
			header("Location: create_new_department.php");
		}
		else{
 			
 			echo "Operation Failed";
 		}
 	}
 	else{
 		$error_messages = FlashMessages::getInstance();
		$type = "error";
		$key = "department";
		$error_messages->setMessages($error_array, $type, $key);
		header("Location: create_new_department.php");
 	}
 }
 
 ?>
 <?php 



?>