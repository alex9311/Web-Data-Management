<?php
	if ($_GET["id"]==""){
		print ("no book selected to delete");
		exit();
	}
	$book = get_document_by_id($_GET["id"]);
	print_r($book);


 
	$ch = curl_init();
 
	$database = 'books';
	$documentID = $_GET["id"];
	$revision = $book["_rev"];
 
	curl_setopt($ch, CURLOPT_URL, sprintf('http://127.0.0.1:5984/%s/%s?rev=%s', $database, $documentID, $revision));
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
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

	function get_document_by_id($id){
 
		$ch = curl_init();
 
		curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:5984/books/'.$id);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-type: application/json',
			'Accept: */*'
		));
	 
		curl_setopt($ch, CURLOPT_USERPWD, 'admin:admin');
	 
		$response = curl_exec($ch);
 
		curl_close($ch);
		return json_decode($response, true);
	}
?>
