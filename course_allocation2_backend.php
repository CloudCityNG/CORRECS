<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in() || (!isset($_GET["id"])) || (!isset($_GET["departmentid"]))){
	//Header("Location: index.php");
	echo $_GET["id"];
	echo $_GET["departmentid"];
}
else{
	$db = DatabaseWrapper::getInstance();
	$course = $db->query("select * from courses where code = '{$_GET["id"]}' and departmentId = '{$_GET["departmentid"]}';", "select");
	$this_lecturer = initLecturer();
	$select_lecturers = $db->query("select * from lecturers where deptId = '{$this_lecturer->deptId}';", "select");
	$all_lecturers = $db->query("select * from lecturers where deptId != '{$this_lecturer->deptId}';","select");
} 


if(isset($_POST["submit"])){
	$error_array = array();
	if(!isset($_POST["{$course[0]["code"]}"])){
		$error_array[] =  "Please select a lecturer <br />";
	}

	else{
		$lecturerId = $_POST["{$course[0]["code"]}"];
		$update = $db->query("update courses set lecturerId = ? where code = ? and departmentId = ?;", $lecturerId, $course[0]["code"], $_GET["departmentid"], "update");

		if($update){
			$error_messages = FlashMessages::getInstance();
			$type = "notify";
			$key = "course";
			$success_message  =  "course allocated to lecturer successfully <br />";
			$success_message.= "<a href = \"view_course_list.php?department={$this_lecturer->deptId}\">Go back</a>";
			$error_messages->setMessages($success_message, $type, $key);
			header("Location: course_info.php?id={$_GET["id"]}&departmentid={$_GET["departmentid"]}");
		}
		else{
			echo "Failed, please contact the system administrator";
		}
		
	}
	if(!empty($error_array)){
		$error_messages = FlashMessages::getInstance();
		$type = "error";
		$key = "course_allocation";
		$error_messages->setMessages($error_array, $type, $key);
		header("Location: course_allocation2.php?id={$_GET["id"]}&departmentid={$_GET["departmentid"]}");
	}

}
?>