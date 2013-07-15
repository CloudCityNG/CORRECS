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
	$precode  = $_POST["precode"];
 	$code = $_POST["code"];
 	$coursecode = $precode.$code;
 	$code_regExp = "([a-zA-Z]{3,3})";
 	$error_array = array();
   	if(empty($precode) || empty($code)){
 		$error_array[] = "Please Input the course code fields completely, the first field for the alphabetic part and the other for the numbers";
 	}
 	
 	if(!preg_match($code_regExp, $precode)){
 		$error_array[] = "Please input a valid alphabetic code in the alphabetic area";
 	}
 	if(!is_numeric($code) || ($code > 999) || ($code < 100)){
 		$error_array[] = "Please input a valid numeric code in the numeric area of the course code";
 	}
 	elseif($coursecode == $course[0]["code"]){
 		$error_array[] = "The new course code and the old one are the same!";
 	}
 	if(empty($error_array)){
 		$create  = $db->query("insert into courses values(?,?,?,?,?,?,?,?,?,?,?,?);", $coursecode, $course[0]["name"],$course[0]["units"],$course[0]["status"],$course[0]["Level"],$course[0]["semester"],$course[0]["description"],$course[0]["lecturerId"],$course[0]["programmeId"],$course[0]["departmentId"],$course[0]["collegeId"],NULL,"insert");
 		if($create){
 			if(!preg_match("(GNS.[0-9])", $course[0]["code"]))
 				$update = $db->query("update coursestaken set courseCode = ? where courseCode = ? and deptId = ?;", $coursecode, $course[0]["code"], $course[0]["departmentId"], "update");
 			else
 				$update = $db->query("update coursestaken set courseCode = ? where courseCode = ?;", $coursecode, $course[0]["code"], "update");
			$update2 = $db->query("update prerequisite set courseCode = ? where courseCode = ?;", $coursecode, $course[0]["code"], "update");
 		}
 		//$update = $db->query("update courses set code = ? where code = ? and departmentId = ?;", $coursecode, $course[0]["code"],$course[0]["departmentId"], "update");
 		
 		if($update && $update2){
 			echo $course[0]["code"];
 			$delete = $db->query("delete from courses where code = '{$course[0]["code"]}' and departmentId = '{$course[0]["departmentId"]}';", "delete");
 			if($delete){
 				$error_messages = FlashMessages::getInstance();
				$type = "notify";
				$key = "course";
				$success_message = "Course code edited Successfully <br />";
				$success_message .= "<a href = \"department_admin_page.php?department={$this_lecturer->deptId}\">Go Back </a>";
				$error_messages->setMessages($success_message, $type, $key);
				header("Location: course_info.php?id={$coursecode}&departmentid={$_GET["departmentid"]}");
 			}
 			else{
				echo "delete failed";
			}
 		}
 		
 	}
 	else{
 		$error_messages = FlashMessages::getInstance();
		$type = "error";
		$key = "course";
		$error_messages->setMessages($error_array, $type, $key);
		header("Location: edit_course_code.php?id={$_GET["id"]}&departmentid={$_GET["departmentid"]}");
 	}
	}
    ?>
   
 