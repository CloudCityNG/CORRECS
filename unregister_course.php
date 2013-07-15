<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in() || (!isset($_GET["code"]))){
	Header("Location: index.php");

}
else{
	$this_student = initStudent();
	$db = DatabaseWrapper::getInstance();
}
if(!preg_match("(GNS.[0-9])", $_GET["code"]))
	$course = $db->query("select * from courses where code = '{$_GET["code"]}' and departmentId = '{$this_student->deptId}';", "select");
else
	$course = $db->query("select * from courses where code = '{$_GET["code"]}';", "select");
var_dump($course);
$reg_log = $db->query("select * from registration_log where studentId = '{$this_student->id}' and session = '{$session[0][0]}';", "select");
var_dump($reg_log);
if((!empty($reg_log)) && (!empty($course))){
	echo "yes";
	$no_units_updated = $reg_log[0]["total_units_registered"] - $course[0]["units"];
	echo $no_units_updated;
}
$delete = $db->query("delete from coursestaken where studentId = '{$this_student->id}' and courseCode = '{$_GET["code"]}' and session = '{$session[0][0]}';", "delete");
if($delete){
	
	if(isset($no_units_updated)){
		echo "yes";
		$update_log = $db->query("update registration_log set total_units_registered = ? where id = ?;", $no_units_updated, $reg_log[0]["id"], "update");
		if($update_log){
			
			$success_message = FlashMessages::getInstance();
			$type = "notify";
			$key = "course";
			$message = "You have successfully unregistered";
			$success_message->setMessages($message, $type, $key);
			header("Location: list_course_session.php");
		}
	}
	
}

else{
	$failure_message = FlashMessages::getInstance();
	$type = "error";
	$key = "course";
	$message = "Operation Failed";
	$failure_message->setMessages($message, $type, $key);
	header("Location: list_course_session.php");
}

?>