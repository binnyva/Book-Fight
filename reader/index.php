<?php
require('../common.php');

$user_string = $sql->escape($_GET['user']);
$user_details = $sql->getAssoc("SELECT id,name,url,display_picture,bio FROM User WHERE username LIKE '$user_string'");

if(!$user_details) {
	render('reader/no_such_user.php');
	exit;
}

$list_id = 1;
$list_details = $list->get_list($list_id);
$items = $item->get_books_in_list($list_id);
$user_read = $item->get_user_read_books_in_list($user_details['id'], $list_id);

$template->addResource('tabby.css');
$template->addResource('reader/index.css');
render('index.php');
