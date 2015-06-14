<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
<head>
<?php include "handle_search.php";?>
<link rel="stylesheet" type="text/css" href="style_bib.css"/>
</head>
<body>
	<h2 style="text-align:center;">Changelog</h2>
	<?php show_changelog();?>
	<a href="index.php">Back to App home</a>
	<br>
</body>
</html>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="createBibtex.js"></script>
<?php

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
	json_to_html_table_change($resp);

}

function json_to_html_table_change($json){
	echo "<br>";
	$data =  json_decode($json);
	$json_books = $data -> results;

	print_table_headers();
	for ($i = 0; $i <= 10; $i++) {
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