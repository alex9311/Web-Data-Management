<?php

//http://127.0.0.1:5984/savings/_design/players/_view/average?startkey=["Yankees","male",0]&endkey=["Yankees","male",{}]


//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
function show_search_results($search_terms) {
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
		$view = "title_actor";
		$keys = '["'.$title.'","'.$author.'"]';
	}
	if($title!="" && $author=="" && $year=="" && $publisher!="") {
		$view = "title_publisher";
		$keys = '["'.$title.'","'.$publisher.'"]';
	}

	$curl = curl_init();

	echo 'http://127.0.0.1:5984/books/_design/app/_view/'.$view.'?key='.$keys.'';
	
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

function build_key_string($post_array){
	$title = $post_array["title"];
	$year = $post_array["year"];	

	$title_start = "a";
	$title_end = "z";

	$year_start = 0;
	$year_end = "{}";
	
	if(strcmp($title,"")!=0){
		$title_start = $title;
		$title_end = $title;
	}	
	if(strcmp($year,"")!=0){
		$year_start = $year;
		$year_end = $year;
	}
	$key_string = 'startkey=["'.$title_start.'",'.$year_start.']&endkey=["'.$title_end.'",'.$year_end.']';

	return $key_string;
}

function json_to_html_table($json){
	echo "<br>";
	$data =  json_decode($json);
	$books = $data -> rows;
	echo '<table class="results_table" cellpadding="10"  border="1">
           <tr>
                <td><strong>Type</strong></td>
                <td><strong>Title</strong></td>
                <td><strong>Author(s)</strong></td>
                <td><strong>Year</strong></td>
                <td><strong>Publisher or Journal</strong></td>
                <td><strong>Source</strong></td>
                <td><strong>Edit</strong></td>
                <td><strong>Delete</strong></td>
            </tr>';
	foreach($books as $book){
		$authors = [];
		foreach($book->value->authors as $author){
			array_push($authors,$author);
		}
		echo "<tr>";	
		echo "<td>".$book->value->type."</td>";
		echo "<td>".$book->value->title."</td>";
		echo "<td>".implode(", ",$authors)."</td>";
		echo "<td>".$book->value->year."</td>";
		echo "<td>".$book->value->publisher."</td>";
		echo "<td>".$book->value->source."</td>";
		echo "<td><a href=edit_form.php?id=".$book->id.">edit</a></td>";
		echo "<td><a href=handle_delete.php?id=".$book->id.">delete</a></td>";
		echo "</tr>";	
	}
	echo "</table>";
}

?>
