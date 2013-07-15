<?php
require_once("class.DatabaseWrapper.php");
require_once("class.Student.php");
$db = DatabaseWrapper::getInstance();
$upload_errors = array(
		// http://www.php.net/manual/en/features.file-upload.errors.php
		UPLOAD_ERR_OK 				=> "No errors.",
		UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
		UPLOAD_ERR_FORM_SIZE 	=> "The Picture is too large.",
		UPLOAD_ERR_PARTIAL 		=> "The Picture was only uploaded partially,  please try again.",
		UPLOAD_ERR_NO_FILE 		=> "No file uploaded.",
		UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
		UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
		UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
);
function is_logged_in(){
	if(isset($_SESSION['username']) && isset($_SESSION['category'])){
		return true;
	}
	else{
		return false;
	}
	
}

function logout(){
	if(isset($_SESSION['username']) && isset($_SESSION['category'])){
	unset($_SESSION['username']);
	unset($_SESSION['category']);
	return true;
	}
	
}

function initStudent(){
	$db = DatabaseWrapper::getInstance();
	$loginId = $db->query("select loginId from login where id = '{$_SESSION['username']}';", "select");
	
	$new = $db->query("select * from student_info where loginId = '{$loginId[0]['loginId']}';", "select");
	$this_student = Student::instantiate($new[0]);
	return $this_student;
	
}

function initLecturer(){
	$db = DatabaseWrapper::getInstance();
	$loginId = $db->query("select loginId from login where id = '{$_SESSION['username']}';", "select");
	$new = $db->query("select * from lecturers where loginId = '{$loginId[0]['loginId']}';", "select");
	$this_lecturer = Lecturer::instantiate($new[0]);
	return $this_lecturer;
}

function echoHeader(){
	echo "<div class = \"divrow\">";
	echo "<div class = \"divcell\">";
	echo "Select Course";
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo "Course Code";
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo "Course Title";
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo "Units";
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo "Status";
	echo "</div>";
	echo "</div>";
}

function echoCourse($prereqFlag, $course){
	$this_student = initStudent();
	echo "<div class = \"divrow\">";
	echo "<div class = \"divcell\">";
	if($prereqFlag == false){
		echo "<input type = \"checkbox\" name = \"{$this_student->matricNo}[]\" value = {$course["code"]}  onclick = \"return(false);\" >";
	}
	elseif (($prereqFlag == true)) {
		echo "<input type = \"checkbox\" name = \"{$this_student->matricNo}[]\" value = {$course["code"]} >";
	}

	echo "</div>";
	if($prereqFlag == false)
		echo "<font color= \"red\">";
	echo "<div class = \"divcell\">";
	echo "<label for = \"{$this_student->matricNo}[]\"> {$course["code"]} </label>";
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo "<label for = \"{$this_student->matricNo}[]\"> <a href = \"course_details.php?code={$course["code"]}\">{$course["name"]} </a></label>";
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo "<label for = \"{$this_student->matricNo}[]\"> {$course["units"]} </label>";
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo "<label for = \"{$this_student->matricNo}[]\"> {$course["status"]} </label>";
	echo "</div>";

	echo "</div>";
	if($prereqFlag == false)
		echo "</font>";
	if($prereqFlag != false);
			//$total_units_available = $total_units_available + $level_courses[$i]["units"];
}
$session = $db->query("select currentSession from university where name = 'Fountain University Osogbo';", "select");





?>