<?php
function get_speaker_part($title,$act,$scene,$speaker){
	$query = 'http://localhost:8080/exist/rest/db/shakespeare/plays?_query=';
	$query .= 'let $scene := //PLAY [TITLE = "'.$title.'"]/ACT['.$act.']/SCENE['.$scene.'],';
	$query .= '$speaker:= "'.$speaker.'",';
	$query .= '$title:= "'.$title.'",';
	$query .= '$actno:= "'.$act.'",';
	$query .= '$sceneno:= "'.$scene.'"';
	$xquery=<<<'XQUERY'
	return
		<div class="speeches">
		<h3>Parts of {$speaker} in {$title} - Act {$actno}, Scene {$sceneno} </h3>
			{for $speech in $scene/SPEECH return 
				if ($speech/SPEAKER=$speaker)
				then
					<div class="speech primary" style="background-color:rgb(51, 204, 255)">{$speech/*}</div>
				else
					<div class="speech secondary">{$speech/*}</div>
				}
		</div>
XQUERY;
	$url_safe_query = $query.trim(str_replace(array("\r", "\n","\t"), '', $xquery));
	return file_get_contents($url_safe_query);
}
?>
