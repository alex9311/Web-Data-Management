<?php
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
	$url_safe_query = $query.trim(str_replace(array("\r", "\n","\t"), '', $xquery));
	return file_get_contents($url_safe_query);
}
?>
