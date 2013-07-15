<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in() || (!isset($_GET["id"])) || (!isset($_GET["departmentid"]))){
	Header("Location: index.php");
}
else{
	$db = DatabaseWrapper::getInstance();
	$course = $db->query("select * from courses where code = '{$_GET["id"]}' and departmentId = '{$_GET["departmentid"]}';", "select");
	//var_dump($course);
	$this_lecturer = initLecturer();
}
?>

<html>
<head><title>Edit Course Code</title>
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
$key = "course";
$error_message->displayMessage("course");
$error_message->unsetMessage("course");
 
?>
<center><h2>Change the Course code of <?php echo $course[0]["name"]?></h2></center>
<form method = "post" action = "edit_course_code_backend.php?id=<?php echo $_GET["id"]?>&departmentid=<?php echo $_GET["departmentid"]?>" >	
 
<div class="divtable">
	<div class ="divrow">
    <div class = "divcell">
     Code:
     </div>
  <div class="divcell"><label for="code"></label>
  	<input type="text" name = "precode" size = 3>
    <input type="text" name="code" id="code" size = 3>  
    
    </div>
    </div>
    <div class = "divrow">
    <input type = "submit" name = "submit" value = "Submit"></input>
    </div>
    </div>
   </form>
	</td>
    
	    </tr>
 </table>
</div> 
</body>
</html>