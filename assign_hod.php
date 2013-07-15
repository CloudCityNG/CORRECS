<?php
session_start(); 
require_once("includes/initialize.php");
if(!is_logged_in()){
	Header("Location: index.php");
	
}
else{
	$db = DatabaseWrapper::getInstance();
	$departments = $db->query("select * from departments;", "select");
	$lecturers = $db->query("select * from lecturers;", "select");
	
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<link href="stylesheets.css" rel="stylesheet" type="text/css" />

<title>Assign  an HOD</title>

<link type="text/css" rel="stylesheet" href="css/login.css" media="all" /> 
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/box_design.css" media="all" />
<link type="text/css" rel="stylesheet" href="css/public.css" media="all"  />
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
<li>
<h3><a href="logout.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp; </h3></li><ul></td>
 <td id="page">
 <?php 
$error_message = FlashMessages::getInstance();
$key = "HOD";
$error_message->displayMessage("HOD");
$error_message->unsetMessage("HOD");

?>
 <h1>Assign an HOD to a Department</h1>
 <form method = "post" action = "assign_hod_backend.php">
 <h3> First Select the Department</h3>
<div class = "divtable">
<?php 
echo "<div class = \"divrow\">";
echo "<div class = \"divcell\">";
echo "<input type  = \"radio\" name = \"department\" checked = \"checked\" value = \"\">";
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
<h3> Now select a Lecturer as HOD</h3>
<?php 
echo "<div class = \"divrow\">";
echo "<div class = \"divcell\">";
echo "<input type  = \"radio\" name = \"lecturers\" checked = \"checked\" value = \"\">";
echo "</div>";
echo "<div class = \"divcell\">";
echo "Select a Lecturer";
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
<input type = "submit" name = "submit" value = "Assign"></input>
</div>
 </form>
 </td>
 </tr>
 </table>
</div>
</body>
</html>