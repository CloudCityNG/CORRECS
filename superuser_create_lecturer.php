<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in()){
	header("Location: index.php");
	
}
else{
	
}

?>
<html>
<head><title>Add a new Lecturer: Super User</title>
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

</td><td align="right"><h3><a href="logout.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp; </h3></td></tr>
<tr><td id="navigation">
 
 <br><br>
 <ul><li>
<a href = "superuser_homepage.php"> Back to Super Homepage</a>
</li>
</ul>
</td>
<td id="page">
<?php
$error_message = FlashMessages::getInstance();
$key = "lecturer";
$error_message->displayMessage("lecturer");
$error_message->unsetMessage("lecturer");
?>
<form method = "post" action = "superuser_add_lecturer.php" enctype = "multipart/form-data">	
 <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
 <h2>Add a new Lecturer</h2>
<div class="divtable">
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
   
 <div class="divrow">
 <div class="divcell">
Year Employed: 
 </div>
 <div class="divcell">
 <select name="yearemployed" id="yearemployed">
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
 <div class="divrow">
 <div class="divcell">
 Upload Photograph:
 </div>
 <div class="divcell">
 <input type = "file" name="photograph" value=""></input>
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
 
 
 -->
 
 <input type= "submit" name = "register" value = "Register"></input>
 </div>
 </form>
 
 </td>
 </tr>
 </table>
</div> 
</body>
</html>

