<?php
session_start(); 
require_once("includes/initialize.php");
if(!is_logged_in()){
	Header("Location: index.php");
	
}
else{
	$db = DatabaseWrapper::getInstance();
	
	
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<link href="stylesheets.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/login.css" media="all" /> 
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/box_design.css" media="all" />
<link type="text/css" rel="stylesheet" href="css/public.css" media="all" />

<title>New College</title>
</head>
 <body>
 <?php include("includes/header.php");?>
 <div id="container">
<table>
<tr id="nav_bar"><td align="left"><p>
<h5>&nbsp;</h5></p>
</td><td align="right"><h3><a href="logout.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp; </h3></td></tr>
<tr><td id="navigation">
 <ul>
<li><a href="logout.php">Logout</a>
</li></ul>
</td>
<td id="page">
<div id="content">
<fieldset><legend><h3>Create a new College</h3></legend>
 <form action  = "<?php echo $_SERVER["PHP_SELF"]?>" method = "post">
 <div class = "divtable">
 <div class = "divrow">
 <div class = "divcell">
College Name: 
</div>
<div class = "divcell">
<input type = "text" name = "name" id = "name"></input>
</div>
</div>
 <div class = "divrow">
 <div class = "divcell">
College Dean: 
</div>
<div class = "divcell">
<input type = "text" name = "dean" id = "dean"></input>
</div>
</div>
<div class = "divrow">
 <div class = "divcell">
MATRIC NUMBER PREFIX (please input like (NAS/)): 
</div>
<div class = "divcell">
<input type = "text" name = "prefix" id = "prefix"></input>
</div>
</div>
<input type = "submit" name = "submit" value = "Submit"></input>
  </div>

 <?php 
 if(isset($_POST["submit"])){
 	$name = $_POST["name"];
 	$dean = $_POST["dean"];
 	$prefix  = $_POST["prefix"];
 	
 	$error_array = array();
 	
 	if(empty($name) || empty($dean) || empty($prefix)){
 		$error_array[] = "Please input values in all fields";
 	}
 	
 	if(empty($error_array)){
 		$last_college = $db->query("select (max(collegeId + 1)) from colleges;", "select");
 		$update = $db->query("insert into colleges values (?,?,?,?);", $last_college[0][0], $name, $dean,$prefix, "insert");
 		if($update){
 			$error_messages = FlashMessages::getInstance();
			$type = "notify";
			$key = "college";
			$success_message  =  "College has been created <br />";
 			$success_message.= "<a href = \"superuser_homepage.php\">Go back</a>";
			$error_messages->setMessages($success_message, $type, $key);
 		}
 	}
 	else{
 		$error_messages = FlashMessages::getInstance();
		$type = "error";
		$key = "college";
		$error_messages->setMessages($error_array, $type, $key);
 	}
 }
 ?>
 <?php 
$error_message = FlashMessages::getInstance();
$key = "college";
$error_message->displayMessage("college");
$error_message->unsetMessage("college");

?>
  </form>
 </fieldset>
 </div>
 </td>
 </tr>
 </table>
</div>
 </body>
 </html>