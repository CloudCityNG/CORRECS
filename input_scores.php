<?php
session_start();
require_once("includes/initialize.php");
if((!is_logged_in()) || (!isset($_GET["id"])) || (!isset($_GET["dept"]))){
	Header("Location: index.php");
	
}
else{

	$this_lecturer = initLecturer();
	$db = DatabaseWrapper::getInstance();
	//$student_list = $db->query("select * from student_info where deptId = '{$_GET["dept"]}';", "select");
	//$lecturer_courses = $db->query("select * from courses where lecturerId = '{$this_lecturer->id}';", "select");
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
 <form method = "post" action = "accept_student_score.php?id=<?php echo $_GET["id"] ?>&dept=<?php echo $_GET["dept"] ?>" name = "form1">
 
<h2>List of Students offering <?php echo $_GET["id"]?> </h2>
<p>Please fill this mark sheet carefully <br />
If a student has outstanding results, please input 0 for both CA and exam score
</p>
<p>
To input a particular students score, please click his/her name </p>
<div class = "divtable">
<div class = "divrow">
<div class = "divcell">
<h3>Student Name</h3>
</div>
<div class = "divcell">
<h3>Matric Number</h3>
</div>
<div class = "divcell">
<h3>CA Score</h3>
</div>
<div class = "divcell">
<h3>Exam Score</h3>
</div>
</div>
<?php 
$course = $_GET["id"];
$session = $db->query("select currentSession from university where name = 'Fountain University Osogbo';", "select");
if(!preg_match("(GNS.[0-9])", $_GET["id"]))
$find_students = $db->query("select * from  coursestaken where  coursestaken.courseCode = '{$_GET["id"]}' and coursestaken.session = '{$session[0]["currentSession"]}' and deptId = '{$_GET["dept"]}' ;", "select");
else 
	$find_students = $db->query("select * from  coursestaken where  coursestaken.courseCode = '{$_GET["id"]}' and coursestaken.session = '{$session[0]["currentSession"]}';", "select");
for($i=0;$i < count($find_students); $i++){
	if(!preg_match("(GNS.[0-9])", $_GET["id"]))
	$matric_no = $db->query("select * from student_info where id = '{$find_students[$i]["studentId"]}' and deptId = '{$_GET["dept"]}';","select");
	//var_dump($matric_no);
	else
		$matric_no = $db->query("select * from student_info where id = '{$find_students[$i]["studentId"]}';","select");
	$this_student = Student::instantiate($matric_no[0]);
	echo "<div class = \"divrow\">";
	echo "<div class = \"divcell\">";
	echo "<a href = \"individual_input_score.php?studentId={$matric_no[0]["id"]}&id={$_GET["id"]}&dept={$_GET["dept"]}\"> {$matric_no[0]["lname"]} {$matric_no[0]["fname"]} </a>";
	
	echo "</div>";
	echo "<div class = \"divcell\">";
	
	echo $this_student->matricNo;
	
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo "<input type = \"text\" size = \"12\" name = \"ca[{$this_student->id}]\" />";
	echo "</div>";
	
	echo "<div class = \"divcell\">";
	echo "<input type = \"text\" size = \"12\" name = \"exam[{$this_student->id}]\" />";
	echo "</div>";
	echo "</div>";
}




?>

  </div>
  <input type = "submit" name = "submit"></input>
  </form>
   <h3 align="center"><a href="input_scores_csv.php?id=<?php echo $course; ?>&dept=<?php echo $_GET["dept"] ?>">Click here to upload scores from EXCEL FILE</a></h3> 
 </td>
 </tr>
 </table>
</div> 
 </body>
 </html>
 