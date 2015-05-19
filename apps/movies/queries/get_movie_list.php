<?php


function get_movie_list($post_array){
	$params_query = build_movie_query($post_array);

	$query = 'http://localhost:8080/exist/rest/db?_query=let$movies:= doc("movies/movies.xml")/movies/movie'.$params_query.' ';
	$query .= get_xquery();
	
	$url_safe_query.= trim(str_replace(array("\r", "\n","\t"), '', $query));
	return file_get_contents($url_safe_query);
}

function get_xquery(){
	$xquery = <<<'XQUERY'
		for $movie at $position in $movies 
		return 
			<div class="movie" id="movie{$position}">
				<a class="link" onclick="return summaryToggle({$position});">{$movie/title/node()}</a><br />
				<div class="movie_description" id="movie{$position}_description" style="display:none"> 
					<div><b>Genre:</b> {$movie/genre}</div> 
					<div><b>Year:</b> {$movie/year}</div> 
					<div><b>Actor(s):</b> { 
						for $actor in $movies/actor 
							return concat($actor/first_name," ", $actor/last_name,", ")
					} </div> 
					<div><b>Director(s):</b> { 
						for $director in $movies/director 
							return concat($director/first_name," ", $director/last_name,", ")
					} </div> 
					<div><b>Summary:</b> {$movie/summary}</div> 
				</div>
			</div>
XQUERY;
	return $xquery;
}


function build_movie_query($post_array){
	$title = $post_array["title"];
	$genre = $post_array["genre"];
	$dir = $post_array["director"];
	$directorList = str_replace(' ', '', $dir);
	$act = $post_array["actor"];
	$actorList = str_replace(' ', '', $act);
	$year = $post_array["year"];
	$keywords = $post_array["keywords"];
	
	$query = '[';
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

	return $query;
}
?>
