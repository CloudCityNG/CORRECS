<?php session_start();
require_once("includes/initialize.php"); 
$db = DatabaseWrapper::getInstance();
?>
<html>
<head><title></title>
<link href="stylesheets.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="script.js">
</script>	
<link type="text/css" rel="stylesheet" href="css/login.css" media="all" /> 
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/box_design.css" media="all" />
<link type="text/css" rel="stylesheet" href="css/public.css" media="all" />
</head>
<body>

<?php include("includes/header.php");?>
<div id="container">
<table>

<tr><td id="navigation">
<ul>
<li><a href="index.php">Cancel</a></li>
</ul>
</td>
<td id="page">
<div id="content">
<?php 
$error_message = FlashMessages::getInstance();
$key = "registration";
$error_message->displayMessage("registration");
$error_message->unsetMessage("registration");
?>
<fieldset><legend><h3>Registration Page</h3></legend>
<form method = "post" action = "register_student.php" enctype = "multipart/form-data">	
 <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
<div class="divtable"><p>
	<div class ="divrow">
    <div class = "divcell">
     Surname:
     </div>
  <div class="divcell"><label for="surName"></label>
    <input type="text" name="lname" id="lname">  
    
    </div>
    </div>
    <div class = "divrow">
    <div class = "divcell">
    First Name:
    </div>
    <div class ="divcell"><input type = "text" name ="fname" id = "fname"></input></div>
    </div>
     <div class = "divrow">
    <div class = "divcell">
    Middle Name:
    </div>
    <div class ="divcell"><input type = "text" name ="onames" id = "onames"></input></div>
    </div>
    <div class ="divrow">
    <div class = "divcell">
     Sex: 
     </div>
  <div class="divcell"><label for="sex"></label>
    <select name="sex" id="sex">
      <option value="select">Select Sex</option>
      <option value="male">Male</option>
      <option value="female">Female</option>
    </select>
  </div>
    </div>
    <div class="divrow">
 <div class="divcell">
 Matric Number:
 </div>
 <div class="divcell">
 	<select name = "prematric" id = "prematric"> 
 	<option value = ""></option>
 		<?php 
 			$colleges = $db->query("select * from colleges;", "select");
 			if(!empty($colleges)){
 				for($i=0;$i<count($colleges); $i++){
 					if($colleges[$i]["matricPrefix"] == "none")
 					continue;
 					else
 					echo "<option value = \"{$colleges[$i]["matricPrefix"]}\">{$colleges[$i]["matricPrefix"]}/</option>";
 				}
 			}
 		?>
    </select>
    <input type = "text" name ="matric" size= "10" id = "matric"></input>
    
 </div>
 
 </div>
    <div class ="divrow">
    <div class = "divcell">
     College: 
     </div>
  <div class="divcell"><label for="college"></label>
    <select name="college" id="college">
      <option value = "select">Select College</option>

 		<?php 
 			$colleges = $db->query("select * from colleges;", "select");
 			if(!empty($colleges)){
 				for($i=0;$i<count($colleges); $i++){
 					if($colleges[$i]["matricPrefix"] == "none")
 					continue;
 					else
 					echo "<option value = \"{$colleges[$i]["collegeId"]}\">{$colleges[$i]["name"]}/</option>";
 				}
 			}
 		?>
    </select>
  </div>
    </div>
    <div class ="divrow">
    <div class = "divcell">
    Department:
    </div>
    <div class="divcell"><label for="department"></label>
    <select name="department" id="department">
    	<option value = "">Department</option>
    		<?php 
 			$departments = $db->query("select * from departments;", "select");
 			if(!empty($departments)){
 				for($i=0;$i<count($departments); $i++){
 					echo "<option value = \"{$departments[$i]["deptId"]}\">{$departments[$i]["deptName"]}</option>";
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
      <option value = "">Programme</option>
      <?php 
 			$programmes = $db->query("select * from programmes;", "select");
 			if(!empty($programmes)){
 				for($i=0;$i<count($programmes); $i++){
 					echo "<option value = \"{$programmes[$i]["programmeId"]}\">{$programmes[$i]["name"]}</option>";
 				}
 			}
 		?>
    </select>
  	</div>
  </div>
  
 <!--  <div class="divrow">
 <div class="divcell">
 Entry Level: 
 </div>
 <div class="divcell">
    <select name="entrylevel" id="entrylevel">
      <option value = "">Select Level</option>
      <option value = 100>100</option>
      <option value = 200>200</option>
     
    </select>
 </div>
 
 </div> -->
 <div class="divrow">
 <div class="divcell">
 Mode of Entry: 
 </div>
 <div class="divcell">
 <select name="modeofentry" id="modeofentry">
      <option value = "">Select </option>
      <option value = "UME">UME</option>
      <option value = "DE">Direct Entry</option>
       <option value = "DFP">DFP</option>
    </select>
 </div>
 
 </div>
<!--  <div class="divrow">
 <div class="divcell">
Entry Year: 
 </div>
 <div class="divcell">
 <select name="entryyear" id="entryyear">
      <option value = "">Select </option>
      <option value = 2007>2007</option>
      <option value = 2008>2008</option>
      <option value = 2009>2009</option>
      <option value = 2010>2010</option>
      <option value = 2011>2011</option>
      <option value = 2012>2012</option>
      <option value = 2013>2013</option>
      <option value = 2014>2014</option>
      <option value = 2015>2015</option>
      <option value = 2016>2016</option>
    </select>
 </div>
 
 </div> -->
<!-- <!--  <div class="divrow">
 <div class="divcell">
 Level: 
 </div>
 <div class="divcell">
 <select name="level" id="level">
      <option value = "">Select Level</option>
      <option value = 100>100</option>
      <option value = 200>200</option>
      <option value = 300>300</option>
      <option value = 400>400</option>
      <option value = 500>500</option>
      <option value = 600>600</option>
    </select>
 </div>
 
 </div> --> 
 <div class="divrow">
 <div class="divcell">
 Upload Photograph:
 </div>
 <div class="divcell">
 <input type = "file" name="photograph" value=""></input>
 </div>
 
 </div>
 <div class = "divrow">
 <div class = "divcell">
 <font size = -5>The maximum size for a picture uploadable is 2MB.</font>
 </div>
 </div>
 <div class="divrow">
 <div class="divcell">
 Username: 
 </div>
 <div class="divcell">
 <input type = "text" name = "username" id="username"></input>
 </div>
 
 </div>
 <div class="divrow">
 <div class="divcell">
 Password: 
 </div>
 <div class="divcell">
 <input type = "password" name = "password" id="password"></input>
 </div>
 
 </div>
  <div class="divrow">
 <div class="divcell">
Confirm Password: 
 </div>
 <div class="divcell">
  <input type = "password" name = "confirm_password" id="confirm_password"></input>
 </div>
 
 </div>
 <!--<div class="divrow">
 <div class="divcell">
 <label for="emailAddr">Enter your email address:&nbsp;&nbsp;
    <input id="emailAddr" name="email" type="text" size="30" class="reqd email" />
    </label>
    </div>
    <label for="emailAddr2">Re-enter your email address:
    <input id="emailAddr2" type="text" size="30" class="reqd emailAddr" />
    </label>
 
 </div>
 
 
 --><input type= "submit" name = "register" value = "Register"></input>
 </div>
 </form>
 </div>
 </fieldset>
 </td>
 </tr>
 </table>
</div>
</body>
</html>

