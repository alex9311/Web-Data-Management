<?php
	$plays_response = file_get_contents('http://localhost:8080/exist/rest/db/shakespeare/plays?_query=//PLAY/TITLE');
  	$plays = simplexml_load_string($plays_response);
?>
Select a play
<form action="single_play.php" method="post">
	<select name="play">
		<option value=""></option>
		<?php 
			foreach($plays->TITLE as $play){
				echo '<option value="'.$play.'">'.$play.'</option>';
			}
		?>
	</select>
	<input type="submit">
</form>
