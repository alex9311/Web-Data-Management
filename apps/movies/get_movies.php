<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$query = 'bla';
	
	$title = $_POST["title"];
	$genre = $_POST["genre"];
	$director = $_POST["director"];
	$actor = $_POST["actor"];
	$year = $_POST["year"];
	$keywords = $_POST["keywords"];
	if ($title == "" && $director == "" && $actor == "") {
		$title = "*";
	}
	if ($keywords == ""&& $director == "" && $actor == "") {
		$keywords = "*";
	}
	$query = 'http://localhost:8080/exist/rest/db/movies?_howmany=100&_query=/movies/movie[contains(title,"'.$title.'") or genre = "'.$genre.'" or year = "'.$year.'" or contains(summary,"'.$keywords.'")]/director[contains(last_name,"'.$director.'") or contains(first_name,"'.$director.'")]/../actor[contains(last_name,"'.$actor.'") or contains(first_name,"'.$actor.'")]/../node()';


	echo "<b>Query: </b>".$query."<br><br>";
	$response = file_get_contents($query);
	$xml = simplexml_load_string($response);
	echo "<b>Response in array format:</b> <br>";
	print_r($xml);

	echo '<br><br><a href="movie_form.php"> Try another query!</a>';
}

?>
