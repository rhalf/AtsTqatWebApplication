<?php
include ("conf.php");

try {
	$Conn = new PDO(
	        "$engine:host=$dbhost;dbname=$prefix$dbname", "$dbuser", "$dbpass", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
	); 
} catch (PDOExcemption $cExcemption) {
	echo ($cExcemption);
}

?>