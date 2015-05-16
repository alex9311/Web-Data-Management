<h2>Movie Query Machine</h2>
<?php
	$genre_response = file_get_contents('http://localhost:8080/exist/rest/db/movies?_query=/movies//genre');
  	$genres = simplexml_load_string($genre_response);
	$unique_genres = [];
	foreach($genres->genre as $genre){
		array_push($unique_genres,(string)$genre);
	}
	$unique_genres = array_unique($unique_genres);
?>

<html>
<body>

<form action="get_movies.php" method="post">
	Movie Tile: <input type="text" name="title"><br>
	Genre:
<select name="genre">
	<option value=""></option>
	<?php
		foreach($unique_genres as $genre){
			echo '<option value="'.$genre.'">'.$genre.'</option>';
		}
	?>
</select><br>
	Director: <input type="text" name="director"><br>
	Actor: <input type="text" name="actor"><br>
	Year: <input type="text" name="year"><br>
	Key Words: <input type="text" name="keywords"><br>
<input type="submit">
</form>

</body>
</html>
