<?php
require_once(joinPath($config['site_folder'] , 'models/User.php'));
$user = new User;

function checkUser() {
	global $config;
	
	if((!isset($_SESSION['user_id']) or !$_SESSION['user_id']))
		showMessage("Please login to use this feature", $config['site_url'] . 'user/login.php', "error");
}

if( $config['current_page'] != '/user/login.php' and 
	$config['current_page'] != '/user/signup.php' and
	$config['current_page'] != '/user/forgot_password.php') {
		checkUser();
}

$list_id = 1;
$top_users = $sql->getAll("SELECT COUNT(UserItem.id) as read_count, User.name, User.username 
									FROM User INNER JOIN `UserItem` ON User.id=UserItem.user_id
									WHERE UserItem.status='1'
									GROUP BY UserItem.user_id ORDER BY read_count DESC LIMIT 0,10");

