<?php
session_start();
require_once("includes/initialize.php");
if(isset($_POST["submit"])){
 	$department = $_POST["department"];
 	$lecturer = $_POST["lecturers"];
 	$error_array = array();
 	if($department == ""){
 		$error_array[] =  "Please select a Department ";
 	}
 	if($lecturer == ""){
 		$error_array[] =  "Please select a Lecturer ";
 	}
 	if(empty($error_array)){
 		$hod = $db->query("select fname, lname from lecturers where id = '{$lecturer}';", "select");
 		$hod_fullname = $hod[0]["fname"] . " ". $hod[0]["lname"];
 		
 		$update = $db->query("update departments set HOD = ?, hodId = ? where deptId = ?;", $hod_fullname, $lecturer, $department,"update" );
 		
 		if($update){
 			$error_messages = FlashMessages::getInstance();
			$type = "notify";
			$key = "HOD";
			$success_message  =  "HOD has been assigned successfully <br />";
 			$success_message.= "<a href = \"superuser_homepage.php\">Go back</a>";
			$error_messages->setMessages($success_message, $type, $key);
			Header("Location: assign_hod.php");
		}
		else{
 			
 			echo "Operation Failed";
 		}
 	}
 	else{
 		$error_messages = FlashMessages::getInstance();
		$type = "error";
		$key = "HOD";
		$error_messages->setMessages($error_array, $type, $key);
		Header("Location: assign_hod.php");
 	}
 }
 
 ?>