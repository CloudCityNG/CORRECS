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
<! DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<title>New Session</title>
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
<h3><a href="logout.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp; </h3></li><ul></td>
 <td id="page">
 
 <form method = "post" action = "<?php echo $_SERVER["PHP_SELF"] ?>" >
 <h2>Are You sure you want to begin a new Session?</h2>
 
 
 <input type = "submit" name = "begin" value = "Begin"></input>
 </form>
 <?php 
 if(isset($_POST["begin"])){
 	$new_session = $db->query("select (max(currentSession) + 1) from university where name = 'Fountain University Osogbo';", "select");
 	$update = $db->query("update university set currentSession = ? where name = ?;", $new_session[0][0], "Fountain University Osogbo", "update");
 	
 	if($update){
 		echo "You have begun a new session";
 	}
 	else{
 		echo "failed";
 	}
 }
 ?>
 </td>
 </tr>
 </table>
</div>
 </body>
 </html>