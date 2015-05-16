<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$title = $_POST["title"];
	$genre = $_POST["genre"];
	$query = 'http://localhost:8080/exist/rest/db/movies?_query=/movies/movie[contains(title,"'.$title.'")]/node()';



	echo "<b>Query: </b>".$query."<br><br>";
	$response = file_get_contents('http://localhost:8080/exist/rest/db/movies?_query=/movies/movie[title="'.$title.'"]/node()');
	$xml = simplexml_load_string($response);
	echo "<b>Response in array format:</b> <br>";
	print_r($xml);

	echo '<br><br><a href="movie_form.php"> Try another query!</a>';
}

?>
