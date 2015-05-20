<?php
include "helpers.php";
include "queries/get_play_list.php";

function print_play_xhtml($play_title){
	$html= (get_play_list($play_title));
	echo tidy_html_output($html);
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
