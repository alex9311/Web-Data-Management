<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
<head>
<?php include "helpers.php";?>
<link rel="stylesheet" type="text/css" href="style_movie.css"/>

</head>
<body>
	<h2 style="text-align:center;">Movie Query Machine</h2>
	<div class="input_form">
		<form action="list_movies.php" method="post">
			Movie Tile: <input type="text" name="title"/>
			Genre:
				<select name="genre">
					<?php echo get_unique_genres_dropdown_options();?>
				</select>
			Director:	<input type="text" name="director"/>
			Actor: 		<input type="text" name="actor"/>
			Year:	 	<input type="text" name="year"/>
			Key Words: 	<input type="text" name="keywords"/>
			<input type="submit"/>
		</form>
	</div>

</body>
</html>
