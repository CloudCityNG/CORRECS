<?php
session_start();
require_once("includes/initialize.php");
$db = DatabaseWrapper::getInstance();
//$student = $db->query("select * from student_info where id = '{$_GET["studentId"]}';", "select");
//$this_student = Student::instantiate($student[0]);
if(isset($_POST["submit"])){
	echo $_GET["id"];
	$ca = $_POST["ca"];
	$exam = $_POST["exam"];
	
	$error_array = array();
	if(($ca == "") || ($exam == "")){
		$error_array[] = "Please input all the the required data";
	}
	if((!empty($ca)&&!is_numeric($ca)) || (!empty($ca)&&!is_numeric($ca))){
		$error_array[] = "Please input a numeric C.A. or exam scores";
	}
	if($ca > 30){
		$error_array[] = "The  score you input for  C.A. is over 30, which is the maximum";
	}
	
	if($exam > 70){
		$error_array[] = "The  score you input for  Exam is over 70, which is the maximum";
	}
	
	if(empty($error_array)){
		$grade;
		$total = $ca + $exam;
		if($total == 0)
			$grade = "O";
		elseif($total != 0 && $total < 40)
			$grade = "F";
		elseif($total >= 40 && $total < 45)
			$grade = "E";
		elseif($total >= 45 && $total < 50)
			$grade = "D";
		elseif($total >= 50 && $total < 60)
			$grade = "C";
		elseif($total >= 60 && $total < 70)
			$grade = "B";
		else
			$grade = "A";
		
		$query = $db->query("update coursestaken set CA= ?, exam= ?, finalScore= ?, grade= ? where studentId= ? and courseCode= ? ;", $ca, $exam, $total, $grade, $_GET["studentId"], $_GET["id"], "update");
		if($query){
			
			$success_message = "<font color = \"green\">You have successfully input the Marks</font> <br />";
			$success_message .= "<a href = lecturer_course_admin.php?id={$_GET["id"]}&dept={$_GET["dept"]}>Go Back</a> ";
			$success_messages = FlashMessages::getInstance();
			$type = "notify";
			$key = "mark_recording";
			$success_messages->setMessages($success_message, $type, $key);
			header("Location: individual_input_score.php?studentId={$_GET["studentId"]}&id={$_GET["id"]}&dept={$_GET["dept"]}");
		}
	}
	else{
		$error_messages = FlashMessages::getInstance();
		$type = "error";
		$key = "mark_recording";
		$error_messages->setMessages($error_array, $type, $key);
		header("Location: individual_input_score.php?studentId={$_GET["studentId"]}&id={$_GET["id"]}&dept={$_GET["dept"]}");
	}
	var_dump($error_array);
}
?>