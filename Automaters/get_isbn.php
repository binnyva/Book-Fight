<?php
/// Finds the ISBN and image for all the books without it.
include('../common.php');

function getISBN_isbntools($title) {
	$title = preg_replace('/^The /','', $title);
	$url = 'http://my.linkbaton.com/isbn/search?SWhat=title&submit=submit&B=&SType=E5&find=' . urlencode(strtolower($title));
	$contents = load($url, array('cache'=>false));
	
	if(preg_match('/<small>ISBN([^<]+)<\/small>/', $contents, $matches)) {
		return $matches[1];
	}
	
	return '';
}

function getISBN_isbndb($title) {
	$key = 'I48G8RWR';
	$url = 'http://isbndb.com/api/books.xml?access_key='.$key.'&index1=title&value1=' . urlencode($title);
	$contents = load($url,array('cache'=>true));
	$data = xml2array($contents, 1, 'attribute');
	$all_books = $data['ISBNdb']['BookList']['BookData'];
	$first_book = '';
	
	foreach($all_books as $book) {
		if(empty($book['Title'])) continue;
		
		if(strtolower($book['Title']['value']) == strtolower($title)) {
			return $book['attr']['isbn'];
		}
		
		if(!$first_book) $first_book = $book['attr']['isbn'];
	}
	
	// We didn't get an exact title match. So, return the first result.
	return $first_book;
}

$all_books = $sql->getAll("SELECT id,name,url FROM Item WHERE image=''");
$key = 'I48G8RWR';
foreach($all_books as $book) {
	print "Processing $book[name] ... ";
	$isbn = getISBN_isbntools($book['name']);
	print "$isbn ... ";
	
	if($isbn) {
		$image_url = "http://covers.librarything.com/devkey/$key/large/isbn/$isbn";
		$image_file_path = '/var/www/html/Projects/BookFight/covers/';
		$big_image_file_path = joinPath($image_file_path, 'big', $book['url'].'.jpg');
		$small_image_file_path = joinPath($image_file_path, 'small', $book['url'].'.jpg');
		$update = array('isbn'=>$isbn);
		
		$image_contents = load($image_url);
		if(strlen($image_contents) > 100) { // To make sure its a valid image.
			print "Got Cover ... ";
			file_put_contents($big_image_file_path, $image_contents);
			$img = new Image($big_image_file_path);
			$img->resize(0, 40, false)->save($small_image_file_path);
			print "Got Thumbnail ... ";
			$update['image'] = str_replace('/var/www/html/Projects/BookFight/', '', $big_image_file_path);
		}
		$sql->update('Item',$update, "id=$book[id]");
	}
	print "Done\n";
}
