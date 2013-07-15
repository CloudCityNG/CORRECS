<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in()){
	Header("Location: index.php");
}
else{
	$db = DatabaseWrapper::getInstance();
	$this_lecturer  = initLecturer();

	$students = $db->query("select * from student_info where department");
}
?>