<?php
session_start();
require_once("includes/initialize.php");
$error_message = FlashMessages::getInstance();
$key = "registration";
$error_message->displayMessage("registration");
$error_message->unsetMessage("registration");
if(!is_logged_in()){
	Header("Location: index.php");
	
}
else{
	$this_student = initStudent();
	$db = DatabaseWrapper::getInstance();
	$table = $db->query("select name from programmes where programmeId = '{$this_student->programmeId}';", "select");
	
	
}
?>

<html>
<head>
<title>Register courses</title>
<link href="stylesheets.css" rel="stylesheet" type="text/css" />

</head>
<body>
<center><h1>COURSES FOR  <?php echo $this_student->level ." LEVEL ". $table[0]['name']; ?></h1></center>
<form name = "reg" method = "post" action = "register_course.php">
<div class = "divtable">
<div class = "divrow">
<div class = "divcell">
Select Course
</div>
<div class = "divcell">
Course Code
</div>
<div class = "divcell">
Course Title
</div>
<div class = "divcell">
Units
</div>
<div class = "divcell">
Status
</div>

</div>

<?php 
$level_courses = $db->query("select * from courses where programmeId = '{$this_student->programmeId}' and level = '{$this_student->level}';" , "select");

$failed_compulsory = $db->query("select courses.* from coursestaken, courses where coursestaken.studentId = '{$this_student->id}' and coursestaken.courseCode = courses.code and coursestaken.grade = 'F';", "select");
$gns_courses;
$total_units_available = 0;

if(!empty($level_courses)){
	echo "<h3>FIRST SEMESTER</h3>";
	for($i=0; $i<count($level_courses); $i++){
		$prereqFlag = true;
	
		//To check if a course has a failed prerequisite
		//If it does, the $prereqFlag flag would be set to false and the student will not be able to register that course
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
				else $prereqFlag  = false;
				}	
			}
		}

		
	if($level_courses[$i]["semester"] == 1){ 
		echo "<div class = \"divrow\">";
		echo "<div class = \"divcell\">";
		if($prereqFlag == false){
			echo "<input type = \"checkbox\" name = \"{$this_student->matricNo}[]\" value = {$level_courses[$i]["code"]}  onclick = \"return(false);\" >";
		}
		elseif (($prereqFlag == true)) {
			echo "<input type = \"checkbox\" name = \"{$this_student->matricNo}[]\" value = {$level_courses[$i]["code"]} >";
		}

		echo "</div>";
		if($prereqFlag == false)
			echo "<font color= \"red\">";
		echo "<div class = \"divcell\">";
		echo "<label for = \"{$this_student->matricNo}[]\"> {$level_courses[$i]["code"]} </label>";
		echo "</div>";
		echo "<div class = \"divcell\">";
		echo "<label for = \"{$this_student->matricNo}[]\"> {$level_courses[$i]["name"]} </label>";
		echo "</div>";
		echo "<div class = \"divcell\">";
		echo "<label for = \"{$this_student->matricNo}[]\"> {$level_courses[$i]["units"]} </label>";
		echo "</div>";
		echo "<div class = \"divcell\">";
		echo "<label for = \"{$this_student->matricNo}[]\"> {$level_courses[$i]["status"]} </label>";
		echo "</div>";

echo "</div>";
if($prereqFlag == false)
echo "</font>";
if($prereqFlag != false)
$total_units_available = $total_units_available + $level_courses[$i]["units"];
}
}
echo "<h3>SECOND SEMESTER</h3>";
for($i=0; $i<count($level_courses); $i++){
	$prereqFlag = true;
	//$compulsory = true;

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
		else $prereqFlag  = false;
	}
}
}
if($level_courses[$i]["semester"] == 2){ 
echo "<div class = \"divrow\">";
echo "<div class = \"divcell\">";
if($prereqFlag == false){
	echo "<input type = \"checkbox\" name = \"{$this_student->matricNo}[]\" value = {$level_courses[$i]["code"]}  onclick = \"return(false);\" >";
}
elseif (($prereqFlag == true)) {
	echo "<input type = \"checkbox\" name = \"{$this_student->matricNo}[]\" value = {$level_courses[$i]["code"]} >";
}

echo "</div>";
if($prereqFlag == false)
	echo "<font color= \"red\">";
	echo "<div class = \"divcell\">";
	echo "<label for = \"{$this_student->matricNo}[]\"> {$level_courses[$i]["code"]} </label>";
	echo "</div>";
	

echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$level_courses[$i]["name"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$level_courses[$i]["units"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$level_courses[$i]["status"]} </label>";
echo "</div>";
echo "</div>";
if($prereqFlag == false)
echo "</font>";
if($prereqFlag != false)
$total_units_available = $total_units_available + $level_courses[$i]["units"];
}
}
}	




