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
<! DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<title>Home</title>
<link type="text/css" rel="stylesheet" href="css/login.css" media="all" /> 
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/box_design.css" media="all" />
<link type="text/css" rel="stylesheet" href="css/public.css" media="all" />
</head>
 <body>
 <?php include("includes/header.php");?>
<div id="container">
<table>
<tr id="nav_bar"><td align="left"><p>
<h5>&nbsp;</h5></p>
</td><td align="right"><h3><a href="logout.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp; </h3></td></tr>
<tr><td id="navigation">
 &nbsp;
</td>
<td id="page">
<div id="content">
<fieldset><legend><h3>System Admin page</h3></p></legend>
 	<p>
 	<a href = "new_session.php">Commence new Session</a> <br />
 	Begin a new Session. This must be done at the beginning of each academic year
 	</p>
 	
 	<p>
 	<a href = "assign_hod.php"> Assign HOD to a department</a> <br />
 	
 	</p>
 	
 	<p>
 	<a href = "create_new_college.php"> New College</a> <br />
 	Create a new College
 	</p>
 	<p>
 	<a href = "create_new_department.php"> New Department</a> <br />
 	Create a new Department
 	</p>
 	<p>
 	<a href = "create_new_programme.php"> New Programme</a> <br />
 	Create a new Programme
 	</p>
 	<p>
 	<a href = "fountain_scholar.php"> Change Fountain Scholar grade</a> <br />
 	Change the CGPA that qualifies students for the Fountain Scholarship
 	</p>
 	
 	<p>
 	<a href = "create_new_superuser.php">Create another Superuser</a>
 	</p>
 	<p>
 	<a href = "superuser_create_lecturer.php"> Create New Lecturer</a> <br />
 	Create a new Lecturer
 	</p>
	</fieldset>
	</div>
	</td>
 </tr>
 </table>
</div>
</body>
</html>
