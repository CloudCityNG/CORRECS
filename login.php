<?php session_start(); require_once("includes/initialize.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
</head>






<body>
<?php
if($_POST['login']){
$username = $_POST['username'];
$password = $_POST['password'];
$login_category = $_POST['login_category'];
$encrypted_password = md5($password);
$error_array = array();
$table_name;

if(empty($username)){
	$error_array[] = "Please input a username";
}
if(empty($password)){
	$error_array[] = "Please input a password";
	
}
if($login_category == "default"){
	$error_array[] = "Please select a login category";
}


	if($login_category == "student"){
		$is_student = Student::authenticate($username, $encrypted_password);
		if(is_array($is_student)){
			$_SESSION['username'] = $username;
			$_SESSION['category'] = $login_category;
			header("Location: student_homepage.php?id=".$username);
		}
		else{
			$error_array[] = "Invalid Username or Password";
		}
	}
	elseif($login_category == "lecturer"){
		$is_lecturer = Lecturer::authenticate($username, $encrypted_password);
		var_dump($is_lecturer);
		if(is_array($is_lecturer)){
			$_SESSION['username'] = $username;
			$_SESSION['category'] = $login_category;
			header("Location: lecturer_homepage.php?id=".$username);
		}
		else{
			$error_array[] = "Invalid Username or Password";
		}
	}
	elseif($login_category == "superuser"){
		$db = DatabaseWrapper::getInstance();
		$select_super = $db->query("select * from login where id = '{$username}' and password = '{$encrypted_password}' and loginType = 'super';", "select");
		if(!empty($select_super)){
			$_SESSION["username"] = $username;
			$_SESSION["category"] = $login_category;
			header("Location: superuser_homepage.php?id=".$username);
		}
		else{
			$error_array[] = "Invalid Username or Password";
		}
	}
}
if(!empty($error_array)){
	
	$error_messages = FlashMessages::getInstance();
	$type = "error";
	$key = "registration";
	$error_messages->setMessages($error_array, $type, $key);
	header("Location: index.php");

}
else{
	
}


	

 ?>

</body>
</html>