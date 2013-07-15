<?php session_start(); 
 require_once("includes/initialize.php");
if(!is_logged_in()){
	Header("Location: index.php");
	
}
else{

	$this_student = initStudent();
	$db = DatabaseWrapper::getInstance();
	define("PICTURE_DIRECTORY", "Pictures");
	define("MAX_FILE_SIZE", 2000000);
}
?>

<html>
<head>
<title> Change Picture</title>
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
<h5>&nbsp;</h5></p>
</td><td align="right"><h3><a href="logout.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp; </h3></td></tr>
<tr><td id="navigation">
<ul>
<li>
<a href = "student_homepage.php"> Back to Homepage</a>
</li>
</ul>
</td>
<td id="page">
<h2><?php echo $this_student->fullName()?></h2>
<form action = "<?php echo $_SERVER["PHP_SELF"] ?> " method = "post" enctype = "multipart/form-data">
 <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
<div class = "divtable">
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
<font size = -5>The maximum size for Pictures uploadable is 2MB.</font>
<input type = "submit" name =  "submit" value = "Change Picture"></input>
</div>
</div>
</div>
</form>

<?php 
if(isset($_POST["submit"])){
	$photograph = $_FILES['photograph']['tmp_name'];
	$uploaded_photograph;
	$error_array = array();
	if(is_uploaded_file($photograph)){
		$target_file = basename($_FILES['photograph']['name']);
		$type = $_FILES['photograph']['type'];
		$size = $_FILES['photograph']['size'];
		if($type != "image/jpg" && $type != "image/jpeg" && $type != "image/png"){
			$error_array[] = "You may only upload .jpeg or .png files";
		}
		
		if (empty($error_array)){
		$result = move_uploaded_file($photograph, PICTURE_DIRECTORY. "/".$target_file);
		
		if($result){
			$uploaded_photograph = PICTURE_DIRECTORY. "/".$target_file;
			$update = $db->query("update student_info set photograph = ? where id = ?;", $uploaded_photograph, $this_student->id, "update");
			if($update){
			$success_message =  "<font color = \"green\">Uploaded successfully</font> <br />";
			$success_message .= "<a href = \"student_homepage.php\">Go back to Home Page</a>";
			
			echo $success_message;
			}
			else{
				echo "Failed";
			}
		}
		
	}
	else{
		$error_messages = FlashMessages::getInstance();
		$type = "error";
		$key = "picture";
		$error_messages->setMessages($error_array, $type, $key);
		$error_messages->displayMessage("picture");
		$error_messages->unsetMessage("picture");
	}
}
	else{
		$error= $_FILES['photograph']['error'];
		$error_array = $upload_errors[$error]; 
		$error_messages = FlashMessages::getInstance();
		$type = "error";
		$key = "picture";
		$error_messages->setMessages($error_array, $type, $key);
		$error_messages->displayMessage("picture");
		$error_messages->unsetMessage("picture");
		
		
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