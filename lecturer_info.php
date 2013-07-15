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
<title> <?php $this_lecturer->fullName() ?></title>
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
<h5><?php echo $using_lecturer->fullName() ?></h5></p>
</td><td align="right"><h3><a href="logout.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp; </h3></td></tr>
<tr><td id="navigation">
<img src = "<?php echo $using_lecturer->photograph ;?>"  align = "center" height = 150 width = 150> 
 <br><br>
 <ul><li>
<a href = "lecturer_homepage.php"> Back to Lecturer Homepage</a>
</li>
<li><a href="department_admin_page.php?department=<?php echo $using_lecturer->deptId ?>">Back to Admin Dashboard</a>
</li></ul>
</td>
<td id="page">
<h2><?php echo $this_lecturer->fullName()?></h2>

<p> 
 <img src = "<?php echo $this_lecturer->photograph ;?>"  align = "center" height = 200 width = 200> 

<p><a href = "change_password.php?id=<?php echo $this_lecturer->id ?>"> Change Password</a></p>

<p><a href = "course_allocation.php?id=<?php echo $this_lecturer->id ?>"> Assign to A Course</a></p>

<p><a href = "level_adviser_allocation.php?id=<?php echo $this_lecturer->id ?>">Assign to a Level (as level adviser)</a></p>

<p><a href = "delete_lecturer.php?id=<?php echo $this_lecturer->id ?>">Delete This Account</a></p>

</td>
 </tr>
 </table>
</div> 
</body>
</html>