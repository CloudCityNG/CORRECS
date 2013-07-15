<?php
session_start();
require_once("includes/initialize.php");
define("PICTURE_DIRECTORY", "Pictures");
define("MAX_FILE_SIZE", 2000000);
$db = DatabaseWrapper::getInstance();
if(isset($_POST['register'])){
	
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$onames = $_POST['onames'];
	$sex = $_POST['sex'];
	$string_regExp = "([a-zA-Z]+)";
	$int_regExp = "([0-9]+)";
	$prematric = $_POST['prematric'];
	$postmatric = $_POST['matric'];
	$matricNo;
	$college = $_POST['college'];
	$department = $_POST['department'];
	$programme = $_POST['programme'];
	$currentSemester = 1;
	$modeOfEntry = $_POST['modeofentry'];
	$entryYear = $session[0][0];
	$level;
	$photograph = $_FILES['photograph']['tmp_name'];
	$uploaded_photograph;
	$loginId;
	$currentSemester;
	$username = $_POST['username'];
	$password = $_POST['password'];
	$password2 = $_POST['confirm_password'];
	$error_array = Array();
	$instance = Array();
	$select = $db->query("select collegeId from departments where deptId = '{$department}';", "select");
		
		$select2 = $db->query("select departmentId from programmes where programmeId = '{$programme}';", "select");
	
	
	if(empty($fname) || empty($lname) || empty($onames)){
		$error_array[] = "Please input in all the name fields";
	}
	else if(!preg_match($string_regExp, $fname)|| !preg_match($string_regExp, $lname)|| !preg_match($string_regExp, $onames)){
		$error_array[] = "Please input valid names";
	}
	else{
		$instance['fname'] = $fname; $instance['lname']=$lname ; $instance['onames'] = $onames;
	}
	 
	if($prematric == ""){
		$error_array[] = "Please select college part of matric number";
	}
	else if(!preg_match($int_regExp,$postmatric)){
		$error_array[] = "Please input a valid matric number"; 
	}
	else{
		$matricNo = $prematric . $postmatric;
		$db = DatabaseWrapper::getInstance();
		$is_matric = $db->query("select * from student_info where matricNo = '{$matricNo}';", "select");
		if(!empty($is_matric)){
			$error_array[] = "This Matric Number has already been registered";
		}
		else;
		$instance['matricNo'] = $matricNo;
	}
	if ($sex == "select"){
		$error_array[] = "Select valid Sex";
	}
	else $instance['sex'] = $sex;
	
	if (($college == "select") || ($department == "") ||  ($programme == "")){
		$error_array[] = "Please input a valid college/department/programme";
	}
	
	elseif($select[0]["collegeId"] != $college){
		$error_array[] = "There is no such department in the college you selected";
	}
	elseif($select2[0]["departmentId"] != $department){
			$error_array[] = "There is no such programme in the department you selected";
		}
	else{
		$instance['deptId'] = $department;
		$instance['collegeId'] = $college;
		$instance['programmeId'] = $programme;
	}
	
	
	
	
	if($modeOfEntry == ""){
		$error_array[] = "Please select your mode of entry";
	}else $instance['modeOfEntry'] = $modeOfEntry;
	
	if($modeOfEntry == "UME"){
		$level = 100;
		$instance['level']  = $level;
	}
	elseif($modeOfEntry == "DE" || $modeOfEntry == "DFP"){
		$level = 200;
		$instance['level']  = $level;
	}
	
	
	
	
	if(empty($username) || !preg_match($string_regExp, $username)){
		$error_array[] = "Please enter a valid username";
	}
	else {
		$is_username = $db->query("select * from login where id = '{$username}';", "select");
		if(!empty($is_username)){
			$error_array[] = "This Username has already been used";
		}
		else;
	}
	
	if(empty($password) || empty($password2)){
		$error_array[] = "Please enter a password in both of the password fields";
	}
	
	if($password != $password2){
		$error_array[] = "Please enter the same password in both fields";
	}
	if(is_uploaded_file($photograph)){
		$target_file = basename($_FILES['photograph']['name']);
		$type = $_FILES['photograph']['type'];
		$size = $_FILES['photograph']['size'];
		if($type != "image/jpg" && $type != "image/jpeg" && $type != "image/png"){
			$error_array[] = "You may only upload .jpeg or .png files";
		}
		/*else if($size > MAX_FILE_SIZE){
			$error_array[] = "Picture too large";
		}*/
		else{
		$result = move_uploaded_file($photograph, PICTURE_DIRECTORY. "/".$target_file);
		}
		if($result){
			$uploaded_photograph = PICTURE_DIRECTORY. "/".$target_file;
			$instance['photograph'] = $uploaded_photograph;
		}
		
	}
	else{
		echo "not uploaded <br />";
		echo $_FILES['photograph']['error'];
		
	}
	
	
	$instance['currentSemester'] = $currentSemester;
	$instance['entryYear'] = $entryYear;
	if(empty($error_array)){
		$db = DatabaseWrapper::getInstance();
		$find = $db->query("select (max(loginId) + 1) from login;", "select");
		
		$execute = $db->query("insert into login values (?,?,?,?);",$find[0]['(max(loginId) + 1)'], "student", $username, md5($password), "insert");
		
		
		 if($execute){
			
		 	
			$find2 = $db->query("select (max(id) + 1) from student_info;", "select");
			
			$instance['id'] = $find2[0]['(max(id) + 1)'];
			$instance['loginId'] = $find[0]['(max(loginId) + 1)'];
			
			/*$new_student = $db->query("insert into student_info values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);",$find2[0]['(max(id) + 1)'], $lname,$fname,$onames,$matricNo,$sex,$level,$entryLevel
			,$modeOfEntry, $entryYear, $department, $college,$programme,$uploaded_photograph, $find[0]['(max(loginId) + 1)'], "NULL", $currentSemester, "insert");
			
			if($new_student){
				$_SESSION['username'] = $username;
				echo "Your registration has been successful";
				echo "Go to Profile page <a href = student_homepage.php?id=".$username;
			}
			else{
				echo "failed";
			}*/
			$new_student = Student::instantiate($instance);
			
			$create = $new_student->create();
			
			if($create){
				$_SESSION['username'] = $username;
				$_SESSION['category'] = "student";
				$error_messages = FlashMessages::getInstance();
				$success_message = "Your registration has been successful <br />";
				$success_message .= "Go to Profile page <a href = student_homepage.php> Home Page</a>";
				$type = "notify";
				$key = "registration";
				$error_messages->setMessages($success_message, $type, $key);
				header("Location: student_registration.php");
				
			
			}
			else{
				echo "Registration failed";
			} 
		}
		else{
			echo "login table fail";
		}
		
		
	}
	else{
	$error_messages = FlashMessages::getInstance();
	$type = "error";
	$key = "registration";
	$error_messages->setMessages($error_array, $type, $key);
	header("Location: student_registration.php");
	}
	
	
	
	
	
	
}


?>