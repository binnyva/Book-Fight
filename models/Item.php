<?php
class Item extends DBTable {
	function __construct() {
		parent::__construct("Item");
	}
	
	function get_books_in_list($list_id) {
		return $GLOBALS['sql']->getAll("SELECT Item.id,Item.name,Item.image,Item.asin,Item.url,Author.name AS author
					FROM Item INNER JOIN ListItem ON ListItem.item_id=Item.id 
					INNER JOIN Author ON Author.id=Item.author_id
					WHERE ListItem.list_id=$list_id ORDER BY ListItem.sort_order");
	}
	
	function get_user_read_books_in_list($user_id, $list_id) {
		return $GLOBALS['sql']->getById("SELECT UserItem.item_id, UserItem.status, UserItem.rating
					FROM ListItem INNER JOIN UserItem ON ListItem.item_id=UserItem.item_id 
					WHERE ListItem.list_id=$list_id AND user_id=$user_id AND status='1'");
	}
}
