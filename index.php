<?php session_start(); require_once("includes/initialize.php"); 
if(is_logged_in() && $_SESSION['category'] == "student" )

	Header("Location: student_homepage.php");
elseif(is_logged_in() && $_SESSION['category'] == "lecturer")
	Header("Location: lecturer_homepage.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<link type="text/css" rel="stylesheet" href="css/login.css" media="all" /> 
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/box_design.css" media="all" />
<link type="text/css" rel="stylesheet" href="css/public.css" media="all" />
</head>
<body>
<?php include("includes/header.php");?>

<div id="container_login">
<table>
	<tr>
<td id="page_login">
<div id="login_box">
<table><tr><td id="login_page">

<form action= "login.php"	method = "post">
<table id="special_font">
<tr>
<td align="left" width="30px">
  <label for="login_category">Login As</label></td><td align="left">
  <select name="login_category" id="login_category">
    <option value="default" selected="selected">Select Login Category</option>
    <option value="student">Student</option>
    <option value="lecturer">Lecturer</option>
    <option value="superuser">Super User</option>
   
  </select></td></tr>
  <tr><td align="left"><label for="username">User Name: </label></td>
  <td align="left">
  <input type="text" name="username" id="username" size="15" />
</td></tr>
<tr>
<td align="left">
  <label for="password">Password:   </label>
  </td><td align="left">
  <input type="password" name="password" id="password" size="15" />
 </td></tr>
 <tr><td align="left">
  <input type="submit" name="login" id="login" value="Login" onmouseover="window.blur()" /></td><td>
  Are you a new Student? <a href="student_registration.php">Register</a></td>
</tr></table>
</form>
</td>
<td id="login_infobox" bordercolor="#003366">
<h3 align="center">Fountain Course Registration and Result System</h3>
<h4>Students Can Register for courses here, and view Course information</h4>
<h4>Lecturers input the scores of students</h4>
<h4>Please register for an account by clicking on the Register Button and log in with your Account Details in the boxes provided to the left</h4>

<br><p><h4>All feedback and comments should be forwarded to the Site Administrator</h4>
</td>
</tr>
</table>
</div>
<?php 

$error_message = FlashMessages::getInstance();
$key = "registration";
$error_message->displayMessage("registration");
$error_message->unsetMessage("registration");
?>
</td>
</tr>

</table>
</div>
</body>
</html>