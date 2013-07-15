<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in()){
	Header("Location: index.php");
}
else{
	$db = DatabaseWrapper::getInstance();
	$lecturer = $db->query("select * from lecturers where id = '{$_GET["id"]}';", "select");
	$using_lecturer = initLecturer();
	if($lecturer){
		$this_lecturer = Lecturer::instantiate($lecturer[0]);
	}
}
?>
<html>
<head>
<title> Delete Lecturer </title>
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
<li><a href="department_admin_page.php?department=<?php echo $using_lecturer->deptId ?>">Back to Admin Dashboard</a>
</li></ul>
</td>
<td id="page">
<form method = "post" action = "<?php echo "{$_SERVER["PHP_SELF"]}?id={$_GET["id"]}"?>">
<h2>Are you sure you want to delete?</h2>

<input type = "submit" name = "yes" id = "yes" value = "Yes"></input>

&nbsp;
&nbsp;
&nbsp;
<input type = "submit" name = "no" value = "no"></input>
</form>

<?php 
if(isset($_POST["yes"])){
	$delete2 = $db->query("delete from level_advisers where lecturerId = '{$_GET["id"]}';", "delete");
	$delete3 = $db->query("update courses set lecturerId = ? where lecturerId = ?;", $using_lecturer->id, $_GET["id"], "update");
	$delete5 = $db->query("update gns_courses set lecturerId = ? where lecturerId = ?;", $using_lecturer->id, $_GET["id"], "update");
	$delete1 = $db->query("delete from lecturers where id = '{$_GET["id"]}';", "delete");
	$delete4 = $db->query("delete from login where loginId = '{$this_lecturer->loginId}';", "delete");
	//echo $this_lecturer->loginId;
	
	
	
	
	
	
	if(($delete1) && ($delete2) && ($delete3) && ($delete4)&& ($delete5)){
		echo "<font color = \"green\">deleted successfully</font>";
	}
	else{
		echo "<font color = \"red\">deletion failed</font>";
	}
	
}
elseif(isset($_POST["no"])){
	header("Location: department_admin_page.php?department={$using_lecturer->deptId}");
}
?>
</td>
 </tr>
 </table>
</div> 
</body>
</html>