<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in() || (!isset($_GET["id"])) || (!isset($_GET["departmentid"]))){
	Header("Location: index.php");
}
else{
	$db = DatabaseWrapper::getInstance();
	$course = $db->query("select * from courses where code = '{$_GET["id"]}' and departmentId = '{$_GET["departmentid"]}';", "select");
	$this_lecturer = initLecturer();
	$select_lecturers = $db->query("select * from lecturers where deptId = '{$this_lecturer->deptId}';", "select");
	$all_lecturers = $db->query("select * from lecturers where deptId != '{$this_lecturer->deptId}';","select");
}

?>
<html>
<head>
<link href="stylesheets.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/login.css" media="all" /> 
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/public.css" media="all" />
<script type="text/javascript" src="script.js">
</script>
<title>Lecturer List</title>
<link href="stylesheets.css" rel="stylesheet" type="text/css" />
</head>
<body>
<body>
<?php include("includes/header.php");?>
<div id="container">
<table>
<tr><td id="navigation">
<ul>
<li>
<a href="logout.php">Logout</a></li>
<li>
<a href = "lecturer_homepage.php"> Back to Lecturer Homepage</a>
</li>
<li><a href="department_admin_page.php?department=<?php echo $this_lecturer->deptId ?>">Back to Admin Dashboard</a>
</li></ul>
</td>
<td id="page">
<?php 
$error_message = FlashMessages::getInstance();
$key = "course_allocation";
$error_message->displayMessage("course_allocation");
$error_message->unsetMessage("course_allocation");
?>
<form method = "post" action = "course_allocation2_backend.php?id=<?php echo $_GET["id"] ?>&departmentid=<?php echo $_GET["departmentid"] ?>" >	
<h2>Assign <?php echo $course[0]["code"]?> To a Lecturer</h2>
<h2>List of Lecturers in the Department</h2>

<div class = "divtable">
<div class = "divrow">

<div class = "divcell">
Select Lecturer
</div>
<div class = "divcell">
Lecturer Name
</div>
</div>
<?php 
if(!empty($select_lecturers)){
	for($i=0; $i < count($select_lecturers);$i++){
		
		echo "<div class = \"divrow\">";
		echo "<div class = \"divcell\">";
		echo "<input type = \"radio\" name = \"{$course[0]["code"]}\" value = \"{$select_lecturers[$i]["id"]}\" />";
		echo "</div>";
		echo "<div class = \"divcell\">";
		echo "<a href = \"lecturer_info.php?id={$select_lecturers[$i]["id"]}\">{$select_lecturers[$i]["fname"]} {$select_lecturers[$i]["lname"]} </a>";
		echo "</div>";
		echo "</div>";
}
}
?>
<h2>Lecturers in other departments</h2>
</div>
<div class = "divtable">
<div class = "divrow">

<div class = "divcell">
Select Lecturer
</div>
<div class = "divcell">
Lecturer Name
</div>
</div>
<?php 
if(!empty($all_lecturers)){
	for($i=0; $i < count($all_lecturers);$i++){
		
		echo "<div class = \"divrow\">";
		echo "<div class = \"divcell\">";
		echo "<input type = \"radio\" name = \"{$course[0]["code"]}\" value = \"{$all_lecturers[$i]["id"]}\" />";
		echo "</div>";
		echo "<div class = \"divcell\">";
		echo "<a href = \"lecturer_info.php?id={$all_lecturers[$i]["id"]}\">{$all_lecturers[$i]["fname"]} {$all_lecturers[$i]["lname"]} </a>";
		echo "</div>";
		echo "</div>";
}
}
?>
</div>
<input type = "submit" name = "submit" value = "submit"></input>
</form>
<?php 
/* if(isset($_POST["submit"])){
	if(!isset($_POST["{$course[0]["code"]}"])){
		echo "Please select a lecturer <br />";
	}
	else{
		$lecturerId = $_POST["{$course[0]["code"]}"];
		$update = $db->query("update courses set lecturerId = ? where code = ? and departmentId = ?;", $lecturerId, $course[0]["code"], $_GET["departmentid"], "update");
		
		if($update){
			echo "Successfully Allocated <br />";
			echo "<a href = \"department_admin_page.php\">Go Back </a>";
		}
		else{
			echo "failed";
		}
	}
	
} */
?>
</td>
 </tr>
 </table>
</div> 
</body>
</html>