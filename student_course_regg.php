<?php
session_start();
require_once("includes/initialize.php");

$this_student;
if(!is_logged_in()){
	Header("Location: index.php");
	
}
else{
	$this_student = initStudent();
	$db = DatabaseWrapper::getInstance();
	$universitySession = $db->query("select currentSession from university where name = 'Fountain University Osogbo';", "select");
	$table = $db->query("select name from programmes where programmeId = '{$this_student->programmeId}';", "select");
	$has_registered = $db->query("select * from registration_log where studentId = '{$this_student->id}' and session = '{$universitySession[0]["currentSession"]}';", "select");

}
?>
<html>
<head>
<title>Register courses</title>
<link href="stylesheets.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/login.css" media="all" /> 
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/public.css" media="all" />
</head>
<body>
 <?php include("includes/header.php");?>
<div id="container">
<table>

<tr id="nav_bar"><td align="left"><p>
<h5><?php echo $this_student->fullName(); ?></h5></p>
</td><td align="right"><h3><a href="logout.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp; </h3></td></tr>
<tr><td id="navigation">
<ul>
<img src = "<?php echo $this_student->photograph ;?>"  align = "center" height = 150 width = 120>


<li>
<a href = "student_homepage.php"> Back to Student Homepage</a>
</li></ul>
</td>
<td id="page">
<?php 
$error_message = FlashMessages::getInstance();
$key = "registration";
$error_message->displayMessage("registration");
$error_message->unsetMessage("registration");
?>
<center><h2>COURSES FOR  <?php echo $this_student->level ." LEVEL ". $table[0]['name']; ?></h2></center>
<form name = "reg" method = "post" action = "register_course.php">
<div class = "divtable">
<?php 
$level_courses = $db->query("select * from courses where programmeId = '{$this_student->programmeId}' and level = '{$this_student->level}';" , "select");
$failed_compulsory = $db->query("select courses.* from coursestaken, courses where coursestaken.studentId = '{$this_student->id}' and coursestaken.courseCode = courses.code and coursestaken.grade = 'F';", "select");
$gns_courses;
$total_units_available = 0;
if(!empty($has_registered)){
	echo "<h4>You have already registered {$has_registered[0]["no_times_registered"]} times this session<h4>";

if($has_registered[0]["total_units_registered"] > 48){
	echo "You have already registered the maximum amount of courses that be registered this session<br />";
	echo "You will now be redirected back";
	header("Refresh: 5;url=student_homepage.php");
}
}
 /*For the courses meant to be offered at the students level
 the if block checks for failed prerequisites and then prints out
 in red if a prerequisite was failed, and black if not.
 The failed prerequisite courses cannot be ticked.
*/
if(!empty($level_courses)){
	echo "<h4>FIRST SEMESTER</h4>";
	echoHeader();
	$semester_total_units = 0;
	for($i=0; $i<count($level_courses); $i++){
		$prereqFlag = true;
		$check_registered = $db->query("select * from coursestaken where studentId = '{$this_student->id}' and session = '{$universitySession[0]["currentSession"]}' and courseCode = '{$level_courses[$i]["code"]}';", "select");
		if(!empty($check_registered)){
			continue;
		}
		/*To check if a course has a failed prerequisite
		If it does, the $prereqFlag flag would be set to false and the student will not be able to register that course*/
		$pre = $db->query("select prerequisiteId from courses where code = '{$level_courses[$i]["code"]}';","select");
		if(!empty($pre)){
			if($pre[0]["prerequisiteId"] != null){
				$pre_course = $db->query("select courseCode from prerequisite where id = '{$pre[0]["prerequisiteId"]}';", "select");
	
				if($pre_course){
					$check_pre = $db->query("select grade from coursestaken where courseCode = '{$pre_course[0]["courseCode"]}' and studentId = '{$this_student->id}';", "select");
					if(!empty($check_pre)){
						if($check_pre[0]["grade"] == "F")
							$prereqFlag = false;
					}
				else $prereqFlag  = true;
				}	
			}
		}
	
		
		if($level_courses[$i]["semester"] == 1){ 
			if($prereqFlag != false)
			$semester_total_units = $semester_total_units + $level_courses[$i]["units"];
			echoCourse($prereqFlag, $level_courses[$i]);
		}
		
	}
	echo "TOTAL UNITS = {$semester_total_units} <br />";
	echo "<h4>SECOND SEMESTER</h4>";
	echoHeader();
	$semester_total_units = 0;
	for($i=0; $i<count($level_courses); $i++){
		$prereqFlag = true;
		$check_registered = $db->query("select * from coursestaken where studentId = '{$this_student->id}' and session = '{$universitySession[0]["currentSession"]}' and courseCode = '{$level_courses[$i]["code"]}';", "select");
		if(!empty($check_registered)){
			continue;
		}
		$pre = $db->query("select prerequisiteId from courses where code = '{$level_courses[$i]["code"]}';","select");
		if(!empty($pre)){
			if($pre[0]["prerequisiteId"] != null){
			$pre_course = $db->query("select courseCode from prerequisite where id = '{$pre[0]["prerequisiteId"]}';", "select");
	
			if($pre_course){
				$check_pre = $db->query("select grade from coursestaken where courseCode = '{$pre_course[0]["courseCode"]}' and studentId = '{$this_student->id}';", "select");
				if(!empty($check_pre)){
					if($check_pre[0]["grade"] == "F" )
						$prereqFlag = false;
				}
				else $prereqFlag  = true;
			}
		}
	}
		if($level_courses[$i]["semester"] == 2){ 
			if($prereqFlag != false)
			$semester_total_units = $semester_total_units + $level_courses[$i]["units"];
			echoCourse($prereqFlag, $level_courses[$i]);
		}
	}
	echo "TOTAL UNITS = {$semester_total_units} <br />";
}	

