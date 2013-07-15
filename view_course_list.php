<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in()){
	Header("Location: index.php");
}
else{
	$db = DatabaseWrapper::getInstance();
	$this_lecturer  = initLecturer();

	//$course_list  = $db->query("select * from courses where departmentId = '{$this_lecturer->deptId}';", "select");
}
?>
<html>
<head>
<title>list of Courses in Department</title>
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
<li><a href="department_admin_page.php?department=<?php echo $this_lecturer->deptId ?>">Back to Admin Dashboard</a>
</li></ul>
</td>
<td id="page">
<div id="content">
<fieldset><legend><h3>Courses In the Department</h3></legend>
<form name = "reg" method = "post" action = "course_info.php">
<div class = "divtable">
<div class = "divrow">
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

echo "<div class = \"divcell\" >";
echo " {$first_year[$i]["code"]}";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<a href = \"course_info.php?id={$first_year[$i]["code"]}&departmentid={$first_year[$i]["departmentId"]}\"> {$first_year[$i]["name"]}</a>";
echo "</div>";
echo "<div class = \"divcell\" align=\"center\">";
echo $first_year[$i]["units"];
echo "</div>";
echo "<div class = \"divcell\">";
echo $first_year[$i]["semester"];
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
echo " {$second_year[$i]["code"]}";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<a href = \"course_info.php?id={$second_year[$i]["code"]}&departmentid={$second_year[$i]["departmentId"]}\"> {$second_year[$i]["name"]}</a>";
echo "</div>";
echo "<div class = \"divcell\" align=\"center\">";
echo $second_year[$i]["units"];
echo "</div>";
echo "<div class = \"divcell\">";
echo $second_year[$i]["semester"];
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
echo " {$third_year[$i]["code"]}";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<a href = \"course_info.php?id={$third_year[$i]["code"]}&departmentid={$third_year[$i]["departmentId"]}\"> {$third_year[$i]["name"]}</a>";
echo "</div>";
echo "<div class = \"divcell\" align=\"center\">";
echo $third_year[$i]["units"];
echo "</div>";
echo "<div class = \"divcell\">";
echo $third_year[$i]["semester"];
echo "</div>";
echo "</div>";
}
}
$fourth_year = $db->query("select * from courses where departmentId = '{$this_lecturer->deptId}' and level = 400 ;", "select");
if(!empty($fourth_year)){
	echo "<center><h2> FOURTH YEAR COURSES</h2></center>";
for($i=0; $i < count($fourth_year); $i++){
echo "<div class = \"divrow\">";

echo "<div class = \"divcell\">";
echo " {$fourth_year[$i]["code"]}";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<a href = \"course_info.php?id={$fourth_year[$i]["code"]}&departmentid={$fourth_year[$i]["departmentId"]}\"> {$fourth_year[$i]["name"]}</a>";
echo "</div>";
echo "<div class = \"divcell\" align=\"center\">";
echo $fourth_year[$i]["units"];
echo "</div>";
echo "<div class = \"divcell\">";
echo $fourth_year[$i]["semester"];
echo "</div>";
echo "</div>";
}
}

?>
</div>
<input type = "submit" name = "allocate" value = "Allocate"></input>
</form>
</fieldset>
</div>
</td>
 </tr>
 </table>
</div>
</body>
</html>