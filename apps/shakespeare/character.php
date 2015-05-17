<?php

$play_title = $_GET['title'];
$character = $_GET['character'];

$act_query = 'http://localhost:8080/exist/rest/db/shakespeare/plays?_howmany=100&_query=//PLAY[TITLE="'.$play_title.'"]//ACT[contains(SCENE/SPEECH/SPEAKER, "'.$character.'")]';

$acts = simplexml_load_string(file_get_contents($act_query));

foreach($acts->ACT as $act){	
	$act_title = $act->TITLE;
	$scene_query = 'http://localhost:8080/exist/rest/db/shakespeare/plays?_howmany=100&_query=//PLAY[TITLE="'.$play_title.'"]//ACT/SCENE[../TITLE = "'.$act_title.'" and contains(SPEECH/SPEAKER, "'.$character.'")]';

	$scenes = simplexml_load_string(file_get_contents($scene_query));
	foreach($scenes->SCENE as $scene) {
		print_r($scene);
	}
}

//echo "This page will show ".$_GET['character']."'s parts in each Act/Scene"

?>
