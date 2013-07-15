<?php session_start(); 
 require_once("includes/initialize.php");
if(!is_logged_in()){
	Header("Location: index.php");
	
}
else{

	$this_student = initStudent();
}
?>

<html>
<head>
<title> Change Password</title>
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
<a href = "student_homepage.php"> Back to Homepage</a>
</li>
</ul>
</td>
<td id="page">
<h2><?php echo $this_student->fullName()?></h2>
<form action = "<?php echo $_SERVER["PHP_SELF"] ?> " method = "post">
<div class = "divtable">
<div class = "divrow">
<div class = "divcell">
Old Password: 
</div>
<div class = "divcell">
<input type = "password" name = "old_password" id = "old_password"></input>
</div>
</div>
<div class = "divrow">
<div class = "divcell">
New password: 
</div>
<div class = "divcell">
<input type = "password" name = "password" id = "password"></input>
</div>
</div>

<div class = "divrow">
<div class = "divcell">
Confirm Password:
</div>
<div class = "divcell">
<input type = "password" name = "confirm_password" id = "confirm_password"></input>
</div>
</div>
<div class = "divrow">
<div class = "divcell">
<input type = "submit" name =  "submit" value = "Change Password"></input>
</div>
</div>
</div>
</form>

<?php 
if(isset($_POST["submit"])){
	$old_password = $_POST["old_password"];
	$password = $_POST["password"];
	$confirm_password = $_POST["confirm_password"];
	$error_array = array();
	$db = DatabaseWrapper::getInstance(); 
	$check = $db->query("select password from login where loginId = '{$this_student->loginId}';", "select");
	
	$encrypted_password = md5($password);
	
	if(empty($password) || empty ($confirm_password) || empty($old_password)){
		$error_array[] = "Please input the password in both fields";
	}
	if(!empty($check)){
		if($check[0]["password"] != md5($old_password))
			$error_array[] =  "Wrong old password";
	}
	elseif($password != $confirm_password){
		$error_array[] = "Please input the same password in both fields";
	}
	
	if(empty($error_array)){
		$query = $db->query("update login set password = ? where loginId = ? ;", $encrypted_password, $this_student->loginId, "update");
		if($query){
			echo "Password has been changed successfully<br>";
			echo "<a href = \"student_homepage.php\">Go Home</a>";
		}
		
	}
	
	else{
	
	$error_messages = FlashMessages::getInstance();
	$type = "error";
	$key = "password";
	$error_messages->setMessages($error_array, $type, $key);
	//header("Location: add_new_lecturer.php");
	}
	
}
?>

<?php 
 require_once("includes/initialize.php");
$error_message = FlashMessages::getInstance();
$key = "password";
$error_message->displayMessage("password");
$error_message->unsetMessage("password");
 ?>
 
 </td>
 </tr>
 </table>
</div> 
 </body>
</html>