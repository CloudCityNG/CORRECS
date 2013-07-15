<?php
session_start();
require_once("includes/initialize.php");

var_dump($_SESSION['username']);

if(is_logged_in()){
	logout();
	Header("Location: index.php");
}
else{

}

?>