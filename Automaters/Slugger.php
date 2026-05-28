<?php
/// Creates a slug for all books without an URL Slug
include('../common.php');

$all_books = $sql->getAll("SELECT id,name FROM Item WHERE url=''");
foreach($all_books as $book) {
	$slug = unformat($book['name']);
	
	$sql->update('Item', array('url'=>$slug), "id=$book[id]");
}
