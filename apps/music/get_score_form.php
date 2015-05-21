<?php
function get_score_form(){
	$query = 'http://localhost:8080/exist/rest/db/music?_query=';
	$xquery = <<<'XQUERY'
		let $score := //score-partwise 
		return  
			<form class="select_score_form" method="post">
				<select name="score">
					<option value=""/>
					{for $title in distinct-values($score/movement-title) return 
						<option value ="{$title}"> {$title}</option>
					}
				</select>
				<input type="submit" value="Select musicXML"/>
			</form>
XQUERY;
	$url_safe_query = $query.trim(str_replace(array("\r", "\n","\t"), '', $xquery));
	return file_get_contents($url_safe_query);
}
?>