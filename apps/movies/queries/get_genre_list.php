<?php
function get_genre_list(){
	$query = 'http://localhost:8080/exist/rest/db?_query=';
	$xquery = <<<'XQUERY'
		let$movie:= doc("movies/movies.xml")
		return 
			<select name="genre">
				<option value = ""></option>
				{for $genre in distinct-values($movie//genre) 
					return <option value="{$genre}">{$genre}</option> 
				}
			</select>
XQUERY;
	$query.= trim(str_replace(array("\r", "\n","\t"), '', $xquery));
	return file_get_contents($query);
}
?>
