<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$title = $_POST["title"];
	$genre = $_POST["genre"];
	$director = $_POST["director"];
	$actor = $_POST["actor"];
	$year = $_POST["year"];
	$keywords = $_POST["keywords"];
	
	echo "<b>Query: </b>".$director."<br><br>";

	$query = 'http://localhost:8080/exist/rest/db/movies?_howmany=100&_query=/movies/movie';
	$query .= '[';
	if ($title != "") {
		$query .= 'contains(title,"'.$title.'")';
	}
	
	if ($genre != "" && $title != "") {
		$query .= 'and genre = "'.$genre.'"';
	}
	else if ($genre != "") {
		$query .= 'genre = "'.$genre.'"';
	}
	
	if ($year != "" && ($genre != "" || $title != "")) {
		$query .= 'and year = "'.$year.'"';
	}
	else if ($year != "") {
		$query .= 'year = "'.$year.'"';
	}
	
	if ($keywords != "" && ($year != "" || $genre != "" || $title != "")) {
		$query .= 'and contains(summary,"'.$keywords.'")';
	}
	else if ($keywords != "") {
		$query .= 'contains(summary,"'.$keywords.'")';
	}
	
	if ($director != "" && ($keywords != "" || $year != "" || $genre != "" || $title != "")) {
		$query .= 'and (contains(director/last_name,"'.$director.'") or contains(director/first_name,"'.$director.'"))';
	}
	else if ($director != "") {
		$query .= 'contains(director/last_name,"'.$director.'") or contains(director/first_name,"'.$director.'")';
	}
	
	if ($actor != ""  && ($director != "" || $keywords != "" || $year != "" || $genre != "" || $title != "")) {
		$query .= 'and (contains(actor/last_name,"'.$actor.'") or contains(actor/first_name,"'.$actor.'"))';
	}
	else if ($actor != "") {
		$query .= 'contains(actor/last_name,"'.$actor.'") or contains(actor/first_name,"'.$actor.'")';
	}
	$query .= ']';


	echo "<b>Query: </b>".$query."<br><br>";
	$response = file_get_contents($query);
	$xml = simplexml_load_string($response);
	echo "<b>Response in array format:</b> <br>";
	print_xhtml_doc($xml);

	echo '<br><br><a href="movie_form.php"> Try another query!</a>';
}

function print_xhtml_doc($movies_xml){
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml">';

	echo'<head><title>Movie Results List</title></head>';
	echo '<body>';
	print_movie_list($movies_xml);
	print_js_function();
	echo'</body></html>';
}

function print_movie_list($movies_xml){
	$i = 1;
	foreach($movies_xml->movie as $movie){
		echo '<div id="movie'.$i.'_title">';
		echo '<a href="#" onclick="return summaryToggle();">'.(string)$movie->title."</a></br>";
		echo '</div>';
		echo '<div id="movie'.$i.'_summary">';
		echo '</div>';
	}
}

function print_js_function(){
echo '
<script type="text/javascript">;
	function summaryToggle(){
		console.log("test test");
	}
</script>
';
}

?>

