<?php
include "helpers.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$play_title = $_POST["play"];
	
	$html= (print_xhtml_doc($play_title));
	echo tidy_html_output($html);
}

function print_xhtml_doc($title){
	$output .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	$output .= '<html xmlns="http://www.w3.org/1999/xhtml">';
	$output .='<head><title>'.$title.'</title><link rel="stylesheet" type="text/css" href="style_plays.css"/></head>';
	$output .= '<body>';
	$output .= "<h2>".$title."</h2>";
	$output .= write_table_of_contents($title);
	$output .= write_character_list($title);
	$output .= '<br><a href="movie_form.php"> Try another query!</a>';
	$output .='</body></html>';
	return $output;
}

function write_character_list($title){
	$character_list = "<p><b>List of Characters </b></p>";
	
	$character_query = 'http://localhost:8080/exist/rest/db/shakespeare/plays?_howmany=100&_query=//PLAY[TITLE="'.$title.'"]//PERSONA';
	$characters = simplexml_load_string(file_get_contents($character_query));
	
	foreach($characters as $character){
		$character_list .= $character."<br>";
	}
	return $character_list;
}

function write_table_of_contents($title){
	$table_of_contents .= "<h4> Table of Contents </h4>";

	$contents_query = 'http://localhost:8080/exist/rest/db/shakespeare/plays?_howmany=100&_query=//PLAY[TITLE="'.$title.'"]//ACT';		
	$acts = simplexml_load_string(file_get_contents($contents_query));
	
	foreach($acts->ACT as $act){
		$table_of_contents .= '<div class="act">'.$act->TITLE."</div>";
		foreach($act->SCENE as $scene){
			$table_of_contents .= '<div class="scene">'.$scene->TITLE."</div>";
		}
	}
	return $table_of_contents;
}

?>
