<?php 
session_start();
require_once("includes/initialize.php");
if(!is_logged_in()){
	Header("Location: index.php");
	
}
else{
	$this_student = initStudent();
	$db = DatabaseWrapper::getInstance();
	$universitySession = $db->query("select currentSession from university where name = 'Fountain University Osogbo';", "select");
	$session_courses = $db->query("select * from coursestaken where studentId = '{$this_student->id}' and session = '{$universitySession[0]["currentSession"]}';", "select");
}
?>