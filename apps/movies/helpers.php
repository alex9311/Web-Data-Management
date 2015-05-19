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
	$allowed_tags = "<option></option><select></select>";
	return strip_tags($genre_response,$allowed_tags);
}

?>

