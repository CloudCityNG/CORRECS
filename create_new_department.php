<?php
session_start(); 
require_once("includes/initialize.php");
if(!is_logged_in()){
	Header("Location: index.php");
	
}
else{
	$db = DatabaseWrapper::getInstance();
	$colleges = $db->query("select * from colleges;", "select");
	$lecturers = $db->query("select * from lecturers;", "select");
}

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<link href="stylesheets.css" rel="stylesheet" type="text/css" />

<title>New Department</title>
</head>

 <link type="text/css" rel="stylesheet" href="css/login.css" media="all" /> 
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/box_design.css" media="all" />
<link type="text/css" rel="stylesheet" href="css/public.css" media="all" />
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
<?php 
$error_message = FlashMessages::getInstance();
$key = "department";
$error_message->displayMessage("department");
$error_message->unsetMessage("department");
?>
 <form action  = "create_new_department_backend.php" method = "post">
 <h1>Add a new Department</h1>
 <div class = "divtable">
 <div class = "divrow">
 <div class = "divcell">
Department Name:
</div>
<div class = "divcell">
<input type = "text" name = "name" id = "name"></input>
</div>
</div>
<H3>Select the College</H3>
 
<?php 
	echo "<div class = \"divrow\">";
	echo "<div class = \"divcell\">";
	echo "<input type = \"radio\" name = \"college\" checked = \"checked\" value = \"\">";
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo "Select College";
	echo "</div>";
	echo "</div>";
for($i=0;$i<count($colleges);$i++){
	echo "<div class = \"divrow\">";
	echo "<div class = \"divcell\">";
	echo "<input type = \"radio\" name = \"college\" value = \"{$colleges[$i]["collegeId"]}\">";
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo $colleges[$i]["name"];
	echo "</div>";
	echo "</div>";
}
?>
<h3>Select HOD</h3>
 
<?php 
	echo "<div class = \"divrow\">";
	echo "<div class = \"divcell\">";
	echo "<input type = \"radio\" name = \"lecturers\" checked = \"checked\" value = \"\">";
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo "Select an HOD";
	echo "</div>";
	echo "</div>";
for($i=0;$i<count($lecturers);$i++){
	echo "<div class = \"divrow\">";
	echo "<div class = \"divcell\">";
	echo "<input type = \"radio\" name = \"lecturers\" value = \"{$lecturers[$i]["id"]}\">";
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo $lecturers[$i]["fname"] . " ". $lecturers[$i]["lname"];
	echo "</div>";
	echo "</div>";
}
?>

<input type = "submit" name = "submit" value = "Submit"></input>
</div>
</fieldset>
</div>
 </form>
 </td>
 </tr>
 </table>
</div>
 </body>
 </html>