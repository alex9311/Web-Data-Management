<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
<head>
<?php include "handle_search.php";?>
<link rel="stylesheet" type="text/css" href="style_bib.css"/>
</head>
<body>
	<?php
	$title=""; $author=""; $publisher="";$year="";
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$title = $_POST["title"];
		$author = $_POST["author"];
		$publisher = $_POST["publisher"];
		$year = $_POST["year"];
	}
	?>
	<h2 style="text-align:center">Filter Changelog</h2>
	<div class="input_form">
		<form action="changelog.php" method="post">
			<fieldset>
			<div class="input_column_left" >
				Tile: <input type="text" name="title" value="<?php echo $title; ?>"/>
				Author:	<input type="text" name="author" value="<?php echo $author; ?>"/>
			</div>
			<div class="input_column_right" >
				Journal or Publisher: 		<input type="text" name="publisher" value="<?php echo $publisher; ?>"/>
				Year: 	<input type="text" name="year" value="<?php echo $year ?>"/>
			</div>
			<input type="submit"/>
			</fieldset>
		</form>
	</div>
	<br>
	<h2 style="text-align:center;">Changelog</h2>
	<?php 
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$view_keys = get_view_and_keys($_POST);
		$view = $view_keys[0];
		$keys = $view_keys[1];
		if($view==""){
			show_changelog();
		} else {
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'http://127.0.0.1:5984/books/_design/app/_view/'.$view.'?key='.$keys.''
			));
	
			// Send the request & save response to $resp
			$resp = curl_exec($curl);

			$data =  json_decode($resp);
			$json_books = $data -> rows;
		
			//removes duplicate results
			$books=[];
			foreach($json_books as $book){
				$books[$book->id] = $book->value;
			}
			show_changelog_filtered(array_keys($books));
		}
	}else{
		show_changelog();
	}

	?>
	<a href="index.php">Back to App home</a>
	<br>
</body>
</html>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="createBibtex.js"></script>
<?php

function show_changelog_filtered($ids) {

	//print_r(json_encode($ids));
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => 'http://127.0.0.1:5984/books/_changes?descending=true&filter=app/ids&ids='.json_encode($ids)
	));
	
	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	// Close request to clear up some resources
	curl_close($curl);
	$num_results = (count(json_decode($resp)->results));
	if($num_results>10){
		$num_results = 10;
	}
	json_to_html_table_change($resp,$num_results);
}

function show_changelog() {

	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => 'http://127.0.0.1:5984/books/_changes?descending=true'
	));
	
	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	// Close request to clear up some resources
	curl_close($curl);
	json_to_html_table_change($resp,10);

}

function json_to_html_table_change($json,$table_length){
	$data =  json_decode($json);
	$json_books = $data -> results;


	print_table_headers();
	for ($i = 0; $i <= $table_length-1; $i++) {
		$id = $json_books[$i]->id;
		$book = get_document_by_id($id);

		$attachment_list = get_attachment_list($book);
		$authors = get_author_array($book);

		echo "<tr>";	
		$book_safe_json = str_replace('"',"'",json_encode($book));
		echo '<td><a onclick="return createBibtex('.$book_safe_json.');" href="javascript:void(0)">'.$book->title."</a></td>";
		echo "<td>".implode(", ",$authors)."</td>";
		echo "<td>".$book->year."</td>";
		echo "<td>".$book->source."</td>";
		echo "<td>".$attachment_list."</td>";
		echo '<td align="center"><a href="edit_form.php?id='.$id.'"><img src="icons/edit.png"></a></td>';
		echo '<td align="center"><a href=handle_delete.php?id='.$id.'><img src="icons/delete.png"></a></td>';
		echo '<td align="center"><a href=http://127.0.0.1:5984/books_app/handle_upload/handle_upload.html?doc_id='.urlencode($id)."&doc_rev=".urlencode($book->_rev).' target="_blank"><img src="icons/pdf.png"></a></td>';
		echo "</tr>";	
	} 
	echo "</table>";
}


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
	return json_decode($response);
}

?>
