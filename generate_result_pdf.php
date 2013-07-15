<?php
session_start();
require_once ("includes/initialize.php");
require_once ("/Zend/Loader/Autoloader.php");
if(!is_logged_in() ){
	header("Location: index.php");
}
else{
	
	$db = DatabaseWrapper::getInstance();
	$this_lecturer = initLecturer();
	$level = $db->query("select * from level_advisers where lecturerId = '{$this_lecturer->id}';", "select");
	if(!empty($level)){
		$list_students = $db->query("select * from student_info where entryYear = '{$level[0]["entryYear"]}' and programmeId = '{$level[0]["programmeId"]}';", "select");
		$de_entry = $level[0]["entryYear"] + 1;
		$list_students2 = $db->query("select * from student_info where entryYear = '{$de_entry}' and programmeId = '{$level[0]["programmeId"]}' and (modeOfEntry = 'DFP' or modeOfEntry = 'DE');", "select");
		$student_list = array_merge($list_students, $list_students2);
	}
	$first_class_list = array();
	$second_upper_list = array();
	$second_lower_list = array();
	$third_class_list = array();
	$pass_list = array();
}
$upper_session = $session[0][0] + 1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<link href="results_stylesheets.css" rel="stylesheet" type="text/css" />
<title>Class Result Sheet </title>
</head>
 <body>
 <center>
 <h3>Fountain University Osogbo</h3>
 <h4><?php echo "{$session[0][0]}/{$upper_session}" ;?> Academic Session</h4>
 <h4>Departmental Result Sheet</h4>
 </center>
 <div class = "divtable">
 <div class = "divrow">
 <div class = "divcell">
 s/n
 </div>
 <div class = "divcell">
 Matric
 </div>
 <div class = "divcell">
Scores
 </div>
 <div class = "divcell">
 outstanding
 
 </div>
 <div class = "divcell">
