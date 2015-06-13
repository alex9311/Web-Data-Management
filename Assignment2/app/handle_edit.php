<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$title = $_POST["title"];
	$type = $_POST["type"];
	$year = $_POST["year"];
	$publisher = $_POST["publisher"];
	$source = $_POST["source"];
	$id = $_POST["id"];
	$rev = $_POST["rev"];
	$author = explode(", ",$_POST["author"]);
	$ch = curl_init();
 
	$customer = array(
		'title' => $title,
		'type' => $type,
		'year' => $year,
		'publisher' => $publisher,
		'source' => $source,
		'authors' => $author,
	);
	 
	$customer['_rev'] = $rev;
 
	$payload = json_encode($customer);
 
	curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:5984/books/'.$id);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); /* or PUT */
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-type: application/json',
		'Accept: */*'
	));
 
	curl_setopt($ch, CURLOPT_USERPWD, 'admin:admin');
 
	$response = curl_exec($ch);
 
	curl_close($ch); 
	header("Location: index.php");
	die();
}

?>
