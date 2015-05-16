<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$title = $_POST["title"];
	$genre = $_POST["genre"];
	$dir = $_POST["director"];
	$directorList = str_replace(' ', '', $dir);
	$act = $_POST["actor"];
	$actorList = str_replace(' ', '', $act);
	$year = $_POST["year"];
	$keywords = $_POST["keywords"];
	

	$query = 'http://localhost:8080/exist/rest/db/movies?_howmany=100&_query=/movies/movie';
	$query .= '[';
	if ($title != "") {
		$query .= 'contains(title,"'.$title.'")';
	}
	
	if ($genre != "" && $title != "") {
		$query .= 'and genre = "'.$genre.'"';
	}
	else if ($genre != "") {
		$query .= 'genre = "'.$genre.'"';
	}
	
	if ($year != "" && ($genre != "" || $title != "")) {
		$query .= 'and year = "'.$year.'"';
	}
	else if ($year != "") {
		$query .= 'year = "'.$year.'"';
	}
	
	if ($keywords != "" && ($year != "" || $genre != "" || $title != "")) {
		$query .= 'and contains(summary,"'.$keywords.'")';
	}
	else if ($keywords != "") {
		$query .= 'contains(summary,"'.$keywords.'")';
	}
	
	if ($directorList != "" && ($keywords != "" || $year != "" || $genre != "" || $title != "")) {
		$director_array = explode(',', $directorList);
		
		foreach($director_array as $director) {
			$query .= 'and (contains(director/last_name,"'.$director.'") or contains(director/first_name,"'.$director.'"))';
		}
	}
	else if ($directorList != "") {
		$director_array = explode(',', $directorList);
		$first_director = array_shift($director_array);
		$query .= '(contains(director/last_name,"'.$first_director.'") or contains(director/first_name,"'.$first_director.'"))';
		
		foreach($director_array as $director) {
			$query .= 'and (contains(director/last_name,"'.$director.'") or contains(director/first_name,"'.$director.'"))';
		}
	}
	
	if ($actorList != ""  && ($directorList != "" || $keywords != "" || $year != "" || $genre != "" || $title != "")) {
		$actor_array = explode(',', $actorList);
		
		foreach($actor_array as $actor) {
			$query .= 'and (contains(actor/last_name,"'.$actor.'") or contains(actor/first_name,"'.$actor.'"))';
		}
	}
	else if ($actorList != "") {
		$actor_array = explode(',', $actorList);
		$first_actor = array_shift($actor_array);
		$query .= '(contains(actor/last_name,"'.$first_actor.'") or contains(actor/first_name,"'.$first_actor.'"))';
		
		foreach($actor_array as $actor) {
			$query .= 'and (contains(actor/last_name,"'.$actor.'") or contains(actor/first_name,"'.$actor.'"))';
		}
	}
	$query .= ']';


	//echo "<b>Query: </b>".$query."<br><br>";
	$response = file_get_contents($query);
	$xml = simplexml_load_string($response);
	$html= (print_xhtml_doc($xml));
	echo tidy_html_output($html);




}

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

