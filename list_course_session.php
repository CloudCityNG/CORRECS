<?php 
session_start();
require_once("includes/initialize.php");
if(!is_logged_in()){
	Header("Location: index.php");
	
}
else{
	$this_student = initStudent();
	$db = DatabaseWrapper::getInstance();
	$universitySession = $db->query("select currentSession from university where name = 'Fountain University Osogbo';", "select");
	$session_courses = $db->query("select * from coursestaken where studentId = '{$this_student->id}' and session = '{$universitySession[0]["currentSession"]}';", "select");
}
?>
<html>
<head><title>Courses for the Session</title>
<link type="text/css" rel="stylesheet" href="css/login.css" media="all" /> 
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/box_design.css" media="all" />
<link type="text/css" rel="stylesheet" href="css/public.css" media="all" />
<link href="stylesheets.css" rel="stylesheet" type="text/css" />

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
<a href="logout.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp; </li>
<li><a href="student_homepage.php"> Back to student homepage</a></li></ul></td>
 <td id="page">
 <?php 

 $flash_message = FlashMessages::getInstance();
 $key = "course";
 $flash_message->displayMessage("course");
 $flash_message->unsetMessage("course");
 
 ?>

<h2>Courses You are offering this Session</h2>
<div class = "divtable">
<?php 
if(!empty($session_courses)){
	echo "<h2>FIRST SEMESTER</h2>";
		echo "<div class = \"divrow\">";
		echo "<div class = \"divcell\">";
		echo "Course Code";
		echo "</div>";
		echo "<div class = \"divcell\">";
		echo "Course Title";
		echo "</div>";
		echo "</div>";
	for($i=0; $i < count($session_courses); $i++){
		$course = $db->query("select * from courses where code = '{$session_courses[$i]["courseCode"]}';", "select");
		if(!empty($course)){
		if($session_courses[$i]["semester"] == 1){
			echo "<div class = \"divrow\">";
			echo "<div class = \"divcell\">";
			echo $course[0]["code"];
			echo "</div>";
			echo "<div class = \"divcell\">";
			echo "<a href = \"course_details.php?code={$course[0]["code"]}\">{$course[0]["name"]}</a>";
			echo "</div>";
			echo "<div class = \"divcell\">";
			echo " &nbsp";
			echo "</div>";
			echo "<div class = \"divcell\">";
			echo "<a href = \"unregister_course.php?code={$course[0]["code"]}\">unregister</a>";
			echo "</div>";
			echo "</div>";
			}
		}
	}
	echo "<h2>SECOND SEMESTER</h2>";
		echo "<div class = \"divrow\">";
		echo "<div class = \"divcell\">";
		echo "Course Code";
		echo "</div>";
		echo "<div class = \"divcell\">";
		echo "Course Title";
		echo "</div>";
		echo "</div>";
	for($i=0; $i < count($session_courses); $i++){
		$course = $db->query("select * from courses where code = '{$session_courses[$i]["courseCode"]}';", "select");
		if(!empty($course)){
		if($session_courses[$i]["semester"] == 2){
			echo "<div class = \"divrow\">";
			echo "<div class = \"divcell\">";
			echo $course[0]["code"];
			echo "</div>";
			echo "<div class = \"divcell\">";
			echo "<a href = \"course_details.php?code={$course[0]["code"]}\">{$course[0]["name"]}</a>";
			echo "</div>";
			echo "<div class = \"divcell\">";
			echo " &nbsp";
			echo "</div>";
			echo "<div class = \"divcell\">";
			echo "<a href = \"unregister_course.php?code={$course[0]["code"]}\">unregister</a>";
			echo "</div>";
			echo "</div>";
			}
		}
	}
}
?>
</div>
</td>
 </tr>
 </table>
</div>
</body>
</html>