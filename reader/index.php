<?php
require('../common.php');

$user = $sql->escape($_GET['user']);
$user_details = $sql->getAssoc("SELECT id,name,url,display_picture,bio FROM User WHERE username LIKE '$user'");

if(!$user_details) {
	render('reader/no_such_user.php');
	exit;
}

$list_id = 1;
$list_details = $sql->getAssoc("SELECT name, description FROM List WHERE id=$list_id");

$items = $sql->getAll("SELECT Item.id,Item.name,Item.author 
	FROM Item INNER JOIN ListItem ON ListItem.item_id=Item.id 
	WHERE ListItem.list_id=$list_id ORDER BY ListItem.sort_order");
	
$user_read = $sql->getById("SELECT UserItem.item_id, UserItem.status, UserItem.rating
	FROM ListItem INNER JOIN UserItem ON ListItem.item_id=UserItem.item_id 
	WHERE ListItem.list_id=$list_id AND UserItem.user_id={$user_details['id']} AND status='1'");


$template->addResource('tabby.css');
$template->addResource('index.css');
$template->addResource('index.js');
render();
