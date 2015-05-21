<?php
function get_lyrics_list($title){
	$query = 'http://localhost:8080/exist/rest/db/music?_query=';
	$query .= ' let $scores := //score-partwise [movement-title = "'.$title.'"]';
	$xquery = <<<'XQUERY'
  return
    <div id="score_wrapper"display="inline-block">
    <h3>{$scores/movement-title/node()}</h3>
    { 
        for $lyric in $scores//lyric return
            if($lyric/syllabic="begin")
            then
                <div class="lyric" display="inline-block">
                    {$lyric/text/node()}
                </div>
            else if ($lyric/syllabic="middle")
                then
                    <div class="lyric"display="inline-block">
                        {$lyric/text/node()} 
                    </div>
            else if ($lyric/syllabic="single")
                then
                    <div class="lyric">
                        {$lyric/text/node()} 
                    </div>
            else if ($lyric/syllabic="end")
                then
                    <div class="lyric">
                        {$lyric/text/node()} 
                    </div>
                else
                    <div class="lyric">
                        {$lyric/syllabic/node()} 
                    </div>
    }
    </div>

XQUERY;
	$url_safe_query = $query.trim(str_replace(array("\r", "\n","\t"), '', $xquery));
	return file_get_contents($url_safe_query);
}
?>
