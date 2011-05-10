<?php
require("./common.php");

$list_id = 1;

$list_details = $sql->getAssoc("SELECT name, description FROM List WHERE id=$list_id");

$items = $sql->getAll("SELECT Item.id,Item.name,Item.author 
	FROM Item INNER JOIN ListItem ON ListItem.item_id=Item.id 
	WHERE ListItem.list_id=$list_id ORDER BY ListItem.sort_order");
	
$user_read = $sql->getById("SELECT UserItem.item_id, UserItem.status, UserItem.rating
	FROM ListItem INNER JOIN UserItem ON ListItem.item_id=UserItem.item_id 
	WHERE ListItem.list_id=$list_id AND user_id={$_SESSION['user_id']} AND status='1'");


$template->addResource('tabby.css');
render();
