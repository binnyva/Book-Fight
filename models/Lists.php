<?php
class Lists extends DBTable {
	function __construct() {
		parent::__construct("List");
	}
	
	function get_list($list_id) {
		return $GLOBALS['sql']->getAssoc("SELECT name, description FROM List WHERE id=$list_id");
	}
}

