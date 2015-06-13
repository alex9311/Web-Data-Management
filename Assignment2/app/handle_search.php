<script type="text/javascript" src="createBibtex.js"></script>
<?php

function show_search_results($search_terms) {

	$view_keys = get_view_and_keys($search_terms);
	$view = $view_keys[0];
	$keys = $view_keys[1];

	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => 'http://127.0.0.1:5984/books/_design/app/_view/'.$view.'?key='.$keys.''
	));
	
	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	json_to_html_table($resp);
	// Close request to clear up some resources
	curl_close($curl);

}

function json_to_html_table($json){
	echo "<br>";
	$data =  json_decode($json);
	$json_books = $data -> rows;
	
	//removes duplicate results
	$books=[];
	foreach($json_books as $book){
		$books[$book->id] = $book->value;
	}

	print_table_headers();
	foreach($books as $id=>$book){
		$attachment_list = get_attachment_list($book);
		$authors = get_author_array($book);

		echo "<tr>";	
		$book_safe_json = str_replace('"',"'",json_encode($book));
		echo '<td><a onclick="return createBibtex('.$book_safe_json.');" href="javascript:void(0)">'.$book->title."</a></td>";
		echo "<td>".implode(", ",$authors)."</td>";
		echo "<td>".$book->year."</td>";
		echo "<td>".$book->source."</td>";
		echo "<td>".$attachment_list."</td>";
		echo "<td><a href=edit_form.php?id=".$id.">edit</a></td>";
		echo "<td><a href=handle_delete.php?id=".$id.">delete</a></td>";
		echo "<td><a href=http://127.0.0.1:5984/books_app/handle_upload/handle_upload.html?doc_id=".urlencode($id)."&doc_rev=".urlencode($book->_rev).' target="_blank">add PDF</a></td>';
		echo "</tr>";	
	}
	echo "</table>";
}

function print_table_headers(){
	echo '<table class="results_table" cellpadding="10"  border="1">
       <tr>
            <td><strong>Title</strong></td>
            <td><strong>Author(s)</strong></td>
            <td><strong>Year</strong></td>
            <td><strong>Source</strong></td>
            <td><strong>View PDF</strong></td>
            <td><strong>Edit</strong></td>
            <td><strong>Delete</strong></td>
            <td><strong>Add PDF</strong></td>
        </tr>';
}

function get_attachment_list($book){
	$attachments = ($book->_attachments);
		$attachment_list = "";
		foreach ($attachments as $key => $value) {
			$link = '<a href="http://127.0.0.1:5984/books/'.$book->_id.'/'.$key.'" target="_blank">'.$key.'</a>';
			$attachment_list .= $link;
		}
	return $attachment_list;
}

function get_author_array($book){
	$authors = [];
	foreach($book->authors as $author){
		array_push($authors,$author);
	}
	return $authors;
}

function get_view_and_keys($search_terms){
	$title = strtolower($search_terms["title"]);
	$author = strtolower($search_terms["author"]);
	$year = $search_terms["year"];
	$publisher = strtolower($search_terms["publisher"]);

	if($title!="" && $author=="" && $year=="" && $publisher=="") {
		$view = "title";
		$keys = '"'.$title.'"';
	}
	if($title=="" && $author!="" && $year=="" && $publisher=="") {
		$view = "author";
		$keys = '"'.$author.'"';
	}
	if($title=="" && $author=="" && $year!="" && $publisher=="") {
		$view = "year";
		$keys = '"'.$year.'"';
	}
	if($title=="" && $author=="" && $year=="" && $publisher!="") {
		$view = "publisher";
		$keys = '"'.$publisher.'"';
	}
	if($title!="" && $author=="" && $year!="" && $publisher=="") {
		$view = "title_year";
		$keys = '["'.$title.'","'.$year.'"]';
	}
	if($title=="" && $author!="" && $year!="" && $publisher=="") {
		$view = "author_year";
		$keys = '["'.$author.'","'.$year.'"]';
	}
	if($title=="" && $author=="" && $year!="" && $publisher!="") {
		$view = "publisher_year";
		$keys = '["'.$publisher.'","'.$year.'"]';
	}
	if($title!="" && $author!="" && $year=="" && $publisher=="") {
		$view = "title_author";
		$keys = '["'.$title.'","'.$author.'"]';
	}
	if($title!="" && $author=="" && $year=="" && $publisher!="") {
		$view = "title_publisher";
		$keys = '["'.$title.'","'.$publisher.'"]';
	}
	if($title=="" && $author!="" && $year=="" && $publisher!="") {
		$view = "publisher_author";
		$keys = '["'.$publisher.'","'.$author.'"]';
	}
	if($title=="" && $author!="" && $year!="" && $publisher!="") {
		$view = "publisher_author_year";
		$keys = '["'.$publisher.'","'.$author.'","'.$year.'"]';
	}
	if($title!="" && $author=="" && $year!="" && $publisher!="") {
		$view = "title_publisher_year";
		$keys = '["'.$title.'","'.$publisher.'","'.$year.'"]';
	}
	if($title!="" && $author!="" && $year!="" && $publisher=="") {
		$view = "title_author_year";
		$keys = '["'.$title.'","'.$author.'","'.$year.'"]';
	}
	if($title!="" && $author!="" && $year=="" && $publisher!="") {
		$view = "title_publisher_author";
		$keys = '["'.$title.'","'.$publisher.'","'.$author.'"]';
	}
	if($title!="" && $author!="" && $year!="" && $publisher!="") {
		$view = "title_publisher_author_year";
		$keys = '["'.$title.'","'.$publisher.'","'.$author.'","'.$year.'"]';
	}
	return array($view,$keys);
}

?>
