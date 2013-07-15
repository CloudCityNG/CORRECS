<?php
session_start();
require_once("includes/initialize.php");
if((!is_logged_in()) || (!isset($_GET["studentId"])) ||(!isset($_GET["id"])) || (!isset($_GET["dept"]))){
	Header("Location: index.php");

}
else{

	$this_lecturer = initLecturer();
	$db = DatabaseWrapper::getInstance();
	$student = $db->query("select * from student_info where id = '{$_GET["studentId"]}';", "select");
	
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<title>Input scores for <?php echo $_GET["id"] ?> for <?php echo "{$student[0]["lname"]} {$student[0]["fname"]}"?></title>
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
 <form method = "post" action = "accept_individual_student_score.php?studentId=<?php echo $_GET["studentId"] ?>&id=<?php echo $_GET["id"] ?>&dept=<?php echo $_GET["dept"] ?>" name = "form1">
 
<h2>Input  <?php echo $_GET["id"] ?> scores for <?php echo "{$student[0]["lname"]} {$student[0]["fname"]}"?> </h2>
<p>Please fill this mark sheet carefully <br />
If a student has outstanding results, please input 0 for both CA and exam score
</p>
<div class = "divtable">
<div class = "divrow">
<div class = "divcell">
C.A. Score
</div>
<div class = "divcell">
<input type = "text" name="ca" id = "ca" size = 4>
</div>
</div>
<div class = "divrow">
<div class = "divcell">
Exam Score
</div>
<div class = "divcell">
<input type = "text" name="exam" id = "exam" size = 4>
</div>
</div>
<div class = "divrow">
<input type = "submit" name = "submit" value = "Submit">
</div>
</div>

 
 
  </form>
  <!-- <h3 align="center"><a href="input_scores_csv.php?id=<?php echo $course; ?>">Click here to upload scores from EXCEL FILE</a></h3>  -->
 </td>
 </tr>
 </table>
</div> 
 </body>
 </html>
 