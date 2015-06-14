<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
<head>
<link rel="stylesheet" type="text/css" href="style_bib.css"/>
</head>
<body>
	<?php
		if ($_GET["id"]==""){
			print ("no book selected to edit");
			exit();
		}
		$book = get_document_by_id($_GET["id"]);
	?>
	<h2 style="text-align:center;">Edit Entry in DB</h2>
	<div class="input_form">
		<form action="handle_edit.php" method="post">
			<fieldset>
			Type: 	<input type="text" name="type" 		value="<?php print($book["type"]);?>"/>
			Tile: 	<input type="text" name="title" 	value="<?php print($book["title"]);?>"/>
			Author: <input type="text" name="author"	value="<?php print(implode(", ",$book["authors"]));?>"/>
			Publisher or Journal: <input type="text" name="publisher" value="<?php print($book["publisher"]);?>"/>
			Year: 	<input type="text" name="year" 		value="<?php print($book["year"]);?>"/>
			Source: <input type="text" name="source" 	value="<?php print($book["source"]);?>"/>
			<input type="hidden" name="id" value="<?php print($book["_id"]);?>">
			<input type="hidden" name="rev" value="<?php print($book["_rev"]);?>">
			<input type="submit"/>
			</fieldset>
		</form>
	</div>
	<a href="index.php">Back to App home</a>
	<br>
</body>
</html>

<?php 

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