//Now for courses that the student has failed

if(!empty($failed_compulsory)){
	echo "<p><center><h3> CARRIED COURSES</h3></center>";
	echo "<h4>FIRST SEMESTER</h4>";
	echoHeader();
	$semester_total_units = 0;
	for($i=0; $i < count($failed_compulsory);$i++){
		$prereqFlag = true;
		$check_registered = $db->query("select * from coursestaken where studentId = '{$this_student->id}' and session = '{$universitySession[0]["currentSession"]}' and courseCode = '{$failed_compulsory[$i]["code"]}';", "select");
		if(!empty($check_registered)){
			continue;
		}
		if($failed_compulsory[$i]["semester"] == 1){ 
			if($prereqFlag != false)
			$semester_total_units = $semester_total_units + $failed_compulsory[$i]["units"];
			echoCourse($prereqFlag, $failed_compulsory[$i]);
			//$total_units_available = $total_units_available + $failed_compulsory[$i]["units"];
		}
	}
	echo "TOTAL UNITS = {$semester_total_units} <br />";
	
	echo "<h5>SECOND SEMESTER</h5>";
	echoHeader();
	$semester_total_units = 0;
	for($i=0; $i < count($failed_compulsory);$i++){
		$prereqFlag = true;
		$check_registered = $db->query("select * from coursestaken where studentId = '{$this_student->id}' and session = '{$universitySession[0]["currentSession"]}' and courseCode = '{$failed_compulsory[$i]["code"]}';", "select");
		if(!empty($check_registered)){
			continue;
		}
		if($failed_compulsory[$i]["semester"] == 2){ 
			if($prereqFlag != false)
			$semester_total_units = $semester_total_units + $failed_compulsory[$i]["units"];
			echoCourse($prereqFlag, $failed_compulsory[$i]);
			//$total_units_available = $total_units_available + $failed_compulsory[$i]["units"];
		}
	}
	echo "TOTAL UNITS = {$semester_total_units} <br />";
}
/* $no_registered = $db->query("select count(studentId) from registration_log where studentId = '{$this_student->id}';", "select");
$the_level = $no_registered[0][0] * 100; */
if(($this_student->modeOfEntry == "DFP") || ($this_student->modeOfEntry == "DE"))
	$missed = $db->query("select * from courses where programmeId = '{$this_student->programmeId}' and level < '{$this_student->level}' and level != 100 and status = 'C';", "select");
else
	$missed = $db->query("select * from courses where programmeId = '{$this_student->programmeId}' and level < '{$this_student->level}' and status = 'C';", "select");
$registered = $db->query("select * from coursestaken where studentId = '{$this_student->id}';", "select");

