<?php
include "queries/get_movie_list.php";
include "helpers.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$post_array = $_POST;
	$response = get_movie_list($_POST);
	$html= (print_xhtml_doc($response));
	echo tidy_html_output($html);
}

function print_xhtml_doc($movies_xhtml){
	$output = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	$output .= '<html xmlns="http://www.w3.org/1999/xhtml">';
	$output .='<head><title>Movie Results List</title>';
	$output .= '<link rel="stylesheet" type="text/css" href="style_movie.css"/></head>';
	$output .= '<script src="toggle_description.js"></script>';
	$output .= '<body>';
	$output .= "<h2>Your Query Results</h2>";
	$output .= $movies_xhtml;
	$output .= '<br><a href="movie_form.php"> Try another query!</a>';
	$output .= print_xhtml_valid_logo();
	$output .='</body></html>';
	return $output;
}

function print_xhtml_valid_logo(){
	return '
	<p>
    		<a href="http://validator.w3.org/check?uri=referer"><img
      		src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
  	</p>
	';
}

?>

