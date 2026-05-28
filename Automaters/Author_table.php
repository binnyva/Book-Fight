<?php
require('iframe.php');

$sql = new Sql('Project_Bookfight');
$all_authors = array();

$books = $sql->getAll("SELECT id, author from Item");

foreach($books as $author) {
	print $author['author'] . "($author[id])\n";
	if(isset($all_authors[$author['author']])) {
		$sql->execQuery("UPDATE Item SET author_id=".$all_authors[$author['author']]." WHERE id=$author[id]");
	} else {
		$author_id = $sql->execQuery("INSERT INTO Author(name) VALUES('$author[author]')");
		$sql->execQuery("UPDATE Item SET author_id=$author_id WHERE id=$author[id]");
		$all_authors[$author['author']] = $author_id;
	}
}