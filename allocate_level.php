<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in()){
	Header("Location: index.php");
}
else{
	$db = DatabaseWrapper::getInstance();
	$lecturer = $db->query("select * from lecturers where id = '{$_GET["id"]}';", "select");
	if($lecturer){
		$this_lecturer = Lecturer::instantiate($lecturer[0]);
	}
}

if($_POST["submit"]){
	$entryyear = $_POST["entryyear"];
	//$currentlevel = $_POST["currentlevel"];
	$programme = $_POST["programme"];
	$error_array = array();
	
	if ($entryyear == ""){
		$error_array = "Select an Entry year";
	}
	
	elseif($programme == ""){
		$error_array = "Select a Programme";
	}
	
	if(empty($error_array)){
		$update;
		$is_any = $db->query("select * from level_advisers where lecturerId = '{$this_lecturer->id}';", "select");
		if(empty($is_any)){
			$update = $db->query("insert into level_advisers values (?,?,?);", $this_lecturer->id, $programme, $entryyear, "insert");
		}
		else{
			$update = $db->query("update level_advisers set programmeId = ?, entryYear = ? where lecturerId = ?;", $programme, $entryyear, $this_lecturer->id, "update");
		}
		if($update){
			$error_messages = FlashMessages::getInstance();
			$type = "notify";
			$key = "allocation";
			$error_messages->setMessages("You have allocated successfully <br> <a href = \"lecturer_info.php?id={$_GET["id"]}\"> Go Home</a>", $type, $key);
			header("Location: level_adviser_allocation.php?id={$_GET["id"]}");
		}
	}
	else{
	$error_messages = FlashMessages::getInstance();
	$type = "error";
	$key = "allocation";
	$error_messages->setMessages($error_array, $type, $key);
	header("Location: level_adviser_allocation.php?id={$_GET["id"]}");
		
	}
}