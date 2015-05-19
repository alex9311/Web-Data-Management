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
	$output .='<head><title>Movie Results List</title><link rel="stylesheet" type="text/css" href="style_movie.css"/></head>';
	$output .= '<body>';
	$output .= "<h2>Your Query Results</h2>";
	$output .= $movies_xhtml;
	$output .= '<br><a href="movie_form.php"> Try another query!</a>';
	$output .= print_toggle_summary_function();
	$output .='</body></html>';
	return $output;
}

function print_toggle_summary_function(){
return '
<script type="text/javascript">
	function summaryToggle(movie_id,summary){
		var e = document.getElementById("movie"+movie_id+"_description");
		if(e.style.display == "block")
			e.style.display = "none";
		else
			e.style.display = "block";
	}
</script>
';
}

?>

