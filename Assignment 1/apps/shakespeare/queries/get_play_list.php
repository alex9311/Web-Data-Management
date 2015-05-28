<?php
require_once("query_helpers.php");
function get_play_list($title){
	$query = 'http://localhost:8080/exist/rest/db/shakespeare/plays?_query=';
	$query .= ' let $plays := //PLAY [TITLE = "'.$title.'"]';
	$xquery = <<<'XQUERY'
  return
    <div id="play_wrapper">
    <h4>Table of Contents</h4>
    { for $act at $actno in $plays/ACT return
      <div class="act">
        {$act/TITLE/node()}
        {for $scene at $sceneno in $act/SCENE return
          <div class = "scene">
            <a class="link" onclick="return speakerToggle({$actno}.{$sceneno});">{$scene/TITLE/node()}</a>
            <div id="speaker_list{$actno}.{$sceneno}" style="display:none">
            {for $speaker in distinct-values($scene//SPEAKER/node()) return
              <div class="speaker">{$speaker} - <a href="character.php?section={$plays/TITLE/node()}.{$actno}.{$sceneno}.{$speaker}" >view parts in this scene</a></div>
            }
            </div>
          </div>
        }
      </div>
    }
    </div>

XQUERY;
	return execute_query($query.$xquery);
}
?>
