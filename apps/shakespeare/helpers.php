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


?>

