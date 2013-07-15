<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in()  || (!isset($_GET["department"]))){
	Header("Location: index.php");
	
}else{
	$db = DatabaseWrapper::getInstance();
	$this_lecturer = initLecturer();
	$department = $db->query("select * from departments where deptId = '{$this_lecturer->deptId}';","select");
	
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<title><?php echo $department[0]["deptName"]?> Admin Page</title>
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
<li><a href="department_admin_page.php?department=<?php echo $this_lecturer->deptId ?>"">Back to Admin Dashboard</a>
</li></ul>
</td>
<td id="page">
 <h2 align="center" >Welcome <?php $this_lecturer->fullName();?> </h2>
 <div id="content">
 <fieldset><legend> <h3>Main Menu</h3></legend>
 <p>
 <a href="add_new_lecturer.php?department=<?php echo $_GET["department"]?>&college=<?php echo $this_lecturer->collegeId ?>"> Create a new Lecturer</a><br/>
 Create a new Lecturer in your department
 </p>
 <a href = "view_lecturer_list.php?department=<?php echo $_GET["department"]?>">Lecturer List </a><br />
 Through this you can Edit Information about the Lecturer and Assign him/her to a course
<p> <a href="add_new_course.php?department=<?php echo $_GET["department"]?>"> Create a new course</a> <br />
Add a new Course.
</p>
<p><a href = "view_course_list.php?department=<?php echo $_GET["department"]?>">Course List</a> <br />
Manage Courses offered in the Department
</p>
<p><a href = "student_list.php?department=<?php echo $_GET["department"]?>">Student List</a> <br />
View the List of Students in the Department
 </fieldset>
 </div>
 </td>
 </tr>
 </table>
</div> 
 </body>
 </html>