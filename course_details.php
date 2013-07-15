<?php 
session_start();
require_once("includes/initialize.php");
if(!is_logged_in() || (!isset($_GET["code"]))){
	Header("Location: index.php");
	
}
else{
	
	$db = DatabaseWrapper::getInstance();
	if($_SESSION["category"] == "student")
		$user = initStudent();
	elseif($_SESSION["category"] == "lecturer")
		$user = initLecturer();
	if(!preg_match("(GNS.[0-9])", $_GET["code"]))
	$course = $db->query("select * from courses where code = '{$_GET["code"]}' and departmentId = '{$user->deptId}';", "select");
	
	else
	$course = $db->query("select * from courses where code = '{$_GET["code"]}';", "select");
	
	$materials = $db->query("select * from course_materials where courseCode = '{$_GET["code"]}';", "select");
	//$session_courses = $db->query("select * from coursestaken where studentId = '{$this_student->id}' and session = '{$universitySession[0]["currentSession"]}';", "select");
}
?>
<html>
<head><title><?php echo $course[0]["name"]?></title>
<link href="stylesheets.css" rel="stylesheet" type="text/css" />
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
<h5><?php echo $user->fullName(); ?></h5></p>
</td><td align="right"><h3><a href="logout.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp; </h3></td></tr>
<tr><td id="navigation">
<img src = "<?php echo $user->photograph ;?>"  align = "center" height = 150 width = 120>

<br>
<ul>
<?php 
if($_SESSION["category"] == "student")
echo "<li><a href=\"student_homepage.php\">Student Homepage</a><br>";
else 
	echo "<li><a href=\"lecturer_homepage.php\">Lecturer Homepage</a><br>";
?>
</li>
</ul>
</td>
<td id="page">
<h2><?php echo $course[0]["name"]?></h2>
<div class = "divtable">
<div class = "divrow">
<div class = "divcell">
Course Code: 
</div>
<div class = "divcell">
<?php echo $course[0]["code"]?>
</div>
</div>
<div class = "divrow">
<div class = "divcell">
Units: 
</div>
<div class = "divcell">
<?php echo $course[0]["units"]?>
</div>
</div>
<div class = "divrow">
<div class = "divcell">
status: 
</div>
<div class = "divcell">
<?php if($course[0]["status"] == "C")
echo "Compulsory";
elseif($course[0]["status"] == "E")
echo "Elective";
?>
</div>
</div>
<div class = "divrow">
<div class = "divcell">
Description: 
</div>
<div class = "divcell">
<?php echo $course[0]["description"]?>
</div>
</div>
<div class = "divrow">
<div class = "divcell">
Lecturer: 
</div>
<div class = "divcell">
<?php 
$lecturer = $db->query("select * from lecturers where id = '{$course[0]["lecturerId"]}';", "select");
if($lecturer){
	echo "{$lecturer[0]["fname"]} {$lecturer[0]["lname"]}";
}
echo "<img src = \"{$lecturer[0]["photograph"]}\"  height = 150 width = 150 alt = \"{$lecturer[0]["fname"]} {$lecturer[0]["lname"]}\">"
?>
</div>
</div>
<div class = "divrow">
<div class = "divcell">
 
</div>
<div class = "divcell">
<?php ?>
</div>
</div>
<div class = "divrow">
<div class = "divcell">
Prerequisite: 
</div>
<div class = "divcell">
<?php 
$prereq = $db->query("select * from prerequisite where id = '{$course[0]["prerequisiteId"]}';", "select");
if(!empty($prereq)){
	echo "{$prereq[0]["courseCode"]}";
}
else{
	echo "None";
}
?>
</div>
</div>


</div>
<?php 
if(!empty($materials)){
	echo "<h3>Uploaded Course Material</h3>";
	echo "<div class = \"divtable\">";
	echo "<div class = \"divrow\">";
	echo "<div class = \"divcell\">";
	echo "Session Uploaded";
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo "Download Link";
	echo "</div>";
	echo "</div>";
	for($i=0;$i<count($materials);$i++){
		echo "<div class = \"divrow\">";
		echo "<div class = \"divcell\">";
		echo $materials[$i]["session_uploaded"];
		echo "</div>";
		echo "<div class = \"divcell\">";
		echo "<a href = \"{$materials[$i]["path"]}\"> download</a>";
		echo "</div>";
		echo "</div>";
	}
	echo "</div>";
}
?>
</td>
 </tr>
 </table>
</div>
</body>
</html>