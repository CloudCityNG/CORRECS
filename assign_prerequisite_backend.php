<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in() || (!isset($_GET["id"])) || (!isset($_GET["departmentid"]))){
	Header("Location: index.php");
}
else{
	$db = DatabaseWrapper::getInstance();
	$course = $db->query("select * from courses where code = '{$_GET["id"]}' and departmentId = '{$_GET["departmentid"]}';", "select");
	$this_lecturer = initLecturer();
	//$selected_courses = $db->query("select * from courses where departmentId = '{$_GET["departmentid"]}' and level < '{$course[0]["Level"]}';", "select");
	
}
if(isset($_POST["assign"])){
	$error_array= array();
	if(!isset($_POST["{$course[0]["code"]}"])){
		$error_array[] =  "Please select a course ";
	}
	if(empty($error_array)){
		$courseCode = $_POST["{$course[0]["code"]}"];
		
		$is_prereq = $db->query("select * from prerequisite where courseCode = '{$courseCode}';", "select");
		if(!empty($is_prereq)){
			$update = $db->query("update courses set prerequisiteId = ? where code = ? and departmentId = ?;",$is_prereq[0]["id"],$course[0]["code"], $_GET["departmentid"], "update");
		}
		else{
			$last_pre = $db->query("select (max(id) + 1) from prerequisite;", "select");
			$new = $db->query("insert into prerequisite values (?,?);", $last_pre[0][0], $courseCode, "insert");
			if($new){
				$is_prereq = $db->query("select * from prerequisite where courseCode = '{$courseCode}';", "select");
				$update = $db->query("update courses set prerequisiteId = ? where code = ? and departmentId = ?;",$is_prereq[0]["id"],$course[0]["code"], $_GET["departmentid"], "update");
			}
		}
		if($update){
			$error_messages = FlashMessages::getInstance();
			$type = "notify";
			$key = "course";
			$success_message = "Prerequisite Assigned Successfully<br />";
			//$success_message .= "To assign the course a Prerequisite course, go to the course list and click on the course <br />";
			$success_message .= "<a href = \"department_admin_page.php?department{$this_lecturer->deptId}\">Go Back </a>";
			$error_messages->setMessages($success_message, $type, $key);
			header("Location: course_info.php?id={$_GET["id"]}&departmentid={$_GET["departmentid"]}");
			
		}
		else{
			echo "failed";
		}
	}
	else{
		$error_messages = FlashMessages::getInstance();
		$type = "error";
		$key = "prerequisite";
		$error_messages->setMessages($error_array, $type, $key);
		header("Location: assign_prerequisite.php?id={$_GET["id"]}&departmentid={$_GET["departmentid"]}");
	}
	
}
?>