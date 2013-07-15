<?php
session_start();

require_once("includes/initialize.php");
if(!is_logged_in()){
	header("Location: index.php");
}
else{
	$db = DataBaseWrapper::getInstance();
	$this_lecturer = initLecturer();
	$level_adviser = $db->query("select * from level_advisers where lecturerId = '{$this_lecturer->id}';", "select");
	$list_students = $db->query("select * from student_info where entryYear = '{$level_adviser[0]["entryYear"]}' and programmeId = '{$level_adviser[0]["programmeId"]}';", "select");
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">	
<title>Promote Student</title>
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
<li><a href="department_admin_page.php">Back to Admin Dashboard</a>
</li></ul>
</td>
<td id="page">
<form action="<?php echo $_SERVER["PHP_SELF"]?>" method = "post">
<h2>Are you sure you want to promote the students in your class?</h2>

<input type = "submit" name = "yes" id = "yes" value = "Yes"></input>

&nbsp;
&nbsp;
&nbsp;
<input type = "submit" name = "no" value = "no"></input>
</form>
<?php
if(isset($_POST["yes"])){
	if(!empty($list_students)){
		$promoted_count = 0;
		$not_promoted_array = array();
		for($i=0;$i<count($list_students); $i++){
			$promote_query;
			$level_query;
			$compulsory_carryover_counter = 0;
			$db = DatabaseWrapper::getInstance();
			$new_level;
			$instance = $db->query("select * from student_info where id  = '{$list_students[$i]["id"]}';","select");
			if($instance){
				$this_student = Student::instantiate($instance[0]);
		
			}
			$new_semester = $this_student->currentSemester + 1;
		
			if($new_semester % 2 != 0 && ($this_student->level != 400)){
				$new_level = $this_student->level + 100;
				$promote_query = $db->query("update student_info set currentSemester = ?, level = ? where id = ?;", $new_semester, $new_level, $this_student->id, "update");
				
			}
			elseif($new_semester % 2 == 0 && ($this_student->level != 400)){
				$promote_query = $db->query("update student_info set currentSemester = ? where id = ?;", $new_semester, $this_student->id,"update");
			}
		
		
			elseif($this_student->level == 400){
			
				if($new_semester % 2 == 0){
				
					$promote_query = $db->query("update student_info set currentSemester = ? where id = ?;", $new_semester, $this_student->id, "update");
				}
				else{
					
					$carry_over = $db->query("select * from coursestaken where studentId = '{$this_student->id}' and (grade = 'F' or grade = 'O');", "select");
			
					
						if(!empty($carry_over)){
						
							for($j = 0; $j < count($carry_over); $j++){
							if(preg_match("(GNS.[0-9])",$carry_over[$j]["courseCode"]))
								$compulsory_carryover_counter = $compulsory_carryover_counter + 1;
							else{
								$failed = $db->query("select * from courses where code = '{$carry_over[$j]["courseCode"]}' and departmentId = '{$this_student->deptId}';", "select");
								if($failed[0]["status"] == "C");
									$compulsory_carryover_counter = $compulsory_carryover_counter + 1;
								}
							}	
					if($compulsory_carryover_counter > 0){
				
				
					}
			
			
				}
			else{
			
				if($new_semester % 2 != 0)
				
				$promote_query = $db->query("update student_info set currentSemester = ?,level = ? where id = ?;", 0, 0, $this_student->id, "update");
			
			}
			}
		}
		
		if($compulsory_carryover_counter > 0){
			
			$not_promoted_array[] = "{$list_students[$i]["lname"]} {$list_students[$i]["fname"]}";
		}
		elseif($promote_query){
			$promoted_count = $promoted_count + 1;
			
			
			
		}
		else{
			
		}
		
	}

	if($promoted_count != count($list_students)){
		echo "The following students could not be promoted: <br />";
		for($m=0;$m<count($not_promoted_array);$m++){
			echo "<p>{$not_promoted_array[$m]} </p>";
		}
		echo "The remaining students were successfully promoted <br />";
	}
	else{
		echo "<p> All Students have  been promoted successfully </p>";
	}
	}
}
elseif(isset($_POST["no"])){
	header("Location: list_students.php?programmeId={$level_adviser[0]["programmeId"]}&entryYear={$level_adviser[0]["entryYear"]}");
}
?>
</td>
 </tr>
 </table>
</div> 
</body>
</html>