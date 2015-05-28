<?php
function get_score_form(){
	$query = 'http://localhost:8080/exist/rest/db?_query=';
	$xquery = <<<'XQUERY'
		let $score := //score-partwise 
		return  
			<form class="select_score_form" method="post">
				<select name="score">
					<option value=""/>
					{for $title in collection("/music") return 
                                            let $doc_name := substring-after(document-uri($title), '/db/music/') return
						<option value ="{$doc_name}"> {$doc_name}</option>
					}
				</select>
				<input type="submit" value="Show score pdf"/>
			</form>
XQUERY;
	$url_safe_query = $query.trim(str_replace(array("\r", "\n","\t"), '', $xquery));
	return file_get_contents($url_safe_query);
}
?>
