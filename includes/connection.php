<?php
defined('DB_SERVER') ? null : define("DB_SERVER", "localhost");
defined('DB_USER')   ? null : define("DB_USER", "root");
defined('DB_PASS')   ? null : define("DB_PASS", "");
defined('DB_NAME')   ? null : define("DB_NAME", "final_project");

$connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
$select_db = mysql_select_db(DB_NAME, $connection);

?>