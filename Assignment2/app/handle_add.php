<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
	$ch = curl_init();
 
	$movie = array(
		'title' => $_POST["title"],
		'genre' => $_POST["genre"],
		'year' => $_POST["year"],
		'summary' => $_POST["summary"]
	);
 
	$payload = json_encode($movie);

	$new_id = get_uuid();
 
	curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:5984/movies/'.$new_id);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-type: application/json',
		'Accept: */*'
	));
 
	curl_setopt($ch, CURLOPT_USERPWD, 'admin:admin');
 
	$response = curl_exec($ch);
	print($response);
 
	curl_close($ch);
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
	return $UUID; 
}

?>
