<?php session_start(); 
 require_once("includes/initialize.php");
if(!is_logged_in()){
	Header("Location: index.php");
	
}
else{

	$this_student = initStudent();
	
};
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<title>Home</title>
<link href="stylesheets.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/login.css" media="all" /> 
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/public.css" media="all" />
<script type="text/javascript" src="script.js">
</script>
</head>
 <body>
 <?php include("includes/header.php");?>
<div id="container">
<table>
<tr id="nav_bar"><td align="left"><p>
<h5><?php echo $this_student->fullName(); ?></h5></p>
</td><td align="right"><h3><a href="logout.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp; </h3></td></tr>
<tr><td id="navigation">
<img src = "<?php echo $this_student->photograph ;?>"  align = "center" height = 150 width = 120>

<br><br>
</td>
<td id="page">
<div id="content">
 	<h2 align="center">Student Record System Self Service</h2>
 	
 	<p>Welcome <?php echo $this_student->fullName(); ?>, to the Student Academic Portal </p>
<fieldset>
 	<legend><h3>Main Menu</h3></legend>
 	<p>
 	<a href = "student_course_regg.php">Course Registration</a> <br />
 	Register for The Courses you are to take for the Session.
 	</p>
 	
 	
 	<p>
 	<a href = "list_course_session.php"> View Course Information</a> <br />
 	View Information about Courses You are offering this session
 	</p>
	
 	<p>
 	<a href = "student_change_password.php"> Change Password</a>
 	</p>
 	<p>
 	<a href = "change_student_picture.php">Change Account Picture (Please use pictures of you for identification during result computation</a>
 	</p>
    </fieldset>
    </div>
 </td>
 </tr>
 </table>
</div> 
 </body>
   
</html>