<?php
include '../db_connect.php';
$qry = $conn->query("SELECT * FROM contents where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	if($k=='title')
		$k = "ctitle";
	$$k = $v;
}
include 'new_content.php';
?>