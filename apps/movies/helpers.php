<?php

function tidy_html_output($html){
	$config = array(
           'indent'         => true,
           'output-xhtml'   => true,
           'wrap'           => 200
	);

	$tidy = new tidy;
	$tidy->parseString($html, $config, 'utf8');
	$tidy->cleanRepair();
	return $tidy;
}

function get_unique_genres_dropdown_options(){
	$genre_response = file_get_contents('http://localhost:8080/exist/rest/db/movies?_query=/movies//genre');
  	$genres = simplexml_load_string($genre_response);
	$unique_genres = [];
	foreach($genres->genre as $genre){
		array_push($unique_genres,(string)$genre);
	}
	$unique_genres = array_unique($unique_genres);
	$dropdown_options = '<option value=""></option>';
	foreach($unique_genres as $genre){
		$dropdown_options .= '<option value="'.$genre.'">'.$genre.'</option>';
	}
	return $dropdown_options;
}

?>

