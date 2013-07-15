<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in()){
	Header("Location: index.php");
	
}
else{
	$this_student = initStudent();
	$db = DatabaseWrapper::getInstance();
	//$table = $db->query("select name from programmes where programmeId = {$this_student->programmeId};", "select");
	$has_registered = $db->query("select * from registration_log where studentId = '{$this_student->id}' and session = '{$session[0]["currentSession"]}';", "select");
	
}
if(isset($_POST["register"])){
	$error_array = array();
	$success_array = array();
	$submitted =  @$_POST["{$this_student->matricNo}"];
	
	/*if($submitted == null){
		$error_array[] = "Please tick courses that you would register";
		
	}*/
	
	$total_units_semester1 = 0;
	$total_units_semester2 = 0;
	$universitySession = $db->query("select currentSession from university where name = 'Fountain University Osogbo';", "select");
	if(!empty($submitted)){
	for ($i=0;$i < count($submitted); $i++){
		
		$unit1 = $db->query("select units,semester from courses where code = '{$submitted[$i]}' and semester = '1';", "select");
		$unit2 = $db->query("select units,semester from courses where code = '{$submitted[$i]}' and semester = '2';", "select");
		
		//var_dump($unit);
		if(!empty($unit1))
		$total_units_semester1 = $total_units_semester1 + $unit1[0]["units"];
		elseif(!empty($unit2))
		$total_units_semester2 = $total_units_semester2 + $unit2[0]["units"];
	
	
	
	if($total_units_semester1 > 24 || $total_units_semester2 > 24){
		$error_array[] = "You cannot register more than 24 units in a semester";
	}
	else{
		$total_units = $total_units_semester1 + $total_units_semester2;
	}
	
	$check_registered = $db->query("select * from coursestaken where studentId = '{$this_student->id}' and session = '{$universitySession[0]["currentSession"]}' and courseCode = '{$submitted[$i]}';", "select");
	if(!empty($check_registered))
	$error_array[] = "You have registered {$submitted[$i]} before this session!";
	
	
	}
	if(!empty($has_registered)){
	if(($has_registered[0]["total_units_registered"] + $total_units_semester1 + $total_units_semester2) > 48 ){
		$error_array[] = "You are Registering for more courses than you can offer in a session";
	}
	}
	
}
else{
	$error_array[] = "Please tick at least one course";
}
if(!empty($error_array)){
	$error_messages = FlashMessages::getInstance();
	$type = "error";
	$key = "registration";
	$error_messages->setMessages($error_array, $type, $key);
	header("Location: student_course_regg.php");
}
	
if(empty($error_array)){
		
		for($i=0;$i<count($submitted);$i++){
			$find = $db->query("select (max(id) + 1) from coursestaken;", "select");
			
			$semester = $db->query("select semester from courses where code = '{$submitted[$i]}';", "select");
			$has_registered = $db->query("select *  from coursestaken where studentId = '{$this_student->id}' and courseCode = '{$submitted[$i]}';", "select");
			if(!empty($has_registered)){
			$update = $db->query("update coursestaken set session = ? where studentId = ? and courseCode = ? ;",$universitySession[0]["currentSession"],$this_student->id,$submitted[$i], "update");
			if($update){
			$success_array[] = $submitted[$i];
			}
			}
			else{
			
			$new = $db->query("insert into coursestaken values (?,?,?,?,?,?,?,?,?,?);",$find[0]['(max(id) + 1)'], $this_student->id, $submitted[$i],$this_student->deptId, $semester[0]["semester"],$universitySession[0]["currentSession"],"null","null","null","O", "insert");
			if($new)
			$success_array[] = $submitted[$i];
			}
			
	}
	
	if(count($success_array) == count($submitted)){
		
		$registration_log = $db->query("select * from registration_log where studentId = '{$this_student->id}' and session = '{$universitySession[0]["currentSession"]}';", "select");
		if(!empty($registration_log)){
			$new_total_times = $registration_log[0]["no_times_registered"] + 1;
			$new_total_units = $registration_log[0]["total_units_registered"] + $total_units;
			$update_log = $db->query("update registration_log set no_times_registered = ?, total_units_registered = ? where studentId = ? and session = ?;", $new_total_times, $new_total_units, $this_student->id, $universitySession[0]["currentSession"], "update");
		}
		else{
			$next_id = $db->query("select (max(id) + 1) from registration_log;", "select");
			$update_log = $db->query("insert into registration_log values (?,?,?,?,?);", $next_id[0][0], $this_student->id, $universitySession[0]["currentSession"],1,$total_units, "insert");
		}
		if($update_log){
		$error_messages = FlashMessages::getInstance();
		$type = "notify";
		$key = "registration";
		$error_messages->setMessages("You have registered successfully <br> <a href = \"student_homepage.php\"> Go Home</a>", $type, $key);
		
		}
		$first_semester = $db->query("select * from coursestaken where studentId = '{$this_student->id}' and session = '{$universitySession[0]["currentSession"]}' and semester = 1;", "select");
		$second_semester = $db->query("select * from coursestaken where studentId = '{$this_student->id}' and session = '{$universitySession[0]["currentSession"]}' and semester = 2;", "select");
		
	}
	
	}
	
}
?>

