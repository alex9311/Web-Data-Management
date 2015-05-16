<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$play_title = $_POST["play"];
	$query = 'http://localhost:8080/exist/rest/db/shakespeare/plays?_query=//PLAY[TITLE="'.$play_title.'"]/node()';
	echo "<b>Query: </b>".$query."<br><br>";
	$response = file_get_contents($query);
	$xml = simplexml_load_string($response);

	$character_query = 'http://localhost:8080/exist/rest/db/shakespeare/plays?_howmany=100&_query=//PLAY[TITLE="'.$play_title.'"]//PERSONA';
	$characters = simplexml_load_string(file_get_contents($character_query));

	echo "<h2> Play Summary </h2>";

	echo "<p><b> Table of Contents </b></p>";
	$contents_query = 'http://localhost:8080/exist/rest/db/shakespeare/plays?_howmany=100&_query=//PLAY[TITLE="'.$play_title.'"]//ACT';
	
	echo $contents_query;
	
	$acts = simplexml_load_string(file_get_contents($contents_query));
	
	foreach($acts as $act){
		echo $act."<br>";
	}

	echo "<p><b>List of Characters </b></p>";
	foreach($characters as $character){
		echo $character."<br>";
	}



	echo "<b>Response in array format:</b> <br>";
	print_r($xml);

	echo '<br><br><a href="movie_form.php"> Try another query!</a>';
}

?>
