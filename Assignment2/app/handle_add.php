<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
	$ch = curl_init();
 
	$book = array(
		'type' => $_POST["type"],
		'title' => $_POST["title"],
		'publisher' => $_POST["publisher"],
		'source' => $_POST["source"],
		'year' => $_POST["year"],
		'authors' => explode(",",$_POST["authors"])
	);
 
	$payload = json_encode($book);

	$new_id = get_uuid();

 
	curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:5984/books/'.$new_id);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); 
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

function get_uuid(){
	$ch = curl_init();
 
	curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:5984/_uuids');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-type: application/json',
		'Accept: */*'
	));
 
	curl_setopt($ch, CURLOPT_USERPWD, 'admin:admin');
 
	$response = curl_exec($ch);
	$_response = json_decode($response, true);
 
	$UUID = $_response['uuids'];
	curl_close($ch);
	return $UUID[0]; 
}

?>
