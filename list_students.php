<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in() && !isset($_GET["programmeId"])  && !isset($_GET["entryYear"])){
	Header("Location: index.php");
	
}
else{
	$db = DatabaseWrapper::getInstance();
	$list_students = $db->query("select * from student_info where entryYear = '{$_GET["entryYear"]}' and programmeId = '{$_GET["programmeId"]}';", "select");
	$de_entry = $_GET["entryYear"] + 1;
	
	$list_students2 = $db->query("select * from student_info where entryYear = '{$de_entry}' and programmeId = '{$_GET["programmeId"]}' and (modeOfEntry = 'DFP' or modeOfEntry = 'DE');", "select");
	
	$this_lecturer = initLecturer();
	$student_list = array_merge($list_students, $list_students2);
	
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">	
<title>List of Students in Your Class</title>
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
<h5><?php echo $this_lecturer->fullName(); ?></h5></p>
</td><td align="right"><h3><a href="logout.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp; </h3></td></tr>
<tr><td id="navigation">
<img src = "<?php echo $this_lecturer->photograph ;?>"  align = "center" height = 150 width = 150> 
 <br><br>
<ul>
<li>
<a href = "lecturer_homepage.php"> Back to Lecturer Homepage</a>
</li>
</ul>
</td>
<td id="page">
<div id="content">
<fieldset><legend><h3>List of Students in Your Class</h3></legend>
 <div class = "divtable">
<div class = "divrow">
<div class = "divcell">
Student Name
</div>
<div class = "divcell">
Matric Number
</div>
</div>
 <?php 
 for($i=0;$i < count($student_list); $i++){
	
	//var_dump($matric_no);
	$this_student = Student::instantiate($student_list[$i]);
	echo "<div class = \"divrow\">";
	echo "<div class = \"divcell\">";
	echo $this_student->fullName();
	echo "</div>";
	echo "<div class = \"divcell\">";
	
	echo "<a href = \"calculate_result_pdf.php?studentId={$this_student->id}&matric={$this_student->matricNo}\"> {$this_student->matricNo}</a> ";
	echo "</div>";
	echo "</div>";
 }	
 ?>
 <div class = "divrow">
 <div class = "divcell">
 <h3>Generate Result Sheets</h3>
 <a href = "result_pdf.php">Generate Sheet</a> <br />
<a href = "summary_sheet_pdf.php">Summary Sheet</a> <br />
 </div>
 </div>
 <div class = "divrow">
 <div class = "divcell">
 <h3>Promote Students</h3>
 <a href = "promote_student.php">Promote students</a> <br />

 </div>
 </div>
 </div>
 
 </fieldset>
 </div>
 </td>
 </tr>
 </table>
</div> 
 </body>
 </html>