for($i = 0; $i < count($registered); $i++){
	for($j = 0; $j < count($missed); $j++){
		if($registered[$i]["courseCode"] == $missed[$j]["code"]){
			$missed[$j] = NULL;
			
		}
	}
}
$counter_missed = 0;
for($i=0;$i<count($missed);$i++){
	if($missed[$i] == NULL)
	$counter_missed++;
}
if($counter_missed != count($missed)){
	echo "<center><h5> OTHER UNREGISTERED COMPULSORY COURSES</h5></center>";
	echo "<h5> FIRST SEMESTER</h5>";
	echoHeader();
	$semester_total_units = 0;
	for($i=0;$i<count($missed);$i++){
		$prereqFlag = true;
		if($missed[$i] == NULL){
			continue;
		}
		$check_registered = $db->query("select * from coursestaken where studentId = '{$this_student->id}' and session = '{$universitySession[0]["currentSession"]}' and courseCode = '{$missed[$i]["code"]}';", "select");
		if(!empty($check_registered)){
			continue;
		}

		$pre = $db->query("select prerequisiteId from courses where code = '{$missed[$i]["code"]}';","select");
		if($pre[0]["prerequisiteId"] != null){
			$pre_course = $db->query("select courseCode from prerequisite where id = '{$pre[0]["prerequisiteId"]}';", "select");
			if($pre_course){
				$check_pre = $db->query("select grade from coursestaken where courseCode = '{$pre_course[0]["courseCode"]}' and studentId = '{$this_student->id}';", "select");
				if(!empty($check_pre)){
					if($check_pre[0]["grade"] == "F" )
						$prereqFlag = false;
				}
				else $prereqFlag  = true;;
			}
		}
		if($missed[$i]["semester"] == 1){
			if($prereqFlag != false)
			$semester_total_units = $semester_total_units + $missed[$i]["units"];
			echoCourse($prereqFlag, $missed[$i]);
			
		}
	}
	echo "TOTAL UNITS = {$semester_total_units} <br />";

	echo "<h5> SECOND SEMESTER</h5>";
	echoHeader();
	$semester_total_units = 0;
	for($i=0;$i<count($missed);$i++){
		$prereqFlag = true;
		if($missed[$i] == NULL){
			continue;
		}
	
		$check_registered = $db->query("select * from coursestaken where studentId = '{$this_student->id}' and session = '{$universitySession[0]["currentSession"]}' and courseCode = '{$missed[$i]["code"]}';", "select");
		if(!empty($check_registered)){
			continue;
		}

		$pre = $db->query("select prerequisiteId from courses where code = '{$missed[$i]["code"]}';","select");
		if($pre[0]["prerequisiteId"] != null){
			$pre_course = $db->query("select courseCode from prerequisite where id = '{$pre[0]["prerequisiteId"]}';", "select");
			if($pre_course){
				$check_pre = $db->query("select grade from coursestaken where courseCode = '{$pre_course[0]["courseCode"]}' and studentId = '{$this_student->id}';", "select");
				if(!empty($check_pre)){
					if($check_pre[0]["grade"] == "F" )
						$prereqFlag = false;
				}
				else $prereqFlag  = true;
			}
		}
		if($missed[$i]["semester"] == 2){
			if($prereqFlag != false)
			$semester_total_units = $semester_total_units + $missed[$i]["units"];
			echoCourse($prereqFlag, $missed[$i]);
			}
	}
	echo "TOTAL UNITS = {$semester_total_units} <br />";
}

if($this_student->modeOfEntry == "UME"){
	$gns_courses = $db->query("select * from courses where code like 'GNS%' AND level = '{$this_student->level}';", "select");
	$missed_gns = $db->query("select * from courses where code like 'GNS%' AND level < '{$this_student->level}';", "select");
}
elseif(($this_student->modeOfEntry == "DE") || ($this_student->modeOfEntry == "DFP")){
	$gns_courses = $db->query("select * from courses where code like 'GNS%' AND level = ({$this_student->level} - 100);", "select");
	$missed_gns = $db->query("select * from courses where code like 'GNS%' AND level < ({$this_student->level} - 100);", "select");
}
$failed_gns = $db->query("select courses.* from coursestaken, courses where coursestaken.studentId = '{$this_student->id}' and coursestaken.courseCode = courses.code and courses.code like 'GNS%' and coursestaken.grade = 'F';", "select");
$registered_gns= $db->query("select * from coursestaken where studentId = '{$this_student->id}' and courseCode like 'GNS%';", "select");