<html>
<head> <title>Print Course Registration Form</title>
<link href="stylesheets.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/login.css" media="all" /> 
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/public.css" media="all" />
<script type="text/javascript" src="script.js">
</script>
</head>
<body>

<?php include("includes/header.php");?>

<?php 
$error_messages->displayMessage("registration");
$error_messages->unsetMessage("registration");
?>
<?php 
echo "<center>";
echo "<h3 align=\"center\">FIRST SEMESTER</h3>";
echo "<div class = \"divtable\">";
echo "<div class = \"divrow\">";
echo "<div class = \"divcell\">";
echo "s/n";
echo "</div>";
echo "<div class = \"divcell\">";
echo "Course Code";
echo "</div>";
echo "<div class = \"divcell\">";
echo "Course Name";
echo "</div>";
echo "<div class = \"divcell\">";
echo "Course Units";
echo "</div>";
echo "</div>";
for($i = 0; $i < count($first_semester);$i++){
	if(!preg_match("(GNS.[0-9])", $first_semester[$i]["courseCode"]))
	$course = $db->query("select * from courses where code = '{$first_semester[$i]["courseCode"]}' and programmeId = '{$this_student->programmeId}';", "select");
	else
	$course = $db->query("select * from courses where code = '{$first_semester[$i]["courseCode"]}';", "select");
	echo "<div class = \"divrow\">";
	echo "<div class = \"divcell\">";
	echo $i + 1;
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo $course[0]["code"];
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo $course[0]["name"];
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo $course[0]["units"];
	echo "</div>";
	echo "</div>";
}
echo "Total Units: {$total_units_semester1}<br />";
echo "</div>";
echo "<h3 align=\"center\">SECOND SEMESTER</h3>";
echo "<div class = \"divtable\">";
echo "<div class = \"divrow\">";
echo "<div class = \"divcell\">";
echo "s/n";
echo "</div>";
echo "<div class = \"divcell\">";
echo "Course Code";
echo "</div>";
echo "<div class = \"divcell\">";
echo "Course Name";
echo "</div>";
echo "<div class = \"divcell\">";
echo "Course Units";
echo "</div>";
echo "</div>";

if(!empty($second_semester)){
for($i = 0; $i < count($second_semester);$i++){
	if(!preg_match("(GNS.[0-9])", $second_semester[$i]["courseCode"]))
	$course = $db->query("select * from courses where code = '{$second_semester[$i]["courseCode"]}' and programmeId = '{$this_student->programmeId}';", "select");
	else
	$course = $db->query("select * from courses where code = '{$second_semester[$i]["courseCode"]}';", "select");
	echo "<div class = \"divrow\">";
	echo "<div class = \"divcell\">";
	echo $i + 1;
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo $course[0]["code"];
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo $course[0]["name"];
	echo "</div>";
	echo "<div class = \"divcell\">";
	echo $course[0]["units"];
	echo "</div>";
	echo "</div>";
}
echo "Total Units: {$total_units_semester2}<br />";
echo "</div>";

echo "Total units for the Session: {$total_units} <br />";
}
echo "</center>";
?>

</body>
</html>