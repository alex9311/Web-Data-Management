<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$query = 'bla';
	
	$title = $_POST["title"];
	$genre = $_POST["genre"];
	$director = $_POST["director"];
	echo "<b>director: </b>".$director."<br><br>";
	if ($title != "") {
		$query = 'http://localhost:8080/exist/rest/db/movies?_query=/movies/movie[contains(title,"'.$title.'")]/node()';
	}
	else if ($genre != "") {
		$query = 'http://localhost:8080/exist/rest/db/movies?_query=/movies/movie[genre = "'.$genre.'"]/node()';
	}
	else if ($director != "") {
		$query = 'http://localhost:8080/exist/rest/db/movies?_query=/movies/movie/director[contains(last_name,"'.$director.'") or contains(first_name,"'.$director.'")]/../node()';
	}


	echo "<b>Query: </b>".$query."<br><br>";
	$response = file_get_contents($query);
	$xml = simplexml_load_string($response);
	echo "<b>Response in array format:</b> <br>";
	print_r($xml);

	echo '<br><br><a href="movie_form.php"> Try another query!</a>';
}

?>