if(!empty($gns_courses)){
	$prereqFlag = true;
	echo "<p><center><h5> GNS COURSES</h5></center>";
	echo "<h5> FIRST SEMESTER</h5>";
	echoHeader();
	$semester_total_units = 0;
	for($i = 0; $i < count($gns_courses); $i++){
		$prereqFlag = true;
	
		$check_registered = $db->query("select * from coursestaken where studentId = '{$this_student->id}' and session = '{$universitySession[0]["currentSession"]}' and courseCode = '{$gns_courses[$i]["code"]}';", "select");
		if(!empty($check_registered)){
			continue;
		}
		if($gns_courses[$i]["semester"] == 1){
			if($prereqFlag != false)
			$semester_total_units = $semester_total_units + $gns_courses[$i]["units"];
			echoCourse($prereqFlag, $gns_courses[$i]);
			//$total_units_available = $total_units_available + $gns_courses[$i]["units"];
		}
	}
	echo "TOTAL UNITS = {$semester_total_units} <br />";
	echo "<h5> SECOND SEMESTER</h5>";
	echoHeader();
	$semester_total_units = 0;
	for($i = 0; $i < count($gns_courses); $i++){
		$prereqFlag = true;
	
		$check_registered = $db->query("select * from coursestaken where studentId = '{$this_student->id}' and session = '{$universitySession[0]["currentSession"]}' and courseCode = '{$gns_courses[$i]["code"]}';", "select");
		if(!empty($check_registered)){
			continue;
		}
		if($gns_courses[$i]["semester"] == 2){
			if($prereqFlag != false)
			$semester_total_units = $semester_total_units + $gns_courses[$i]["units"];
			echoCourse($prereqFlag, $gns_courses[$i]);
			//$total_units_available = $total_units_available + $gns_courses[$i]["units"];
		}
	}
	echo "TOTAL UNITS = {$semester_total_units} <br />";
}

if(!empty($failed_gns)){
	$prereqFlag = true;
echo "<p><center><h5>FAILED GNS COURSES</h5></center>";
echo "<h5> FIRST SEMESTER</h5>";
	echoHeader();
	$semester_total_units = 0;
	for($i = 0; $i < count($failed_gns); $i++){
		if($failed_gns[$i]["semester"] == 1){
			echoCourse($prereqFlag, $failed_gns[$i]);
			if($prereqFlag != false)
			$semester_total_units = $semester_total_units + $failed_gns[$i]["units"];
			//$total_units_available = $total_units_available + $failed_gns[$i]["units"];
		}
	}
	echo "TOTAL UNITS = {$semester_total_units} <br />";
	echo "<h5> SECOND SEMESTER</h5>";
	echoHeader();
	$semester_total_units = 0;
	for($i = 0; $i < count($failed_gns); $i++){
		if($failed_gns[$i]["semester"] == 2){
			if($prereqFlag != false)
			$semester_total_units = $semester_total_units + $failed_gns[$i]["units"];
			echoCourse($prereqFlag, $failed_gns[$i]);
			//$total_units_available = $total_units_available + $failed_gns[$i]["units"];
		}
	}
	echo "TOTAL UNITS = {$semester_total_units} <br />";
}
for($i = 0; $i < count($registered_gns); $i++){
	for($j = 0; $j < count($missed_gns); $j++){
		if(@$registered_gns[$i]["courseCode"] == $missed_gns[$j]["code"]){
			$missed_gns[$j] = NULL;
			
		}
	}
}
$counter_missed_gns = 0;
for($i=0;$i<count($missed_gns);$i++){
	if($missed_gns[$i] == NULL)
	$counter_missed_gns++;
}
if($counter_missed_gns != count($missed_gns)){
	$prereqFlag = true;
	echo "<center><h5> OTHER UNREGISTERED GNS COURSES</h5></center>";
	echo "<h5>FIRST SEMESTER</h5>";
	echoHeader();
	$semester_total_units = 0;
	for($i=0;$i<count($missed_gns);$i++){
		if($missed_gns[$i] == NULL){
			continue;
		}

		if($missed_gns[$i]["semester"] == 1){
			if($prereqFlag != false)
			$semester_total_units = $semester_total_units + $missed_gns[$i]["units"];
			echoCourse($prereqFlag, $missed_gns[$i]);
			//$total_units_available = $total_units_available + $missed_gns[$i]["units"];
		}
	}
	echo "TOTAL UNITS = {$semester_total_units} <br />";
	echo "<h5>SECOND SEMESTER</h5>";
	echoHeader();
	$semester_total_units = 0;
	for($i=0;$i<count($missed_gns);$i++){
		if($missed_gns[$i] == NULL){
			continue;
		}

		if($missed_gns[$i]["semester"] == 2){
			if($prereqFlag != false)
			$semester_total_units = $semester_total_units + $missed_gns[$i]["units"];
			echoCourse($prereqFlag, $missed_gns[$i]);
			//$total_units_available = $total_units_available + $missed_gns[$i]["units"];
		}
	}
	echo "TOTAL UNITS = {$semester_total_units} <br />";
}

//echo "TOTAL UNITS AVAILABLE: {$total_units_available} <br />"; 

echo "<input type = \"submit\" name = \"register\" value = \"register\">";
?>
</div>
</form>
</td>
 </tr>
 </table>
</div>
</body>
</html>