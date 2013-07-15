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
	$failed_entries = array();
	$error_array = array();
	
	if(count($ca) != count($exam)){
		$error_array[] = "You have ommitted a students CA/Exam score";
	}
	
		foreach($ca as $id=>$score){
			
			$student = $db->query("select * from student_info where id = '{$id}';", "select");
			if($score == ""){
				$error_array[] = "Please enter C.A. Score for {$student[0]["lname"]} {$student[0]["fname"]}";
			}
			if(!empty($score)&&!is_numeric($score)){
				$error_array[] = "Please input a numeric C.A. for {$student[0]["lname"]} {$student[0]["fname"]}";
			}
			if($score > 30){
				$error_array[] = "The  score you inputed for {$student[0]["lname"]} {$student[0]["fname"]}'s C.A. is over 30, which is the maximum";
			}
		}
		foreach($exam as $id=>$score){
			$student = $db->query("select * from student_info where id = '{$id}';", "select");
			if($score == ""){
				$error_array[] = "Please enter Exam Score for {$student[0]["lname"]} {$student[0]["fname"]}";
			}
			if(!empty($score)&&!is_numeric($score)){
				$error_array[] = "Please input a numeric Exam figure for {$student[0]["lname"]} {$student[0]["fname"]}";
			}
			if($score > 70){
				$error_array[] = "The  score you input for 's Exam is over 70, which is the maximum";
			}
		}
		if(empty($error_array)){
			$grade;
			while((list($key1,$value1) = each($ca)) && (list($key2,$value2) = each($exam))){
				
				$total = $value1 + $value2;
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
					
				if($key1 == $key2){
					$query = $db->query("update coursestaken set CA= ?, exam= ?, finalScore= ?, grade= ? where studentId= ? and courseCode= ? ;", $value1, $value2, $total, $grade, $key1, $_GET["id"], "update");
					/* echo $value1;
					echo $value2; */
					//echo "yes";
				}
				if(!$query){
					$failed_entries[] = $key1;
				}
				else{
					
					
					
				}
				
		}
		if(!empty($failed_entries)){
			foreach($failed_entries as $value)
			echo "Marks entry for {$value} failed, please try again or report error to addmin";
		}
		else{
			$success_message = "<font color = \"green\">You have successfully input the Marks</font> <br />";
			//$success_message .= "<a href = lecturer_course_admin.php?id={$_GET["id"]}&dept={$_GET["dept"]}>Go Back</a> ";
			$success_messages = FlashMessages::getInstance();
			$type = "notify";
			$key = "mark_recording";
			$success_messages->setMessages($success_message, $type, $key);
			header("Location: lecturer_course_admin.php?id={$_GET["id"]}&dept={$_GET["dept"]}");
		}
	}
	else{
		$error_messages = FlashMessages::getInstance();
		$type = "error";
		$key = "mark_recording";
		$error_messages->setMessages($error_array, $type, $key);
		header("Location: input_scores.php?id={$_GET["id"]}&dept={$_GET["dept"]}");
	}
}

	

?>