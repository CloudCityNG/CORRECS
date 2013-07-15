<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in()){
	Header("Location: index.php");
}
else{
	$db = DatabaseWrapper::getInstance();
	$using_lecturer = initLecturer();
	
}
?>
<html>
<head><title>Add a new Course</title>
<link href="stylesheets.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="script.js">
	</script>	
<link href="stylesheets.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="script.js">
</script>	
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
<h5><?php echo $using_lecturer->fullName(); ?>&nbsp;</h5></p>
</td><td align="right"><h3><a href="logout.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp; </h3></td></tr>
<tr><td id="navigation">
<img src = "<?php echo $using_lecturer->photograph ;?>"  align = "center" height = 150 width = 150> 
 <br><br>
 <ul><li>
<a href = "lecturer_homepage.php"> Back to Lecturer Homepage</a>
</li>
<li><a href="department_admin_page.php?department=<?php echo $using_lecturer->deptId ?>">Back to Admin Dashboard</a>
</li></ul>
</td>
<td id="page">
<?php 
$error_message = FlashMessages::getInstance();
$key = "course";
$error_message->displayMessage("course");
$error_message->unsetMessage("course");
 
?>
<center><h2>Create a New Course</h2></center>
<form method = "post" action = "add_new_course_backend.php" enctype = "multipart/form-data">	
 
<div class="divtable">
	<div class ="divrow">
    <div class = "divcell">
     Code:
     </div>
  <div class="divcell"><label for="code"></label>
  	<input type="text" name = "precode" size = 3>
    <input type="text" name="code" id="code" size = 3>  
    
    </div>
    </div>
    <div class = "divrow">
    <div class = "divcell">
    Course Name:
    </div>
    <div class ="divcell"><input type = "text" name ="name" id = "name"></input></div>
    </div>
     <div class = "divrow">
    <div class = "divcell">
    units:
    </div>
    <div class ="divcell">
    <select name = "units" id = "units">
    	<option value = "" selected = "selected"> Select Unit</option>
    	<option value = 1>1</option>
    	<option value = 2>2</option>
    	<option value = 3>3</option>
    	<option value = 4>4</option>
    	<option value = 5>5</option>
    	<option value = 6>6</option>
     </select>
    </div>
    </div>
    <div class ="divrow">
    <div class = "divcell">
     status: 
     </div>
  <div class="divcell"><label for="status"></label>
    <select name="status" id="status">
      <option value="">Select Status</option>
      <option value="C">Compulsory</option>
      <option value="E">Elective</option>
    </select>
  </div>
    </div>
    
 
 
    <div class ="divrow">
    <div class = "divcell">
    Semester: 
     </div>
  <div class="divcell"><label for="semester"></label>
    <select name="semester" id="semester">
      <option value = "">Select semester</option>
      <option value = 1>1</option>
      <option value = 2>2</option>
    </select>
  </div>
    </div>
    <div class ="divrow">
    <div class = "divcell">
    Description:
    </div>
    <div class="divcell"><label for="description"></label>
    <textarea name = "description" id = "description" rows = 10 cols =30></textarea>
    </div>
    </div>
 
	<div class ="divrow">
    <div class = "divcell">
    Lecturer: 
    </div>
  	<div class="divcell"><label for="lecturer"></label>
  	<select name="lecturer" id="lecturer">
  		<option value = "" selected = "selected"> Select Lecturer</option>
      <?php 
      	$lecturers = $db->query("select * from lecturers where deptId = '{$using_lecturer->deptId}';", "select");
      	if(!empty($lecturers)){
      		for($i=0;$i<count($lecturers);$i++){
      			//echo $lecturers[$i]["id"];
      			echo "<option value = {$lecturers[$i]["id"]}> {$lecturers[$i]["fname"]}  {$lecturers[$i]["lname"]}</option>";
      		}
      	}
      ?>
      
    </select>
  	</div>
  </div>
  <div class ="divrow">
    <div class = "divcell">
    Programme: 
    </div>
  	<div class="divcell"><label for="programme"></label>
  	<select name="programme" id="programme">
  		<option value = "" selected = "selected"> Select Programme</option>
      <?php 
      	$programmes = $db->query("select * from programmes where departmentId = '{$using_lecturer->deptId}';", "select");
      	if(!empty($programmes)){
      		for($i=0;$i<count($programmes);$i++){
      			echo "<option value = \"{$programmes[$i]["programmeId"]}\">{$programmes[$i]["name"]}</option>";
      		}
      	}
      ?>
      
    </select>
  	</div>
  </div>
  
 <input type= "submit" name = "create" value = "Create"></input>
 </div>
 </form>
 
 
 	
 
 </td>
 </tr>
 </table>
</div> 
 </body>
 </html>