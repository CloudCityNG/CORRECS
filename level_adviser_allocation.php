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
<title>Course Allocation</title>
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
<center><h2 align="center">Assign  <?php $this_lecturer->fullName() ?> to Head a Level</h2></center>
<form name = "reg" method = "post" action = "allocate_level.php?id=<?php echo $_GET["id"] ?>">
<div class = "divtable">
<div class = "divrow">
<div class = "divcell">
Select Entry Year
</div>
<div class = "divcell">
<select name="entryyear" id="entryyear">
      <option value = "">Select </option>
      <option value = 2007>2007</option>
      <option value = 2008>2008</option>
      <option value = 2009>2009</option>
      <option value = 2010>2010</option>
      <option value = 2011>2011</option>
    </select>
</div>
</div>

<?php 
$programmes = $db->query("select * from programmes where departmentId = '{$this_lecturer->deptId}';", "select");
if(!empty($programmes)){
echo "<div class = \"divrow\">";
echo "<div class = \"divcell\">";
echo "Select programme";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<select name= \"programme\" id=\"programme\">";
 echo    "<option value = \"\">Select </option>";
 for($i =0; $i < count($programmes); $i++){
     echo "<option value = {$programmes[$i]["programmeId"]}>{$programmes[$i]["name"]}</option>";
 }
 echo  "</select>";
echo "</div>";
echo "</div>";
}
?>

<div class = "divrow">
<input type = "submit" name = "submit" value = "Allocate"></input>
</div>
</div>
<?php 
$error_message = FlashMessages::getInstance();
$key = "allocation";
$error_message->displayMessage("allocation");
$error_message->unsetMessage("allocation");

?>
</form>
</td>
 </tr>
 </table>
</div> 
</body>
</html>
