<?php

//http://127.0.0.1:5984/savings/_design/players/_view/average?startkey=["Yankees","male",0]&endkey=["Yankees","male",{}]


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Get cURL resource

	$key_string =  build_key_string($_POST);
	print($key_string);

	$curl = curl_init();
	// Set some options - we are passing in a useragent too here
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
    		CURLOPT_URL => 'http://127.0.0.1:5984/movies/_design/app/_view/all_keys?'.$key_string
	));
	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	echo '<a href="search_form.php">new search</a>';
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
	echo "<br>";
	$data =  json_decode($json);
	$movies = $data -> rows;
	echo '<table cellpadding="10"  border="1">
           <tr>
                <td><strong>Title</strong></td>
                <td><strong>Year</strong></td>
                <td><strong>Genre</strong></td>
                <td><strong>Country</strong></td>
                <td><strong>Director</strong></td>
                <td><strong>Actors</strong></td>
                <td><strong>Summary</strong></td>
            </tr>';
	foreach($movies as $movie){
		$actors = [];
		foreach($movie->value->actors as $actor){
			array_push($actors,$actor->first_name." ".$actor->last_name);
		}
		echo "<tr>";	
		echo "<td>".$movie->value->title."</td>";
		echo "<td>".$movie->value->year."</td>";
		echo "<td>".$movie->value->genre."</td>";
		echo "<td>".$movie->value->country."</td>";
		echo "<td>".$movie->value->director->first_name." ".$movie->value->director->last_name."</td>";
		echo "<td>".implode(", ",$actors)."</td>";
		echo "<td>".$movie->value->summary."</td>";
		echo "</tr>";	
	}
	echo "</table>";
}

?>
