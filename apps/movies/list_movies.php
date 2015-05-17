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
	$output .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	$output .= '<html xmlns="http://www.w3.org/1999/xhtml">';
	$output .='<head><title>Movie Results List</title><link rel="stylesheet" type="text/css" href="style_movie.css"/></head>';
	$output .= '<body>';
	$output .= "<h2>Your Query Results</h2>";
	$output .= print_movie_list($movies_xml);
	$output .= '<br><a href="movie_form.php"> Try another query!</a>';
	$output .= print_toggle_summary_function();
	$output .='</body></html>';
	return $output;
}

function print_movie_list($movies_xml){
	$i = 1;
	$output = "";
	foreach($movies_xml->movie as $movie){
		$output .= '<div class="movie" id="movie'.$i.'">';
			$output .= '<div id="movie'.$i.'_title">';
				$output .= '<a href="#" onclick="return summaryToggle('.$i.');">'.(string)$movie->title."</a></br>";
				$output .= print_movie_description($movie,$i);
			$output .= '</div>';	
		$output .= '</div>';
		$i=$i+1;
	}
	return $output;
}

function print_movie_description($movie,$i){
	$output .= '<div class="movie_description" id="movie'.$i.'_description" style="display:none">';
	$output .= print_movie_description_item($movie, $i, "genre", "Genre");
	$output .= print_movie_description_item($movie, $i, "year", "Year");
	$output .= print_movie_description_item($movie, $i, "summary", "Summary");
	$output .= '</div>';
	return $output;
}

function print_movie_description_item($movie,$i,$id_name, $name){
	$output .= '<div id="movie'.$i.'_'.$id_name.'"><b>'.$name.': </b>';
	$output .= (string)$movie->$id_name.'</div>';
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