if(!empty($failed_compulsory)){
echo "<p><center><h4> CARRIED COURSES</h4></center>";
echo "<h3>FIRST SEMESTER</h3>";
if($fail)
for($i=0; $i < count($failed_compulsory);$i++){
	echo "<div class = \"divrow\">";
echo "<div class = \"divcell\">";
echo "<input type = \"checkbox\" name = \"{$this_student->matricNo}[]\" value = {$failed_compulsory[$i]["code"]} >";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for =\"{$this_student->matricNo}[]\">". $failed_compulsory[$i]["code"]. "</label>" ;
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$failed_compulsory[$i]["name"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$failed_compulsory[$i]["units"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$failed_compulsory[$i]["status"]} </label>";
echo "</div>";

echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$failed_compulsory[$i]["semester"]} </label>";
echo "</div>";
echo "</div>";
	$total_units_available = $total_units_available + $failed_compulsory[$i]["units"];
}

}
$missed = $db->query("select * from courses where programmeId = '{$this_student->programmeId}' and level < '{$this_student->level}' and status = 'C';", "select");

//var_dump($missed);
$registered = $db->query("select * from coursestaken where studentId = '{$this_student->id}';", "select");
/*var_dump($registered);
var_dump($missed);
*/for($i = 0; $i < count($registered); $i++){
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
	echo "<center><h4> OTHER UNREGISTERED COMPULSORY COURSES</h4></center>";
	
for($i=0;$i<count($missed);$i++){
	//$missed_counter = 0;
	$prereqFlag = true;
	//$compulsory = true;
	
if($missed[$i] == NULL){
	//$missed_counter++;
	continue;
	
}

$pre = $db->query("select prerequisiteId from courses where code = '{$missed[$i]["code"]}';","select");

if($pre[0]["prerequisiteId"] != null){
	$pre_course = $db->query("select courseCode from prerequisite where id = '{$pre[0]["prerequisiteId"]}';", "select");
	
	if($pre_course){
		$check_pre = $db->query("select grade from coursestaken where courseCode = '{$pre_course[0]["courseCode"]}' and studentId = '{$this_student->id}';", "select");
		
		if($check_pre[0]["grade"] == "F" )
		$prereqFlag = false;
	}
}

echo "<div class = \"divrow\">";
echo "<div class = \"divcell\">";
if($prereqFlag == false)
echo "<input type = \"checkbox\" name = \"{$this_student->matricNo}[]\" value = {$missed[$i]["code"]} onclick = \"return(false);\"   >";
else
echo "<input type = \"checkbox\" name = \"{$this_student->matricNo}[]\" value = {$missed[$i]["code"]}  >";
echo "</div>";
if($prereqFlag == false)
echo "<font color= \"red\">";
echo "<div class = \"divcell\">";
echo "<label for =\"{$this_student->matricNo}[]\">". $missed[$i]["code"]. "</label>" ;
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$missed[$i]["name"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$missed[$i]["units"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$missed[$i]["status"]} </label>";
echo "</div>";

echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$missed[$i]["semester"]} </label>";
echo "</div>";
echo "</div>";
if($prereqFlag == false)
echo "</font>";
if($prereqFlag != false)
$total_units_available = $total_units_available + $missed[$i]["units"];
	}
}

