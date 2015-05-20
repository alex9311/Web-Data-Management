<?php
include "query_helpers.php";
function get_play_form(){
	$query = 'http://localhost:8080/exist/rest/db/shakespeare/plays?_query=';
	$xquery = <<<'XQUERY'
		let $plays := //PLAY 
		return  
			<form class="select_play_form" method="post">
				<select name="play">
					<option value=""/>
					{for $title in distinct-values($plays/TITLE) return 
						<option value ="{$title}"> {$title}</option>
					}
				</select>
				<input type="submit"/>
			</form>
XQUERY;
	return execute_query($query.$xquery);
}
?>
