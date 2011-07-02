<?php
require("../common.php");

if(empty($_GET['item_id']) or !is_numeric($_GET['item_id'])) showMessage("Item ID Missing/Incorrect", $config['site_url'] . 'index.php', 'error');

if(!isset($_GET['status'])) $status = 1;
else $status = ($_GET['status']) ? 1 : 0;
$statuses = array('Unread','Read');

$sql->execQuery("DELETE FROM UserItem WHERE user_id={$_SESSION['user_id']} AND item_id={$_GET['item_id']}");
if($status) {
	$result = $sql->execQuery("INSERT INTO UserItem(user_id,item_id,status,done_on) 
		VALUES('{$_SESSION['user_id']}', '{$_GET['item_id']}', '$status', NOW())");
}

if($result) {
	showMessage("Book marked as {$statuses[$status]} successfully");
} else {
	showMessage("Some error marking the book as {$statuses[$status]}", $config['site_url'] . 'index.php','error');
}
