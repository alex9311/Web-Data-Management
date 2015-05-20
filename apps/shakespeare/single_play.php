<?php
include "helpers.php";

function print_play_xhtml($play_title){
	$html= (print_xhtml_doc($play_title));
	echo tidy_html_output($html);
}

function print_xhtml_doc($title){
	$output = "<h2>".$title."</h2>";
	$output .= '<link rel="stylesheet" type="text/css" href="style_plays.css"/>';
	$output .= write_table_of_contents($title);
	$output .= write_character_list($title);
	$output .= print_charlist_toggle_function();
	$output .= '<br><a href="select_play.php">Select new play</a>';
	$output .='</body></html>';
	return $output;
}

function write_character_list($title){
	$character_list = "<p><b>List of Characters </b></p>";
	
	$character_query = 'http://localhost:8080/exist/rest/db/shakespeare/plays?_howmany=100&_query=//PLAY[TITLE="'.$title.'"]//PERSONA';
	$characters = simplexml_load_string(file_get_contents($character_query));
	
	foreach($characters as $character){
		$character_arg = explode(",",(string)$character)[0];
		$character_list .= '<a href="character.php?character='.$character_arg.'&title='.$title.'">'.$character."</a><br>";
	}
	return $character_list;
}

function write_table_of_contents($title){
	$table_of_contents = "<h4> Table of Contents </h4>";

	$contents_query = 'http://localhost:8080/exist/rest/db/shakespeare/plays?_howmany=100&_query=//PLAY[TITLE="'.$title.'"]//ACT';		
	$acts = simplexml_load_string(file_get_contents($contents_query));

	$i = 0;
	foreach($acts->ACT as $act){
		$table_of_contents .= '<div class="act">'.$act->TITLE;
		
		$act_title = $act->TITLE;
		
		$scene_query = 'http://localhost:8080/exist/rest/db/shakespeare/plays?_howmany=100&_query=//PLAY[TITLE="'.$title.'"]//ACT[TITLE = "'.$act_title.'"]//SCENE/TITLE';
		
		$scenes = simplexml_load_string(file_get_contents($scene_query));
		
		foreach($scenes as $scene){
			$table_of_contents .= '<div class="scene">';
			$table_of_contents .= '<a href="#" onclick="return charlistToggle('.$i.');">'.$scene.'</a>';
			$table_of_contents .= '<div id="char_list'.$i.'" style="display:none">';
			$table_of_contents .= get_characters_for_scene($title, (string)$act->TITLE,$scene);
			$table_of_contents .= "</div>";
			$table_of_contents .= "</div>";
			$i = $i + 1;
		}
		$table_of_contents .= "</div>";
	}
	return $table_of_contents;
}

function get_characters_for_scene($play_title,$act_title,$scene_title){
	$contents_query = 'http://localhost:8080/exist/rest/db/shakespeare/plays?_howmany=100&_query=//PLAY[TITLE="'.$play_title.'"]//ACT[TITLE = "'.$act_title.'"]//SCENE[TITLE = "'.$scene_title.'"]';
	return '<div class="character"> some character in act: '.$contents_query.', scene: '.$scene_title.'</div>';
}

function print_charlist_toggle_function(){
return '
<script type="text/javascript">
	function charlistToggle(charlist_id,summary){
		var e = document.getElementById("char_list"+charlist_id);
		if(e.style.display == "block")
			e.style.display = "none";
		else
			e.style.display = "block";
	}
</script>
';
}

?>
