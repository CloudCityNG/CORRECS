<?php
session_start();
//require_once("includes/connection.php");
require_once("includes/initialize.php");
if(!is_logged_in() && (!isset($_GET["id"]))&& (!isset($_GET["dept"]))){
	Header("Location: index.php");
	
}
else{

	$this_lecturer = initLecturer();
	$db = DatabaseWrapper::getInstance();
	$lecturer_courses = $db->query("select * from courses where lecturerId = '{$this_lecturer->id}';", "select");
	//echo $_GET["id"];
	//echo $_SESSION["code"];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<title>Input scores for <?php echo $_GET["id"] ?></title>
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
<div id="content">
<fieldset><legend><h3>CSV UPLOAD</h3></legend>
<h3>Guidelines</h3>
<ul>
<li>Save your Excel sheet in .CSV (Comma Separated Values) format</li>
<li>Please do not use any title row </li>
<li>The Spreedsheet should contain only 3 columns, MATRIC NUMBER, C.A. AND EXAM SCORE </li>
<li>Please fill the spreedsheet carefully and input only valid data</li>
<li>Do not put slashes in the  Matric Numbers</li>
<li>Scroll down to see a sample spreadsheet</li>
</ul>
 <form method = "post" enctype="multipart/form-data" action = "process_upload.php?id=<?php echo $_GET["id"] ?>&dept=<?php echo $_GET["dept"] ?>" name = "form1">
 Please Upload CSV file&nbsp;&nbsp;<input type="file" name="scores" id = "scores" />
 <input type="submit" name="upload" value="upload">
 </form>
 </fieldset>
 <p>
 <p>
 
 </div>
 

 <img src = "Pictures/sample_excel.png" align = "left" height = "250" width = "250">
  
 </td>
 </tr>

 </table>
 
</div> 
 </body>
 </html>
 