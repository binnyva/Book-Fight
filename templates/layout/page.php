<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html><head>
<title><?php echo $title?></title>
<link href="<?php echo $abs?>css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $abs?>images/silk_theme.css" rel="stylesheet" type="text/css" />
<?php echo $css_includes?>
</head>
<body>
<div id="loading">loading...</div>
<div id="header">
<div id="user-info">
<?php if(!empty($_SESSION['user_id'])) {
	echo '<a href="'.$config['site_url'].'user/profile.php">' . $_SESSION['user_name'] . '</a> | ';
	echo '<a href="'.$config['site_url'].'user/logout.php">Logout</a>';
} else { ?>
<a href="<?php echo $config['site_url'] ?>user/login.php">Login</a> | 
<a href="<?php echo $config['site_url'] ?>user/signup.php">Signup</a>
<?php } ?>
</div>

<h1 id="logo"><a href="<?php echo $abs ?>"><?php echo $title ?></a></h1>
</div>

<div id="content">
<div id="error-message" <?php echo ($QUERY['error']) ? '':'style="display:none;"';?>><?php
	if(isset($PARAM['error'])) print strip_tags($PARAM['error']); //It comes from the URL
	else print $QUERY['error']; //Its set in the code(validation error or something.
?></div>
<div id="success-message" <?=($QUERY['success']) ? '':'style="display:none;"';?>><?php echo strip_tags(stripslashes($QUERY['success']))?></div>

<!-- Begin Content -->
<?php 
/////////////////////////////////// The Template file will appear here ////////////////////////////

include($GLOBALS['template']->template); 

/////////////////////////////////// The Template file will appear here ////////////////////////////
?>
<!-- End Content -->
</div>
<div id="sidebar">
<?php if(!empty($_SESSION['user_id'])) { ?>
<h3>Top Readers</h3>
<ul>
<?php foreach($top_users as $user) { ?>
<li><a href="<?php echo $config['site_url'] ?>reader/<?php echo $user['username'] ?>"><?php echo "$user[name]($user[read_count])"; ?></a></li>
<?php } ?>
</ul>
<?php } ?>
</div>
<br />
<div id="footer"></div>

<script src="<?=$abs?>js/library/jquery.min.js" type="text/javascript"></script>
<script src="<?=$abs?>js/application.js" type="text/javascript"></script>
<?=$js_includes?>
</body>
</html>