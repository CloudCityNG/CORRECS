<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in() || !isset($_GET["id"])){
	Header("Location: index.php");
}
else{
	$db = DatabaseWrapper::getInstance();
	$lecturer = $db->query("select * from lecturers where id = '{$_GET["id"]}';", "select");
	if($lecturer){
		$this_lecturer = Lecturer::instantiate($lecturer[0]);
	}
}

if($_POST["allocate"]){
	$courses = $_POST["{$this_lecturer->id}"];
	$error_array = array();
	$success_array = array();
	//var_dump($courses);
	if(empty($courses))
	$error_array[] = "You did not select any course";
	
	if(empty($error_array)){
		for($i=0;$i<count($courses); $i++){
			$query = $db->query("update courses set lecturerId = ? where code = ?;", $this_lecturer->id, $courses[$i], "update");
			
			if($query){
				$success_array[] = $courses[$i];
			}
		}
		
		if(count($success_array) == count($courses)){
			$error_messages = FlashMessages::getInstance();
			$type = "notify";
			$key = "allocation";
			$error_messages->setMessages("You have allocated successfully <br> <a href = \"lecturer_info.php?id={$_GET["id"]}\"> Go Home</a>", $type, $key);
			header("Location: course_allocation.php?id={$_GET["id"]}");
		}
	}
	else{
		$error_messages = FlashMessages::getInstance();
	$type = "error";
	$key = "allocation";
	$error_messages->setMessages($error_array, $type, $key);
	header("Location: course_allocation.php?id={$_GET["id"]}");
	}
}

?>