<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in()){
	Header("Location: index.php");
	
}
else{

	$this_lecturer = initLecturer();
	$db = DatabaseWrapper::getInstance();
	$lecturer_courses = $db->query("select * from courses where lecturerId = '{$this_lecturer->id}';", "select");
	//$gns = $db->query("select * from gns_courses where lecturerId = '{$this_lecturer->id}';", "select");
		$level_adviser = $db->query("select * from level_advisers where lecturerId = '{$this_lecturer->id}';", "select");
	$hod = $db->query("select * from departments where hodId = '{$this_lecturer->id}';", "select");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<title>Home</title>
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
<li >
<a href = "lecturer_homepage.php"> Back to Lecturer Homepage</a>
</li>
<?php 
if(!empty($hod)){
echo "<li><a href=\"department_admin_page.php?department={$this_lecturer->deptId} \">HOD Admin Page</a>";
echo "</li>";
}
?></ul>
</td>
<td id="page">
<div id="content">

 	<h2 align="center">Lecturer Home Page</h2>
 	
 	<p>Welcome <?php echo $this_lecturer->fullName(); ?> </p>
	<p> 
 		</p>
        <fieldset><legend>
 	<h3>Main Menu</h3></legend>
 	
 	<?php 
 	if(!empty($lecturer_courses)){
 		echo "<h3>Courses you are Handling this Session</h3>";
 	for($i=0; $i< count($lecturer_courses);$i++){
 		$name = $db->query("select name from programmes where programmeId ='{$lecturer_courses[$i]["programmeId"]}';", "select");
 		
 		
 		echo "<p> <a href = \"lecturer_course_admin.php?id={$lecturer_courses[$i]["code"]}&dept={$lecturer_courses[$i]["departmentId"]}\"> {$lecturer_courses[$i]["code"]}  for {$lecturer_courses[$i]["Level"]}  {$name[0]["name"]} students </a> </p>";
 	}
 	}
 	
 	?>
 	
 	<?php 
 		$level_adviser = $db->query("select * from level_advisers where lecturerId = '{$this_lecturer->id}';", "select");
 		if(!empty($level_adviser)){
			echo "<h3>Level Adviser Access</h3>";
 			$programme_name = $db->query("select name from programmes where programmeId = '{$level_adviser[0]["programmeId"]}';","select");
 			echo "<a href = \"list_students.php?programmeId={$level_adviser[0]["programmeId"]}&entryYear={$level_adviser[0]["entryYear"]}&name={$programme_name[0]["name"]}\"> Generate Result for {$level_adviser[0]["entryYear"]}  {$programme_name[0]["name"]} students </a>";
 		}
 		
 		$hod = $db->query("select * from departments where hodId = '{$this_lecturer->id}';", "select");
 		if(!empty($hod)){
 			echo "<h3>HOD ACCESS</h3>";
 			echo "<p><a href = \"department_admin_page.php?department={$this_lecturer->deptId}\"> {$hod[0]["deptName"]} Admin Page </a>";
 		}
 	?>
 	
    </fieldset>
    </div>
	</td>
 </tr>
 </table>
</div> 
 	</body>
 	</html>