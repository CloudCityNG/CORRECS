<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in() || (!isset($_GET["id"])) || (!isset($_GET["departmentid"]))){
	Header("Location: index.php");
}
else{
	$db = DatabaseWrapper::getInstance();
	$course = $db->query("select * from courses where code = '{$_GET["id"]}' and departmentId = '{$_GET["departmentid"]}';", "select");
	
	$selected_courses = $db->query("select * from courses where departmentId = '{$_GET["departmentid"]}' and level < '{$course[0]["Level"]}';", "select");
	//var_dump($selected_courses);
	$this_lecturer = initLecturer();
}

?>
<html>
<head>
<title>Assigning Prerequisites to Courses</title>
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
<h5><?php echo $this_lecturer->fullName(); ?>&nbsp;</h5></p>
</td><td align="right"><h3><a href="logout.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp; </h3></td></tr>
<tr><td id="navigation">
<img src = "<?php echo $this_lecturer->photograph ;?>"  align = "center" height = 150 width = 150> 
 <br><br>
 <ul><li>
<a href = "lecturer_homepage.php"> Back to Lecturer Homepage</a>
</li>
<li><a href="department_admin_page.php?department=<?php echo $this_lecturer->deptId ?>">Back to Admin Dashboard</a>
</li></ul>
</td>
<td id="page">
<?php 
$error_message = FlashMessages::getInstance();
$key = "prerequisite";
$error_message->displayMessage("prerequisite");
$error_message->unsetMessage("prerequisite");
 
?>
<center><h2>Assign a prerequisite to <?php echo $course[0]["code"]?></h2></center>
<form name = "reg" method = "post" action = "assign_prerequisite_backend.php?id=<?php echo $_GET["id"]?>&departmentid=<?php echo $_GET["departmentid"] ?>">
<div class = "divtable">
<div class = "divrow">
<div class = "divcell">
Select Course
</div>
<div class = "divcell">
Course Code
</div>
<div class = "divcell">
Course Title
</div>
<div class = "divcell">
Units
</div>
<div class = "divcell">
Semester
</div>
</div>
<?php 

if(!empty($selected_courses)){
	echo "<center><h2> DEPARTMENT COURSES</h2></center>";
for($i=0; $i < count($selected_courses); $i++){
echo "<div class = \"divrow\">";
echo "<div class = \"divcell\">";
echo "<input type = \"radio\" name = \"{$course[0]["code"]}\" value = {$selected_courses[$i]["code"]} >";
echo "</div>";

echo "<div class = \"divcell\">";
echo "<label for = \"{$course[0]["code"]}\"> {$selected_courses[$i]["code"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$course[0]["code"]}\"> {$selected_courses[$i]["name"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$course[0]["code"]}\"> {$selected_courses[$i]["units"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$course[0]["code"]}[]\"> {$selected_courses[$i]["semester"]} </label>";
echo "</div>";
echo "</div>";
}
}




?>
</div>
<input type = "submit" name = "assign" value = "assign"></input>
</form>

 </td>
 </tr>
 </table>
</div> 
</body>
</html>