<center>Previous</center> 
 <div class = "divcell">
 <pre>TCP   TNU   CGPA</pre>
 </div>
 </div>
 <div class = "divcell">
 <center>Present</center>
 <div class = "divcell">
 <pre>TCP   TNU   GPA</pre>
 </div>
 </div>
 <div class = "divcell">
 <center>Final</center>
 <div class = "divcell">
 <pre>TCP   TNU   CGPA</pre>
 </div>
 </div>
 <div class  = "divcell">
 Remarks
 </div>
 </div>
 <?php 
 
	if (!empty($student_list)){
		//var_dump($student_list);
		$summary_list = array();
		$fountain_scholar_count = 0;
		$pass_count = 0;
		$overall_cso_count = 0;
		$summary_array = array();
		for($i=0;$i<count($student_list);$i++){
			$this_student = Student::instantiate($student_list[$i]);
			$CSO_count = 0;
			$outstanding_array = array();
			//var_dump($student_list[$i]);
			$current_session = $this_student->entryYear;
			$cummulative_tnu = 0;
			$cummulative_tcp = 0;
			$previous_cgpa = 0;
			$previous_tcp = 0;
			$previous_tnu = 0;
			$semester_scores_string = "";
			$outstanding_string = "";
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
					for($j=0;$j<count($course_list); $j++){
							
						$course_info = $db->query("select * from courses where code = '{$course_list[$i]["courseCode"]}';", "select");
							
						$courses[$j] = $course_info[0];
			
						$semester_tnu = $semester_tnu + $courses[$j]["units"];
						if($current_semester == $this_student->currentSemester){
						$semester_scores_string .= "{$course_list[$j]["courseCode"]} = {$course_list[$j]["finalScore"]} ";
						if($course_list[$j]["grade"] == "F" && $courses[$j]["status"] == "C" )
							$CSO_count = $CSO_count + 1;}
						if($course_list[$j]["grade"] == "O"){
							$outstanding_array[] = $course_list[$j]["courseCode"];
							$CSO_count = $CSO_count + 1;
						}
					}
				}
				else{
					//echo "<h4> There are no records for semester {$current_semester} <br />";
					continue;
				}
			
			
				//var_dump($courses);
				for($k = 0; $k < count($courses); $k++){
					$grade_credit_point;
					switch($course_list[$k]["grade"]){
						case "A":
							$grade_credit_point = 5 * $courses[$k]["units"];
							break;
						case "B":
							$grade_credit_point = 4 * $courses[$k]["units"];
							break;
						case "C":
							$grade_credit_point = 3 * $courses[$k]["units"];
							break;
						case "D":
							$grade_credit_point = 2 * $courses[$k]["units"];
							break;
						case "E";
							$grade_credit_point = 1 * $courses[$k]["units"];
							break;
						case "F";
							$grade_credit_point = 0 * $courses[$k]["units"];
							break;
						default:
							$grade_credit_point = 0 * $courses[$k]["units"];
							break;
					}
			
				$semester_tcp = $semester_tcp + $grade_credit_point;
				//if($course)
				}
										
	
			$cummulative_tcp = $cummulative_tcp + $semester_tcp;
			$cummulative_tnu = $cummulative_tnu + $semester_tnu;
			if(($semester_tnu != 0) || ($cummulative_tnu != 0) ){
				$semester_gpa = $semester_tcp / $semester_tnu;
				$cummulative_gpa = $cummulative_tcp/$cummulative_tnu;
				if(($this_student->currentSemester - $current_semester) == 1 ){
					$previous_cgpa = $cummulative_gpa;
					$previous_tcp = $cummulative_tcp;
					$previous_tnu = $cummulative_tnu;
				}
				}
				
			}
			if(!empty($outstanding_array)){
					
				for($p=0;$p<count($outstanding_array); $p++)
					$outstanding_string .= "{$outstanding_array[$p]} ";
			}
			else 
				$outstanding_string = "No Outstandings";
			$fuo_scholar_score = $db->query("select fountain_scholar from university where name = 'Fountain University Osogbo';", "select");
			
			if($cummulative_gpa >= $fuo_scholar_score[0][0])
				$fountain_scholar_count = $fountain_scholar_count + 1;
			if($CSO_count > 0 )
				$overall_cso_count = $overall_cso_count + 1;
			else 
				$pass_count = $pass_count + 1;
			
			$shortened_previous_gpa = sprintf("%.2f", $previous_cgpa);
			$shortened_previous_tnu = sprintf("%.2f", $previous_tnu);
			$shortened_previous_tcp = sprintf("%.2f", $previous_tcp);
			
			$shortened_gpa = sprintf("%.2f", $semester_gpa);
			$shortened_tnu = sprintf("%.2f", $semester_tnu);
			$shortened_tcp = sprintf("%.2f", $semester_tcp);
			
			$shortened_cumm_gpa = sprintf("%.2f", $cummulative_gpa);
			$shortened_cumm_tnu = sprintf("%.2f", $cummulative_tnu);
			$shortened_cumm_tcp = sprintf("%.2f", $cummulative_tcp);
			
			$summary_array[$i]["matric"] = $this_student->matricNo;
			$summary_array[$i]["name"] = $this_student->lname . " " . $this_student->fname;
			$summary_array[$i]["previous"] = $shortened_previous_gpa;
			$summary_array[$i]["present"] = $shortened_gpa;
			$summary_array[$i]["final"] = $shortened_cumm_gpa;
			
			if(($cummulative_gpa >= $fuo_scholar_score[0][0]) && ($this_student->level != 400)){
				$summary_array[$i]["remarks"] = "Fountain Scholar";
			}
			elseif(($cummulative_gpa >= $fuo_scholar_score[0][0]) && ($this_student->level == 400)){
				$summary_array[$i]["remarks"] = "First Class";
			}
			else{
				$summary_array[$i]["remarks"] = " ";
			}
			if($this_student->currentSemester == 8){
				if($cummulative_gpa >= 4.5)
					$first_class_list[] = $summary_array[$i];
				elseif(($cummulative_gpa >= 3.5) && ($cummulative_gpa < 4.5))
					$second_upper_list[] = $summary_array[$i];
				elseif(($cummulative_gpa >= 2.5) && ($cummulative_gpa < 3.5))
					$second_lower_list[] = $summary_array[$i];
				elseif(($cummulative_gpa >= 1.5) && ($cummulative_gpa < 2.5))
					$third_class_list[] = $summary_array[$i];
				elseif(($cummulative_gpa >= 1) && ($cummulative_gpa < 1.5))
					$pass_list = $summary_array[$i];
			}
			
			
			echo "<div class= \"divrow\">";
			echo "<div class = \"divcell\">";
			echo $i + 1;
			echo "</div>";
			echo "<div class = \"divcell\">";
			echo $this_student->matricNo;
			echo "</div>";
			echo "<div class = \"divcell\">";
			echo $semester_scores_string;
			echo "</div>";
			echo "<div class = \"divcell\">";
			echo $outstanding_string;
			echo "</div>";
			echo "<div class = \"divcell\">";
			echo "<div class = \"divcell\">";
			
			echo "<pre>{$shortened_previous_tcp}  {$shortened_previous_tnu}  {$shortened_previous_gpa}</pre>";
			echo "</div>";
			echo "</div>";
			echo "<div class = \"divcell\">";
			echo "<div class = \"divcell\">";
			
			echo "<pre>{$shortened_tcp}  {$shortened_tnu}  {$shortened_gpa}</pre>";
			echo "</div>";
			echo "</div>";
			echo "<div class = \"divcell\">";
			echo "<div class = \"divcell\">";
			
			echo "<pre>{$shortened_cumm_tcp}  {$shortened_cumm_tnu}  {$shortened_cumm_gpa}</pre>";
			echo "</div>";
			echo "</div>";
			echo "<div class = \"divcell\">";
			if($CSO_count > 0)
				echo "PCSO";
			else 
				echo "PASS";
			echo "</div>";
			echo "</div>";
			echo "<hr />";
			echo "<hr />";
		}
		
	}

 ?>
 </div>
 <p>
 </p>
 <div class = "divtable">
 <div class = "divrow">
 <div class = "divcell">
 s/n
 </div>
 <div class = "divcell">
 Matric
 </div>
 <div class = "divcell">
 Name
 </div>
 <div class = "divcell">
 Previous CGPA
 </div>
 <div class = "divcell">
 Present GPA
 </div>
 <div class = "divcell">
 Final CGPA
 </div>
 <div class = "divcell">
 Remarks
 </div>
 </div>
 <?php 
 if(!empty($summary_array)){
	for($a = 0; $a < count($summary_array);$a++){
		echo "<div class = \"divrow\">";
		echo "<div class = \"divcell\">";
		echo $a + 1;
		echo "</div>";
		echo "<div class = \"divcell\">";
		echo $summary_array[$a]["matric"];
		echo "</div>";
		echo "<div class = \"divcell\">";
		echo $summary_array[$a]["name"];
		echo "</div>";
		echo "<div class = \"divcell\">";
		echo $summary_array[$a]["previous"];
		echo "</div>";
		echo "<div class = \"divcell\">";
		echo $summary_array[$a]["present"];
		echo "</div>";
		echo "<div class = \"divcell\">";
		echo $summary_array[$a]["final"];
		echo "</div>";
		echo "<div class = \"divcell\">";
		echo $summary_array[$a]["remarks"];
		echo "</div>";
		echo "</div>";
	}
}
 ?>
 </div>
 
 <?php 
 	if((!empty($first_class_list)) ||(!empty($second_upper_list)) || (!empty($second_lower_list)) || (!empty($third_class_list)) || (!empty($pass_list))){
	
		echo "<div class = \"divtable\">";
		echo "<div class = \"divrow\">";
		echo "<div class = \"divcell\">";
		echo "s/n";
		echo "</div>";
		echo "<div class = \"divcell\">";
		echo "Matric";
		echo "</div>";
		echo "<div class = \"divcell\">";
		echo "Name";
		echo "</div>";
		echo "<div class = \"divcell\">";
		echo "Previous CGPA";
		echo "</div>";
		echo "<div class = \"divcell\">";
		echo "Present GPA";
		echo "</div>";
		echo "<div class = \"divcell\">";
		echo "Final CGPA";
		echo "</div>";
		
		echo "</div>";
		
		if(!empty($first_class_list)){
			echo "<h3>FIRST CLASS HONOURS</h3>";
			for($d=0;$d<count($first_class_list); $d++){
				echo "<div class = \"divrow\">";
				echo "<div class = \"divcell\">";
				echo $d + 1;
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $first_class_list[$d]["matric"];
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $first_class_list[$d]["name"];
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $first_class_list[$d]["previous"];
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $first_class_list[$d]["present"];
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $first_class_list[$d]["final"];
				echo "</div>";

				echo "</div>";
			}
		}
		if(!empty($second_upper_list)){
			echo "<h3>SECOND CLASS (UPPER DIVISION)</h3>";
			for($e=0;$e<count($second_upper_list); $e++){
				echo "<div class = \"divrow\">";
				echo "<div class = \"divcell\">";
				echo $e + 1;
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $second_upper_list[$e]["matric"];
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $second_upper_list[$e]["name"];
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $second_upper_list[$e]["previous"];
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $second_upper_list[$e]["present"];
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $second_upper_list[$e]["final"];
				echo "</div>";
		
				echo "</div>";
			}
		}
		
		if(!empty($second_lower_list)){
			echo "<h3>SECOND CLASS (LOWER DIVISION)</h3>";
			for($f=0;$f<count($second_lower_list); $f++){
				echo "<div class = \"divrow\">";
				echo "<div class = \"divcell\">";
				echo $f + 1;
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $second_lower_list[$f]["matric"];
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $second_lower_list[$f]["name"];
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $second_lower_list[$f]["previous"];
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $second_lower_list[$f]["present"];
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $second_lower_list[$f]["final"];
				echo "</div>";
		
				echo "</div>";
			}
		}
		if(!empty($third_class_list)){
			echo "<h3>SECOND CLASS (UPPER DIVISION)</h3>";
			for($g=0;$g<count($third_class_list); $g++){
				echo "<div class = \"divrow\">";
				echo "<div class = \"divcell\">";
				echo $g + 1;
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $third_class_list[$g]["matric"];
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $third_class_list[$g]["name"];
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $third_class_list[$g]["previous"];
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $third_class_list[$g]["present"];
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $third_class_list[$g]["final"];
				echo "</div>";
		
				echo "</div>";
			}
		}
		if(!empty($pass_list)){
			echo "<h3>SECOND CLASS (UPPER DIVISION)</h3>";
			for($h=0;$h<count($pass_list); $h++){
				echo "<div class = \"divrow\">";
				echo "<div class = \"divcell\">";
				echo $h + 1;
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $pass_list[$h]["matric"];
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $pass_list[$h]["name"];
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $pass_list[$h]["previous"];
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $pass_list[$h]["present"];
				echo "</div>";
				echo "<div class = \"divcell\">";
				echo $pass_list[$h]["final"];
				echo "</div>";
		
				echo "</div>";
			}
		}
	}
	
 ?>
 <?php 
 echo "<h3>Summary</h3>";
 echo "Number of Fountain Scholars: {$fountain_scholar_count} <br />";
 echo "Number of Passes: {$pass_count} <br />";
 echo "Number of CSOs: {$overall_cso_count}";
 
 echo "<pre>";
 echo "H.O.D Signature				Dean of Faculty <br />";
 echo "________________                         ________________";
 echo "</pre>";
 echo "Prepared by Fountain Course Registration and Result Computational system at " . date("m d Y h:i:s");
 
 ?>
 
 
 </body>
 </html>
