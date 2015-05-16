<?php
include "query_movies.php";
include "helpers.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$post_array = $_POST;
	$response = get_movie($_POST);

	$xml = simplexml_load_string($response);
	$html= (print_xhtml_doc($xml));
	echo tidy_html_output($html);
}

function print_xhtml_doc($movies_xml){
	$output = "";
	$output .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	$output .= '<html xmlns="http://www.w3.org/1999/xhtml">';

	$output .='<head><title>Movie Results List</title></head>';
	$output .= '<body>';
	$output .= print_movie_list($movies_xml);
	$output .= print_js_function();
	$output .= '<br><a href="movie_form.php"> Try another query!</a>';
	$output .='</body></html>';
	return $output;
}

function print_movie_list($movies_xml){
	$i = 1;
	$output = "";
	foreach($movies_xml->movie as $movie){
		$output .= '<div id="movie'.$i.'">';
			$output .= '<div id="movie'.$i.'_title">';
				$output .= '<a href="#" onclick="return summaryToggle('.$i.');">'.(string)$movie->title."</a></br>";
			$output .= '</div>';
			$output .= '<div id="movie'.$i.'_description" style="display:none">';
				$output .= '<div id="movie'.$i.'_genre">';
					$output .= (string)$movie->genre;
				$output .= '</div>';
				$output .= '<div id="movie'.$i.'_summary">';
					$output .= (string)$movie->summary;
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
		$i=$i+1;
	}
	return $output;
}

function print_js_function(){
return '
<script type="text/javascript">
	function summaryToggle(movie_id,summary){
		var e = document.getElementById("movie"+movie_id+"_description");
		console.log(e);
		if(e.style.display == "block")
			e.style.display = "none";
		else
			e.style.display = "block";
	}
</script>
';
}

?>

