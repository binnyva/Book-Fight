<?php
/// Finds the ISBN and image for all the books without it.
include('../common.php');

include('Amazon.php');
$amazon = new Amazon();

function getAsin($title) {
	global $amazon;
	
	$parameters=array(
		"region"=>"com",
		"Operation"=>"ItemSearch", // we will be searching
		"SearchIndex"=>"Books", // in the books category
		'ResponseGroup'=>'Images',// we want images
		"Keywords"=>$title // this is what we are looking for, you could use the book's title instead
	);
	
	$queryUrl = $amazon->getSignedUrl($parameters);
	
	$contents = load($queryUrl);
	$response = xml2array($contents);

	if(isset($response['ItemSearchResponse']['Items']['Item'][0])) {
		$first_book = $response['ItemSearchResponse']['Items']['Item'][0];
		
		return array(
			'asin'	=> $first_book['ASIN'],
			'cover'	=> $first_book['LargeImage']['URL']
		);
	}
	
	return '';
}


$all_books = $sql->getAll("SELECT id,name,url FROM Item");
$i = 1;
$total = count($all_books);

foreach($all_books as $book) {
	print "$i/$total) Processing $book[name] ... ";
	$info = getAsin($book['name']);
	$asin = $info['asin'];
	print "$asin ... ";
	
	if($info) {
		$image_url = $info['cover'];
		$image_file_path = '/var/www/html/Projects/BookFight/covers/';
		$big_image_file_path = joinPath($image_file_path, 'big', $book['url'].'.jpg');
		$small_image_file_path = joinPath($image_file_path, 'small', $book['url'].'.jpg');
		$update = array('asin'=>$asin);
		
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
	$i++;
}
