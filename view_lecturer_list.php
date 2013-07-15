<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in()){
	Header("Location: index.php");
}
else{
	$db = DatabaseWrapper::getInstance();
	$this_lecturer  = initLecturer();

	$lecturer_list  = $db->query("select * from lecturers where deptId = '{$this_lecturer->deptId}';", "select");
	//var_dump($lecturer_list);
}
?>
<html>
<head>
<link href="stylesheets.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="script.js">
</script>	
<link type="text/css" rel="stylesheet" href="css/login.css" media="all" /> 
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/box_design.css" media="all" />
<link type="text/css" rel="stylesheet" href="css/public.css" media="all" />
<title>Lecturer List</title>
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
<li><a href="department_admin_page.php?department=<?php $this_lecturer->deptId ?>">Back to Admin Dashboard</a>
</li></ul>
</td>
<td id="page">
<h2>List of Lecturers in the Department</h2>
<div class = "divtable">
<div class = "divrow">
<div class = "divcell">
s/n
</div>
<div class = "divcell">
Lecturers Name
</div>
</div>
<?php 
for($i=0;$i<count($lecturer_list); $i++){
	$new_lecturer = Lecturer::instantiate($lecturer_list[$i]);
	echo "<div class = \"divrow\">";
	echo "<div class = \"divcell\">";
	echo $i + 1;
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo "<a href = \"lecturer_info.php?id={$new_lecturer->id}\">{$new_lecturer->fname} {$new_lecturer->lname}</a>";
	echo "</div>"; 
	echo "</div>";
}
?>

</div>
</td>
 </tr>
 </table>
</div>
</body>
</html>