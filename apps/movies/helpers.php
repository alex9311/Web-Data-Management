<?php
include "queries/get_genre_list.php";

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
	$genre_response = get_genre_list(); 
  	$genres = simplexml_load_string($genre_response);
	$dropdown_options = "";
	foreach($genres as $genre){
		$dropdown_options .= '<option value="'.$genre.'">'.$genre.'</option>';
	}
	return $dropdown_options;
}
?>

