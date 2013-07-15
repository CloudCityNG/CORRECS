<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in() || (!isset($_GET["id"])) || (!isset($_GET["departmentid"]))){
	Header("Location: index.php");
}
else{
	$db = DatabaseWrapper::getInstance();
	$course = $db->query("select * from courses where code = '{$_GET["id"]}' and departmentId = '{$_GET["departmentid"]}';", "select");
	//var_dump($course);
	$this_lecturer = initLecturer();
}
?>
<?php 
if(isset($_POST["submit"])){
	$description  = $_POST["description"];
 	$error_array = array();
   	if(empty($description)){
 		$error_array[] = "Please Input description";
 	}
 	
 	
 	if(empty($error_array)){
 		$update = $db->query("update courses set description = ? where code = ? and departmentId = ?;", $description, $course[0]["code"],$course[0]["departmentId"], "update");
 		if($update){
 			$error_messages = FlashMessages::getInstance();
			$type = "notify";
			$key = "course";
			$success_message = "Course Description edited Successfully <br />";
			$success_message .= "<a href = \"department_admin_page.php?department={$this_lecturer->deptId}\">Go Back </a>";
			$error_messages->setMessages($success_message, $type, $key);
			header("Location: course_info.php?id={$_GET["id"]}&departmentid={$_GET["departmentid"]}");
 		}
 		
 	}
 	else{
 		$error_messages = FlashMessages::getInstance();
		$type = "error";
		$key = "course";
		$error_messages->setMessages($error_array, $type, $key);
		header("Location: edit_course_description.php?id={$_GET["id"]}&departmentid={$_GET["departmentid"]}");
 	}
	}
    ?>
   
 