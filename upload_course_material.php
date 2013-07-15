<?php
session_start();
require_once("includes/initialize.php");
if(!is_logged_in() || (!isset($_GET["id"])) || (!isset($_GET["dept"]))){
	Header("Location: index.php");
}
else{
	$db = DatabaseWrapper::getInstance();
	$course = $db->query("select * from courses where code = '{$_GET["id"]}' and departmentId = '{$_GET["dept"]}';", "select");
	//var_dump($course);
	$this_lecturer = initLecturer();
	define("FILE_DIRECTORY", "course_material");
}
?>

<html>
<head><title>Edit Course Code</title>
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
<li><a href="department_admin_page.php?department=<?php echo $this_lecturer->deptId ?>">Back to Admin Dashboard</a>
</li></ul>
</td>
<td id="page">
 <?php 
$error_message = FlashMessages::getInstance();
$key = "course";
$error_message->displayMessage("course");
$error_message->unsetMessage("course");
 
?>
<center><h2>Upload  <?php echo $course[0]["name"]?></h2></center>
<form action = "<?php echo "{$_SERVER["PHP_SELF"]}?id={$_GET["id"]}&dept={$_GET["dept"]}" ?> " method = "post" enctype = "multipart/form-data">
 <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
<div class = "divtable">
<div class="divrow">
 <div class="divcell">
 Upload File:
 </div>
 <div class="divcell">
 <input type = "file" name="file" value=""></input>
 </div>

 </div>
<div class = "divrow">
<div class = "divcell">
<font size = -5>The maximum size for Files uploadable is 2MB.</font>
<input type = "submit" name =  "submit" value = "Upload Material"></input>
</div>
</div>
</div>
</form>

<?php 
if(isset($_POST["submit"])){
	$file = $_FILES['file']['tmp_name'];
	$uploaded_file;
	$error_array = array();
	if(is_uploaded_file($file)){
		$target_file = basename($_FILES['file']['name']);
		$type = $_FILES['file']['type'];
		$size = $_FILES['file']['size'];
		if($type != "application/pdf" && $type != "application/ppt" && $type != "application/vnd.ms-powerpoint" && $type != "application/vnd.openxmlformats-officedocument.wordprocessingml.document" && $type != "application/msword" && $type != "application/docx"){
			//$error_array[] = $type;
			$error_array[] = "You may only upload pdf or word documents and powerpoint slides";
		}
		
		if (empty($error_array)){
		$result = move_uploaded_file($file, FILE_DIRECTORY. "/".$target_file);
		
		if($result){
			$uploaded_file = FILE_DIRECTORY. "/".$target_file;
			$next = $db->query("select (max(id) + 1) from course_materials;", "select");
			$session = $db->query("select currentSession from university where name = 'Fountain University Osogbo';", "select");
			$update = $db->query("insert into course_materials values(?,?,?,?,?);", $next[0][0], $_GET["id"], $type, $uploaded_file, $session[0][0], "insert");
			if ($update){
			$success_message =  "<font color = \"green\">Uploaded successfully</font> <br />";
			$success_message .= "<a href = \"lecturer_homepage.php\">Go back to Home Page</a>";
			
			echo $success_message;
			}
			else{
				echo "Failed";
			}
		}
		}
		else {
			$error_messages = FlashMessages::getInstance();
			$type = "error";
			$key = "file";
			$error_messages->setMessages($error_array, $type, $key);
			$error_messages->displayMessage("file");
			$error_messages->unsetMessage("file");
		}
		
	}

	else{
		$error= $_FILES['file']['error'];
		$error_array = $upload_errors[$error]; 
		$error_messages = FlashMessages::getInstance();
		$type = "error";
		$key = "file";
		$error_messages->setMessages($error_array, $type, $key);
		$error_messages->displayMessage("file");
		$error_messages->unsetMessage("file");
		
		
	}
	
	
}
?>


</td>
</tr>
</table>
</div>
</body>
</html>