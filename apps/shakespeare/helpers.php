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

function get_play_dropdown_options(){
	$plays_response = file_get_contents('http://localhost:8080/exist/rest/db/shakespeare/plays?_query=//PLAY/TITLE');
  	$plays = simplexml_load_string($plays_response);
	$dropdown_options = '<option value=""></option>';
	foreach($plays->TITLE as $play){
		$dropdown_options .= '<option value="'.$play.'">'.$play.'</option>';
	}
	return $dropdown_options;
}

?>

