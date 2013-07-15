<?php
session_start();
require_once("includes/initialize.php");
if((!is_logged_in()) || (!isset($_GET["id"])) || (!isset($_GET["dept"]))){
	Header("Location: index.php");
	
}
else{

	$this_lecturer = initLecturer();
	$db = DatabaseWrapper::getInstance();
	$hod = $db->query("select * from departments where hodId = '{$this_lecturer->id}';", "select");
	$course = $db->query("select * from courses where code = '{$_GET["id"]}' and departmentId = '{$_GET["dept"]}';", "select");
	if(empty($course) || (count($course) > 1)){
		header("Location: lecturer_homepage.php");
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<title><?php echo $course[0]["code"] ?></title>
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
<?php
$error_message = FlashMessages::getInstance();
$key = "mark_recording";
$error_message->displayMessage("mark_recording");
$error_message->unsetMessage("mark_recording");

?>
<h3><?php echo "{$course[0]["code"]}: {$course[0]["name"]}  "?></h3>
<p><a href = "course_details.php?code=<?php echo $course[0]["code"] ?>"> Details About the Course</a> 

</p>
 <p>
 <a href = "input_scores.php?id=<?php echo $_GET["id"] ?>&dept=<?php echo $_GET["dept"] ?>">Input Student scores for this session</a>
 </p>
<p>
 <a href = "upload_course_material.php?id=<?php echo $_GET["id"] ?>&dept=<?php echo $_GET["dept"] ?>">Upload Course Material</a>
 </p>
</td>
</tr>
</table>
</div>
</body>
</html>