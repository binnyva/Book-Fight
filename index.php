<?php
require("./common.php");

$list_id = 1;

$list_details = $list->get_list($list_id);
$items = $item->get_books_in_list($list_id);
$user_read = $item->get_user_read_books_in_list($_SESSION['user_id'], $list_id);

$template->addResource('tabby.css');
render('index.php');
