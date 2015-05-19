<?php
	function get_genre_list(){
		$query = 'http://localhost:8080/exist/rest/db?_query=';
		$xquery = '
			let$movie:= doc("movies/movies.xml")
			for $genre in distinct-values($movie//genre)
			return<genre>{$genre}</genre>
		';
		$query.= trim(str_replace(array("\r", "\n","\t"), '', $xquery));
		return file_get_contents($query);
	}
?>
