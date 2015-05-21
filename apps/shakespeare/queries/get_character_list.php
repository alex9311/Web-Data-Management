<?php
require_once("query_helpers.php");
function get_character_list($title){
	$query = 'http://localhost:8080/exist/rest/db/shakespeare/plays?_query=';
	$query .= ' let $plays := //PLAY [TITLE = "'.$title.'"]';
	$xquery = <<<'XQUERY'

		return
			<div class="character_list">
				<h4>Character List</h4>
				{ for $character in distinct-values($plays//PERSONA) return
					<div class="character">{$character}</div>}
			</div>

XQUERY;
	return execute_query($query.$xquery);
}
?>
