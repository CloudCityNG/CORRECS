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
<title>Change Fountain Scholar score</title>
<link type="text/css" rel="stylesheet" href="css/login.css" media="all" /> 
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/box_design.css" media="all" />
<link type="text/css" rel="stylesheet" href="css/public.css" media="all" />
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
<li>
<h3><a href="logout.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp; </h3></li></ul></td>
 <td id="page">
<h2>Change Fountain Scholar grade</h2>

<form method = "post" action = "<?php echo $_SERVER["PHP_SELF"]?>">
New Grade:
<input type = "text" name = "grade" id = "grade"></input>

<br />
<input type = "submit" name = "submit" value = "Submit"></input>
</form>
<?php 
if(isset($_POST["submit"])){
	$grade = $_POST["grade"];
	$error_array = array();
	if(empty($grade)){
		$error_array[] = "Please input a grade";
	}
	elseif(!is_numeric($grade)){
		$error_array[] = "Please input decimal grade";
	}
	if(empty($error_array)){
		$update = $db->query("update university set fountain_scholar = ? where name = ?;", $grade, "Fountain University Osogbo", "update");
		if($update){
 			$error_messages = FlashMessages::getInstance();
			$type = "notify";
			$key = "scholar";
			$success_message  =  "Grade updated successfully <br />";
 			$success_message.= "<a href = \"superuser_homepage.php\">Go back</a>";
			$error_messages->setMessages($success_message, $type, $key);
		}
	}
	else{
		$error_messages = FlashMessages::getInstance();
		$type = "error";
		$key = "scholar";
		$error_messages->setMessages($error_array, $type, $key);
	}
	
	
}
?>
<?php 
$error_message = FlashMessages::getInstance();
$key = "scholar";
$error_message->displayMessage("scholar");
$error_message->unsetMessage("scholar");

?>
</td>
 </tr>
 </table>
</div>
</body>
</html>


