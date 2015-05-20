<?php

function remove_outer_xquery_tags($html_string){
	return preg_replace( '/^<[^>]+>|<\/[^>]+>$/', '', $html_string);
}

function execute_query($query){
	$url_safe_query = trim(str_replace(array("\r", "\n","\t"), '', $query));
	$query_result = file_get_contents($url_safe_query);
	return remove_outer_xquery_tags($query_result);
}
?>

