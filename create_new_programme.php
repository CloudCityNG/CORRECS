<?php
session_start(); 
require_once("includes/initialize.php");
if(!is_logged_in()){
	Header("Location: index.php");
	
}
else{
	$db = DatabaseWrapper::getInstance();
	$colleges = $db->query("select * from colleges;", "select");
	$departments = $db->query("select * from departments;", "select");
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<link href="stylesheets.css" rel="stylesheet" type="text/css" />

<title>New Programme</title>
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
<h5>&nbsp;</h5></p>
</td><td align="right"><h3><a href="logout.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp; </h3></td></tr>
<tr><td id="navigation"><br><br>
</td>
<td id="page">
 <?php 
 $error_message = FlashMessages::getInstance();
$key = "programme";
$error_message->displayMessage("programme");
$error_message->unsetMessage("programme");
 ?>
 <div id="content">
 <form action  = "create_new_programme_backend.php" method = "post">
<fieldset><legend> <h2>Add a new Programme</h2></legend>
 <div class = "divtable">
 <div class = "divrow">
 <div class = "divcell">
programme Name:
</div>
<div class = "divcell">
<input type = "text" name = "name" id = "name"></input>
</div>
</div>
<div class = "divrow">
 <div class = "divcell">
Duration:
</div>
<div class = "divcell">
<input type = "text" name = "duration" id = "duration"></input>
</div>
</div>
 <h3>Select Department</h3>
<?php 
	echo "<div class = \"divrow\">";
	echo "<div class = \"divcell\">";
	echo "<input type = \"radio\" name = \"department\" checked = \"checked\" value = \"\">";
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo "Select Department";
	echo "</div>";
	echo "</div>";
for($i=0;$i<count($departments);$i++){
	echo "<div class = \"divrow\">";
	echo "<div class = \"divcell\">";
	echo "<input type = \"radio\" name = \"department\" value = \"{$departments[$i]["deptId"]}\">";
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo $departments[$i]["deptName"];
	echo "</div>";
	echo "</div>";
}
?>


<input type = "submit" name = "submit" value = "Submit"></input>
 </div>
 
 </fieldset>
 </form>
 
 </div>
 </td>
 </tr>
 </table>
</div> 
 </body>
 </html>