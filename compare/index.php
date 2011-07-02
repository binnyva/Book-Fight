<?php
require('../common.php');
$user_string = $sql->escape($_GET['users']);
$usernames = explode('/', trim($user_string, '/\\ '));

$list_id = 1;
$list_details = $list->get_list($list_id);
$items = $item->get_books_in_list($list_id);
$users = array();

for($i=0;$i<count($usernames);$i++) {
	$user_string = $usernames[$i];
	if(!$user_string) continue;
	$users[$i] = array();
	$users[$i]['details'] = $user->get_by_username($user_string);

	if(!$users[$i]) {
		render('reader/no_such_user.php');
		exit;
	}
	$users[$i]['read'] = array_keys($item->get_user_read_books_in_list($users[$i]['details']['id'], $list_id));
}

$template->addResource('index.js');
$template->addResource('index.css');

// 2 Users
if(count($usernames) == 2) {
	$user_0_only= array_diff($users[0]['read'], $users[1]['read']);
	$user_1_only= array_diff($users[1]['read'], $users[0]['read']);
	$both_read	= array_intersect($users[0]['read'], $users[1]['read']);
	
	render('compare/two_users.php');

} else {
	render('compare/many_users.php');
}
