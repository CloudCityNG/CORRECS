<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in() || (!isset($_GET["id"])) || (!isset($_GET["departmentid"]))){
	Header("Location: index.php");
}
else{
	$db = DatabaseWrapper::getInstance();
		$this_lecturer  = initLecturer();

	$course = $db->query("select * from courses where code = '{$_GET["id"]}' and departmentId = '{$_GET["departmentid"]}';", "select");
	//var_dump($course);
}
?>
<html>
<head>
<title> <?php echo "{$course[0]["name"]}" ?></title>
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
 <ul><li>
<a href = "lecturer_homepage.php"> Back to Lecturer Homepage</a>
</li>
<li><a href="department_admin_page.php?department=<?php echo $this_lecturer->deptId ?>">Back to Admin Dashboard</a>
</li></ul>
</td>
<td id="page">
<div id="content">
 <?php 
$error_message = FlashMessages::getInstance();
$key = "course";
$error_message->displayMessage("course");
$error_message->unsetMessage("course");
 
?>
<fieldset><legend><h3><?php echo "{$course[0]["code"]} : {$course[0]["name"]}" ?></h3></legend>

<p><a href = "course_allocation2.php?id=<?php echo $_GET["id"]?>&departmentid=<?php echo $_GET["departmentid"]?>">Assign the course to A lecturer</a> <br />
</p>
<P><a href = "edit_course_code.php?id=<?php echo $_GET["id"]?>&departmentid=<?php echo $_GET["departmentid"]?>"> Edit course code of the course</a> <br />
</P>
<p><a href = "edit_course_name.php?id=<?php echo $_GET["id"]?>&departmentid=<?php echo $_GET["departmentid"]?>">Edit Course Name</a> <br />
</p>
<p><a href = "edit_course_description.php?id=<?php echo $_GET["id"]?>&departmentid=<?php echo $_GET["departmentid"]?>">Edit course Description</a> <br />
</p>


<?php 

if($course[0]["Level"] > 100){

echo "<p><a href = \"assign_prerequisite.php?id={$_GET["id"]}&departmentid={$_GET["departmentid"]}\">Assign the course a prerequisite</a> <br />";
echo "</p>";

}
?>

<!--  <p><a href = "edit_course_name.php?id=<?php echo $_GET["id"]?>&departmentid=<?php echo $_GET["departmentid"]?>">Edit Course Name</a> <br />
</p>-->
</fieldset>
</div>
 </td>
 </tr>
 </table>
</div> 
</body>
</html>