<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in() && !isset($_GET["course"]) && !isset($_GET["studentId"])){
	Header("Location: index.php");
	
}
else{
	$this_lecturer = initLecturer();
	$db = DatabaseWrapper::getInstance();
	$lecturer_courses = $db->query("select * from courses where lecturerId = '{$this_lecturer->id}';", "select");
	//echo $_GET["id"];
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<title>Input <?php echo $_GET["course"]?> marks for <?php echo $_GET["matric"] ?></title>
<link href="stylesheets.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="script.js">
</script>	
<link type="text/css" rel="stylesheet" href="css/login.css" media="all" /> 
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/box_design.css" media="all" />
<link type="text/css" rel="stylesheet" href="css/public.css" media="all" />
</head>

 <body>
 
<?php include("includes/header.php");?>
<div id="container">
<table>
<tr><td id="navigation">
<ul>
<li><a href="index.php">Cancel</a></li>
</ul>
</td>
<td id="page">
<div id="content">
 <?php 
$student = $db->query("select * from student_info where id = '{$_GET["studentId"]}';", "select");
$this_student = Student::instantiate($student[0]);
//var_dump($student);



?>
<h3> Input marks for <?php $this_student->fullName()?></h3>

<form method = "post" action = "accept_student_score.php?studentId=<?php echo $_GET["studentId"]?>&course=<?php echo $_GET["course"]?>">
<div class = "divtable">
<div class = "divrow">
<div class = "divcell">
C.A.:
</div>
<div class = "divcell">
<input type = "text" name = "ca" size = "6" />
</div>
</div>
<div class = "divrow">
<div class = "divcell">
Exam: 
</div>
<div class = "divcell">
<input type = "text" name = "exam" size = "6" />
</div>
</div>
<input type = "submit" name = "submit"></input>
</div>

</form>
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