if($this_student->modeOfEntry == "UME"){
	$gns_courses = $db->query("select * from gns_courses where level = '{$this_student->level}';", "select");
	$missed_gns = $db->query("select * from gns_courses where level < '{$this_student->level}';", "select");
	//var_dump($missed_gns);
}
elseif(($this_student->modeOfEntry == "DE") || ($this_student->modeOfEntry == "DFP")){
	$gns_courses = $db->query("select * from gns_courses where level = ({$this_student->level} - 100);", "select");
	$missed_gns = $db->query("select * from gns_courses where level < ({$this_student->level} - 100);", "select");
}
$failed_gns = $db->query("select gns_courses.* from coursestaken, gns_courses where coursestaken.studentId = '{$this_student->id}' and coursestaken.courseCode = gns_courses.code and coursestaken.grade = 'F';", "select");
$registered_gns= $db->query("select * from coursestaken where studentId = '{$this_student->id}' and courseCode like 'GNS%';", "select");
//var_dump($failed_gns);
for($i = 0; $i < count($registered_gns); $i++){
	for($j = 0; $j < count($missed_gns); $j++){
		if(@$registered_gns[$i]["courseCode"] == $missed_gns[$j]["code"]){
			$missed_gns[$j] = NULL;
			
		}
	}
}
$counter_missed_gns = 1;
for($i=0;$i<count($missed_gns);$i++){
	if($missed_gns[$i] == NULL)
	$counter_missed_gns++;
}
if(!empty($gns_courses)){
	echo "<p><center><h4> GNS COURSES</h4></center>";
	for($i = 0; $i < count($gns_courses); $i++){
echo "<div class = \"divrow\">";
echo "<div class = \"divcell\">";
echo "<input type = \"checkbox\" name = \"{$this_student->matricNo}[]\" value = \"{$gns_courses[$i]["code"]}\"   >";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for =\"{$this_student->matricNo}[]\">". $gns_courses[$i]["code"]. "</label>" ;
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$gns_courses[$i]["name"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$gns_courses[$i]["units"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$gns_courses[$i]["status"]} </label>";
echo "</div>";

echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$gns_courses[$i]["semester"]} </label>";
echo "</div>";
echo "</div>";
$total_units_available = $total_units_available + $gns_courses[$i]["units"];
	}
}
if(!empty($failed_gns)){
echo "<p><center><h4>FAILED GNS COURSES</h4></center>";
	for($i = 0; $i < count($failed_gns); $i++){
echo "<div class = \"divrow\">";
echo "<div class = \"divcell\">";
echo "<input type = \"checkbox\" name = \"{$this_student->matricNo}[]\" value = \"{$failed_gns[$i]["code"]}\"   >";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for =\"{$this_student->matricNo}[]\">". $failed_gns[$i]["code"]. "</label>" ;
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$failed_gns[$i]["name"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$failed_gns[$i]["units"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$failed_gns[$i]["status"]} </label>";
echo "</div>";

echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$failed_gns[$i]["semester"]} </label>";
echo "</div>";
echo "</div>";
$total_units_available = $total_units_available + $failed_gns[$i]["units"];
	}
}
if($counter_missed_gns != count($missed_gns)){
	echo "<center><h4> OTHER UNREGISTERED GNS COURSES</h4></center>";
for($i=0;$i<count($missed_gns);$i++){
	
	
if($missed_gns[$i] == NULL){
	continue;
}

echo "<div class = \"divrow\">";
echo "<div class = \"divcell\">";

echo "<input type = \"checkbox\" name = \"{$this_student->matricNo}[]\" value = {$missed_gns[$i]["code"]}  >";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for =\"{$this_student->matricNo}[]\">". $missed_gns[$i]["code"]. "</label>" ;
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$missed_gns[$i]["name"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$missed_gns[$i]["units"]} </label>";
echo "</div>";
echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$missed_gns[$i]["status"]} </label>";
echo "</div>";

echo "<div class = \"divcell\">";
echo "<label for = \"{$this_student->matricNo}[]\"> {$missed_gns[$i]["semester"]} </label>";
echo "</div>";
echo "</div>";
	$total_units_available = $total_units_available + $missed_gns[$i]["units"];
	}
}

echo "TOTAL UNITS AVAILABLE: {$total_units_available} <br />"; 

echo "<input type = \"submit\" name = \"register\" value = \"register\">";

?>
</div>
</form>




</body>
</html>