<?php
session_start();
require_once("includes/initialize.php");
if((!is_logged_in()) || (!isset($_GET["id"])) || (!isset($_GET["dept"]))){
	Header("Location: index.php");

}
else{

	$this_lecturer = initLecturer();
	$db = DatabaseWrapper::getInstance();
	//$student_list = $db->query("select * from student_info where deptId = '{$_GET["dept"]}';", "select");
	//$lecturer_courses = $db->query("select * from courses where lecturerId = '{$this_lecturer->id}';", "select");
	
}

if(isset($_POST["upload"])){
	
	$file = $_FILES["scores"]["tmp_name"];
	$type = $_FILES['scores']['type'];
	$error_array = array();
	//$uploaded_file;
	if(is_uploaded_file($file)){
		/* $error= $_FILES['scores']['error'];
		$error_array[] = "No file uploaded";
	 */
	echo $type;
	$fieldseparator = ",";
	$lineseparator = "\n";
	
	
	$addauto = 0;
	
	$save = 1;
	$outputfile = "output.sql";
	
	echo "<br>".$file."<br>";
	
	if(!file_exists($file)) {
		$error_array[] = "File not found. Make sure you specified the correct path.\n";		exit;
	}
	elseif($type != "application/vnd.ms-excel"){
		$error_array[] = "You can only upload .CSV excel files";
	}
	$file_open = fopen($file,"r");
	if(!$file_open) {
		$error_array[] =  "Error opening data file.\n";
		exit;
	}
	$size = filesize($file);
	if(!$size) {
		$error_array[] =  "File is empty.\n";
		exit;
	}
	$csvcontent = fread($file_open,$size);
	fclose($file_open);
	//var_dump($csvcontent);
	$failed_list = "";
	if(empty($error_array)){
	$lines = 0;
	
	$linearray = array();
	
	foreach(@split($lineseparator,$csvcontent) as $line) {
	//	$lines++;
		$line = trim($line," \t");
		$line = str_replace("\r","",$line);
	
		$line = str_replace("'","\'",$line);
	
		$linearray = explode($fieldseparator,$line);
		var_dump($linearray);
		if(!empty($linearray)){
			$matric_no = $linearray[0];
			if($matric_no == ""){
				continue;
			}
			$ca = $linearray[1];
			$exam = $linearray[2];
			
			$find_student = $db->query("select * from student_info where matricNo = '{$matric_no}';", "select");
			if(empty($find_student)){
				$error_array[] = "There is no student with matric number {$matric_no}";
			}
			else{
				if(($ca == "") || ($exam == "")){
					$error_array[] = "Please input all the the required data for matric number {$matric_no}";
				}
				if((!empty($ca)&&!is_numeric($ca)) || (!empty($ca)&&!is_numeric($ca))){
					$error_array[] = "Please input a numeric C.A. or exam score for matric number {$matric_no}";
				}
				if($ca > 30){
					$error_array[] = "The  score you input for for matric number {$matric_no}'s C.A. is over 30, which is the maximum";
				}
				
				if($exam > 70){
					$error_array[] = "The  score you input for for matric number {$matric_no}'s Exam is over 70, which is the maximum";
				}
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
				
				$query = $db->query("update coursestaken set CA= ?, exam= ?, finalScore= ?, grade= ? where studentId= ? and courseCode= ? ;", $ca, $exam, $total, $grade, $find_student[0]["id"], $_GET["id"], "update");
				if($query){
					echo "yes";
					$lines++;
				}
				else $failed_list .= $failed_list + " {$matric_no} "; 
					
			}
		}
		
	}
	
	
	echo "Found a total of $lines records in this csv file.\n";
	
echo $failed_list;
}
	}
	
	else{
		$error= $_FILES['scores']['error'];
		$error_array = $upload_errors[$error];
	}
if(!empty($error_array)){
	$error_messages = FlashMessages::getInstance();
	$type = "error";
	$key = "mark_recording";
	$error_messages->setMessages($error_array, $type, $key);
	header("Location: input_scores_csv.php?id={$_GET["id"]}&dept={$_GET["dept"]}");
}

if($failed_list != ""){
	$message = "The following students could not have their grades uploaded: {$failed_list}";
	$error_messages = FlashMessages::getInstance();
	$type = "error";
	$key = "mark_recording";
	$error_messages->setMessages($message, $type, $key);
	header("Location: input_scores_csv.php?id={$_GET["id"]}&dept={$_GET["dept"]}");
}
	if(empty($error_array) && $failed_list == ""){
		$success = FlashMessages::getInstance();
		$type = "notify";
		$key = "mark_recording";
		$message = "Upload complete. A total of $lines records were processed";
		$success->setMessages($message, $type, $key);
		header("Location: input_scores_csv.php?id={$_GET["id"]}&dept={$_GET["dept"]}");
	}
}	
	
	?>
	
	





 