<?php
session_start();
$courses = array();
$cummulative_tnu = 0;
$cummulative_tcp = 0;
$this_student;

require_once("includes/initialize.php");
	if(!is_logged_in() && !isset($_GET["studentId"]) && ($_GET["matric"])){
		Header("Location: list_students.php");
	}
	else{
		$db = DatabaseWrapper::getInstance();
		$student = $db->query("select * from student_info where id = '{$_GET["studentId"]}' and matricNo = '{$_GET["matric"]}';", "select");
		
		if($student){
			$this_student = Student::instantiate($student[0]);
			$current_session = $this_student->entryYear;
		}
	}
	
	?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<link href="results_stylesheets.css" rel="stylesheet" type="text/css" />
<title>Student Transcript </title>
</head>
 <body>
 <h3>Fountain University Osogbo</h3>
 <h4>Student Academic History</h4>
 <h5> <?php $this_student->fullName()?> </h5>
 Level : <?php echo $this_student->level ?>  
 <div class = "divtable">
	
	<?php 
	for($current_semester = 1; $current_semester <= $this_student->currentSemester; $current_semester++){
		$courses = array();
		$semester_tnu = 0;
		$semester_tcp = 0;
		if($current_semester ==1 || $current_semester % 2 != 0){
			$course_list = $db->query("select * from coursestaken where studentId = '{$this_student->id}' and session = '{$current_session}' and semester = 1 ;", "select");
		}
		else{
			$course_list = $db->query("select * from coursestaken where studentId = '{$this_student->id}' and session = '{$current_session}' and semester = 2 ;", "select");
			$current_session = $current_session + 1;
		}
		if(!empty($course_list)){
		for($i=0;$i<count($course_list); $i++){
			
			$course_info = $db->query("select * from courses where code = '{$course_list[$i]["courseCode"]}';", "select");
			
			$courses[$i] = $course_info[0];
	
			$semester_tnu = $semester_tnu + $courses[$i]["units"];
			
		}
		}
		else{
			echo "<h4> There are no records for semester {$current_semester} <br />";
			continue;
		}
	
	
	//var_dump($courses);
	for($i = 0; $i < count($courses); $i++){
		$grade_credit_point;
		switch($course_list[$i]["grade"]){
			case "A":
				$grade_credit_point = 5 * $courses[$i]["units"];
				break;
			case "B":
				$grade_credit_point = 4 * $courses[$i]["units"];
				break;
			case "C":
				$grade_credit_point = 3 * $courses[$i]["units"];
				break;
			case "D":
				$grade_credit_point = 2 * $courses[$i]["units"];
				break;
			case "E";
				$grade_credit_point = 1 * $courses[$i]["units"];
				break;
			case "F";
				$grade_credit_point = 0 * $courses[$i]["units"];	
				break;
			default:
				$grade_credit_point = 0 * $courses[$i]["units"];
				break;
		}
		
		$semester_tcp = $semester_tcp + $grade_credit_point;
		
	}
			echo "<h3>Semester {$current_semester}</h3>";
			//echo "<div class = \"divrow\">";
			echo "<table border=\"0\"><tr style=\"background-color: pink\">";
			echo "<th width=\"150\">";
			//echo "<div class = \"divcell\">";
			echo "Course Code";
			echo "</th>";
			//echo "</div>";
			//echo "<div class = \"divcell\">";
			echo "<th width=\"300\">";
			echo "Course Title";
			echo "</th>";
			//echo "</div>";
			//echo "<div class = \"divcell\">";
			echo "<th width=\"150\">";
			echo "Units";
			echo "</th>";
			//echo "</div>";
			//echo "<div class = \"divcell\">";
			echo "<th width=\"150\">";
			echo "Score";
			echo "</th>";
			echo "</tr>";
			//echo "</div>";
			//echo "</div>";
	for($i=0;$i<count($courses);$i++){
			echo "<tr width=\"pink\">";
			//echo "<div class = \"divrow\">";
			//echo "<div class = \"divcell\">";
			echo "<td align=\"center\" width=\"150\">";
			echo $courses[$i]["code"];
			//echo "</div>";
			//echo "<div class = \"divcell\">";
			echo "</td>";
			echo "<td align=\"left\" width=\"300\">";
			echo $courses[$i]["name"];
			//echo "</div>";
			echo "</td>";
			//echo "<div class = \"divcell\">";
			echo "<td align=\"center\" width=\"150\">";
			echo $courses[$i]["units"];
			//echo "</div>";
			echo "</td>";
			echo "<td align=\"center\" width=\"150\">";
			//echo "<div class = \"divcell\">";
			echo $course_list[$i]["finalScore"];
			//echo "</div>";
			echo "</td>";
		
			//echo "</div>";
			
		}
		echo "</table>";
		$cummulative_tcp = $cummulative_tcp + $semester_tcp;
		$cummulative_tnu = $cummulative_tnu + $semester_tnu;
	if(($semester_tnu != 0) || ($cummulative_tnu != 0) ){
	$semester_gpa = $semester_tcp / $semester_tnu;
	$cummulative_gpa = $cummulative_tcp/$cummulative_tnu;
	printf ("present:     TCP: %d , TNU:  %d GPA: %.2f <br />", $semester_tcp, $semester_tnu, $semester_gpa); 
	//echo $semester_tnu . "<br />";
	printf ("Cummulative:     TCP: %d , TNU:  %d GPA: %.2f <br />", $cummulative_tcp, $cummulative_tnu, $cummulative_gpa); 
	}
	echo "<hr />";
}
	echo "<pre>";
	echo "H.O.D Signature <br />";
	echo "________________";
	echo "</pre>";
?>

	
 </div>
 <input type = "submit" value = "Print this Page" onclick = "window.print()">
 
 </body>
 </html>
 