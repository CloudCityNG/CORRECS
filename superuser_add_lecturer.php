<?php
session_start();
require_once("includes/initialize.php");

define("PICTURE_DIRECTORY", "Pictures");

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<link href="stylesheets.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/login.css" media="all" /> 
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/public.css" media="all" />
<title> </title>
</head>
 <body>
<?php include("includes/header.php");?>
<div id="container">
<table>
<tr><td id="navigation">
<ul>
<li>
<a href="logout.php">Logout</a></li>
<li>
<a href = "superuser_homepage.php"> Back to Superuser Homepage</a>
</li>
</ul>
</td>
<td id="page">
<?php 

if(isset($_POST["register"])){
	$fname = $_POST["fname"];
	$lname = $_POST["lname"];
	$onames = $_POST["onames"];
	$yearEmployed = $_POST["yearemployed"];
	$department = $_POST["department"];
	$photograph = $_FILES["photograph"]["tmp_name"];
	$username = $_POST["username"];
	$password = $_POST["password"];
	$password2 = $_POST["confirm_password"];
	
	$error_array = array();
	$string_regExp = "([a-zA-Z]+)";
	$int_regExp = "([0-9]+)";
	
	if(empty($fname) || empty($lname) || empty($onames)){
		$error_array[] = "Please input in all the name fields";
	}
	else if(!preg_match($string_regExp, $fname)|| !preg_match($string_regExp, $lname)|| !preg_match($string_regExp, $onames)){
		$error_array[] = "Please input valid names";
	}
	if(empty($username) || !preg_match($string_regExp, $username)){
		$error_array[] = "Please enter a valid username";
	}
	if(empty($password) || empty($password2)){
		$error_array[] = "Please enter a password in both of the password fields";
	}
	else {
		$db = DatabaseWrapper::getInstance();
		$is_username = $db->query("select * from login where id = '{$username}';", "select");
		if(!empty($is_username)){
			$error_array[] = "This Username has already been used";
	}
	}
	if($password != $password2){
		$error_array[] = "Please enter the same password in both fields";
	}
	if($yearEmployed == ""){
		$error_array[] = "Please select the year he/she was employed";
	}
	if($department == ""){
		$error_array[] = "Please select a department";
	}
	if(is_uploaded_file($photograph)){
		$target_file = basename($_FILES['photograph']['name']);
		$type = $_FILES['photograph']['type'];
		$size = $_FILES['photograph']['size'];
		if($type != "image/jpg" && $type != "image/jpeg" && $type != "image/png"){
			$error_array[] = "You may only upload .jpeg or .png files";
		}
	else{
		$result = move_uploaded_file($photograph, PICTURE_DIRECTORY. "/".$target_file);
	}
	if($result){
		$uploaded_photograph = PICTURE_DIRECTORY. "/".$target_file;
			
	}
	else{
		echo "not uploaded <br />";
		echo $_FILES['photograph']['error'];
		
	}
	}
	else{
		$error_array[] = "Please upload a picture";
	}
	
	if(empty($error_array)){
		$db = DatabaseWrapper::getInstance();
		$college = $db->query("select * from departments where deptId = '{$department}';", "select");
		$find = $db->query("select (max(loginId) + 1) from login;", "select");
		$find2 = $db->query("select (max(id) + 1) from lecturers;", "select");
		$execute = $db->query("insert into login values (?,?,?,?);",$find[0]['(max(loginId) + 1)'], "lecturer", $username, md5($password), "insert");
		if($execute){
			$register = $db->query("insert into lecturers values (?,?,?,?,?,?,?,?,?);", $find2[0]["(max(id) + 1)"], $fname, $lname, $onames, $uploaded_photograph, $department, $college[0]["collegeId"], $yearEmployed, $find[0]['(max(loginId) + 1)'], "insert" );
		if($register){
			$success_message =  "You have Created The new Lecturer<br />";
			$success_message .= "Go <a href = \"superuser_homepage.php\">Go Back</a>";
			$error_messages = FlashMessages::getInstance();
			$type = "notify";
			$key = "lecturer";
			$error_messages->setMessages($success_message, $type, $key);
			header("Location:superuser_create_lecturer.php");
		}
		else{
			echo "failed";
		}
		}
		
		
	}
	else{
		$error_messages = FlashMessages::getInstance();
	$type = "error";
	$key = "lecturer";
	$error_messages->setMessages($error_array, $type, $key);
	header("Location: superuser_create_lecturer.php");
	}
	
	
}

?>
</td>
 </tr>
 </table>
</div>
 </body>
 </html>