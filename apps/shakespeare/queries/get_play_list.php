<?php
function get_play_list($title){
	$query = 'http://localhost:8080/exist/rest/db/shakespeare/plays?_query=';
	$query .= ' let $plays := //PLAY [TITLE = "'.$title.'"]';
	$xquery = <<<'XQUERY'
return
<div id="play_wrapper">
<h3>{$plays/TITLE/node()}</h3>
   { for $act at $actno in $plays/ACT return
   <div class="act" id="act{$actno}">
     {$act/TITLE/node()}
     {for $scene at $sceneno in $act/SCENE return
   <div class = "scene" id="scene{$sceneno}">
<a class="link" onclick="return speakerToggle({$actno}.{$sceneno});">{$scene/TITLE/node()}</a>

<div id="speaker_list{$actno}.{$sceneno}" style="display:none">
    {for $speaker in distinct-values($scene//SPEAKER/node()) return
<div class="speaker">
{$speaker}
</div>
}
</div>
   </div>
}
    </div>
}
</div>

XQUERY;
	$url_safe_query = $query.trim(str_replace(array("\r", "\n","\t"), '', $xquery));
	return file_get_contents($url_safe_query);
}
?>
