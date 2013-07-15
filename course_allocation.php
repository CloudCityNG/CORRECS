<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in()){
	Header("Location: index.php");
}
else{
	$db = DatabaseWrapper::getInstance();
	$lecturer = $db->query("select * from lecturers where id = '{$_GET["id"]}';", "select");
	if($lecturer){
		$this_lecturer = Lecturer::instantiate($lecturer[0]);
	}
	$using_lecturer = initLecturer();
}
?>
<html>
<head>
<title>Course Allocation</title>
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
<h5>&nbsp;</p>
</td><td align="right"><h3><a href="logout.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp; </h3></td></tr>
<tr><td id="navigation">
<img src = "<?php echo $this_lecturer->photograph ;?>"  align = "center" height = 150 width = 150> 
 <br><br>
 <ul><li>
<a href = "lecturer_homepage.php"> Back to Lecturer Homepage</a>
</li>
<li><a href="department_admin_page.php?department=<?php echo $using_lecturer->deptId ?>">Back to Admin Dashboard</a>
</li></ul>
</td>
<td id="page">
<?php 
$error_message = FlashMessages::getInstance();
$key = "allocation";
$error_message->displayMessage("allocation");
$error_message->unsetMessage("allocation");

?>
<center><h2>Assign a Course to <?php $this_lecturer->fullName() ?></h2></center>
<form name = "reg" method = "post" action = "allocate_course.php?id=<?php echo $_GET["id"] ?>">
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
$first_year = $db->query("select * from courses where departmentId = '{$this_lecturer->deptId}' and level = 100 ;", "select");
if(!empty($first_year)){
	echo "<center><h2> FIRST YEAR COURSES</h2></center>";
for($i=0; $i < count($first_year); $i++){
echo "<div class = \"divrow\">";
echo "<div class = \"divcell\">";
echo "<input type = \"checkbox\" name = \"{$this_lecturer->id}[]\" value = {$first_year[$i]["code"]} >";
echo "</div>";

echo "<div class = \"divcell\">";
echo "<label for = \"{$this_lecturer->id}[]\"> {$first_year[$i]["code"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_lecturer->id}[]\"> {$first_year[$i]["name"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_lecturer->id}[]\"> {$first_year[$i]["units"]} </label>";
echo "</div>";


echo "<div class = \"divcell\">";
echo "<label for = \"{$this_lecturer->id}[]\"> {$first_year[$i]["semester"]} </label>";
echo "</div>";
echo "</div>";
}
}
$second_year = $db->query("select * from courses where departmentId = '{$this_lecturer->deptId}' and level = 200 ;", "select");
if(!empty($second_year)){
	echo "<center><h2> SECOND YEAR COURSES</h2></center>";
for($i=0; $i < count($second_year); $i++){
echo "<div class = \"divrow\">";
echo "<div class = \"divcell\">";
echo "<input type = \"checkbox\" name = \"{$this_lecturer->id}[]\" value = {$second_year[$i]["code"]} >";
echo "</div>";

echo "<div class = \"divcell\">";
echo "<label for = \"{$this_lecturer->id}[]\"> {$second_year[$i]["code"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_lecturer->id}[]\"> {$second_year[$i]["name"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_lecturer->id}[]\"> {$second_year[$i]["units"]} </label>";
echo "</div>";


echo "<div class = \"divcell\">";
echo "<label for = \"{$this_lecturer->id}[]\"> {$second_year[$i]["semester"]} </label>";
echo "</div>";
echo "</div>";
}
}
$third_year = $db->query("select * from courses where departmentId = '{$this_lecturer->deptId}' and level = 300 ;", "select");
if(!empty($third_year)){
	echo "<center><h2> THIRD YEAR COURSES</h2></center>";
for($i=0; $i < count($third_year); $i++){
echo "<div class = \"divrow\">";
echo "<div class = \"divcell\">";
echo "<input type = \"checkbox\" name = \"{$this_lecturer->id}[]\" value = {$third_year[$i]["code"]} >";
echo "</div>";

echo "<div class = \"divcell\">";
echo "<label for = \"{$this_lecturer->id}[]\"> {$third_year[$i]["code"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_lecturer->id}[]\"> {$third_year[$i]["name"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_lecturer->id}[]\"> {$third_year[$i]["units"]} </label>";
echo "</div>";


echo "<div class = \"divcell\">";
echo "<label for = \"{$this_lecturer->id}[]\"> {$third_year[$i]["semester"]} </label>";
echo "</div>";
echo "</div>";
}
}
$fourth_year = $db->query("select * from courses where departmentId = '{$this_lecturer->deptId}' and level = 400 ;", "select");
if(!empty($second_year)){
	echo "<center><h2> FOURTH YEAR COURSES</h2></center>";
for($i=0; $i < count($fourth_year); $i++){
echo "<div class = \"divrow\">";
echo "<div class = \"divcell\">";
echo "<input type = \"checkbox\" name = \"{$this_lecturer->id}[]\" value = {$fourth_year[$i]["code"]} >";
echo "</div>";

echo "<div class = \"divcell\">";
echo "<label for = \"{$this_lecturer->id}[]\"> {$fourth_year[$i]["code"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_lecturer->id}[]\"> {$fourth_year[$i]["name"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_lecturer->id}[]\"> {$fourth_year[$i]["units"]} </label>";
echo "</div>";


echo "<div class = \"divcell\">";
echo "<label for = \"{$this_lecturer->id}[]\"> {$fourth_year[$i]["semester"]} </label>";
echo "</div>";
echo "</div>";
}
}

?>
</div>
<input type = "submit" name = "allocate" value = "Allocate"></input>
</form>

 </td>
 </tr>
 </table>
</div> 
</body>
</html>