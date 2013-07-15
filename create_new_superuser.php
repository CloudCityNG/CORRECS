<?php
session_start(); 
require_once("includes/initialize.php");
if(!is_logged_in()){
	Header("Location: index.php");
	
}
else{
	$db = DatabaseWrapper::getInstance();
	
	
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<link href="stylesheets.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/login.css" media="all" /> 
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/box_design.css" media="all" />
<link type="text/css" rel="stylesheet" href="css/public.css" media="all" />

<title>New Super User</title>
</head>
 <body>
 <?php include("includes/header.php");?>
 <div id="container">
<table>
<tr id="nav_bar"><td align="left"><p>
<h5>&nbsp;</h5></p>
</td><td align="right"><h3><a href="logout.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp; </h3></td></tr>
<tr><td id="navigation">
 <ul>
<li><a href="logout.php">Logout</a>
</li></ul>
</td>
<td id="page">
<div id="content">
<fieldset><legend><h3>Create a new Superuser Account</h3></legend>
 <form action  = "<?php echo $_SERVER["PHP_SELF"]?>" method = "post">
 <div class = "divtable">
 <div class = "divrow">
 <div class = "divcell">
Username: 
</div>
<div class = "divcell">
<input type = "text" name = "username" id = "username"></input>
</div>
</div>
 <div class = "divrow">
 <div class = "divcell">
Password: 
</div>
<div class = "divcell">
<input type = "password" name = "password" id = "password"></input>
</div>
</div>
<div class = "divrow">
 <div class = "divcell">
Confirm Password: 
</div>
<div class = "divcell">
<input type = "password" name = "confirm_password" id = "confirm_password"></input>
</div>
</div>
<input type = "submit" name = "submit" value = "Submit"></input>
  </div>

 <?php 
 if(isset($_POST["submit"])){
 	$username = $_POST["username"];
 	$password = $_POST["password"];
 	$confirm_password  = $_POST["confirm_password"];
 	$string_regExp = "([a-zA-Z]+)";
 	$error_array = array();
 	
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
	
	if(empty($password) || empty($confirm_password)){
		$error_array[] = "Please enter a password in both of the password fields";
	}
	
	if($password != $confirm_password){
		$error_array[] = "Please enter the same password in both fields";
	}
 	
 	if(empty($error_array)){
 		$last_login = $db->query("select (max(loginId + 1)) from login;", "select");
 		$update = $db->query("insert into login values (?,?,?,?);", $last_login[0][0], "super", $username,md5($password), "insert");
 		if($update){
 			$error_messages = FlashMessages::getInstance();
			$type = "notify";
			$key = "super";
			$success_message  =  "A new superuser account has been created <br />";
 			$success_message.= "<a href = \"superuser_homepage.php\">Go back</a>";
			$error_messages->setMessages($success_message, $type, $key);
 		}
 	}
 	else{
 		$error_messages = FlashMessages::getInstance();
		$type = "error";
		$key = "super";
		$error_messages->setMessages($error_array, $type, $key);
 	}
 }
 ?>
 <?php 
$error_message = FlashMessages::getInstance();
$key = "super";
$error_message->displayMessage("super");
$error_message->unsetMessage("super");

?>
  </form>
 </fieldset>
 </div>
 </td>
 </tr>
 </table>
</div>
 </body>
 </html>