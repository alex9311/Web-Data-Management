<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
<head>
<link rel="stylesheet" type="text/css" href="style_bib.css"/>
</head>
<body>
	<h2 style="text-align:center;">Edit Entry in DB</h2>
	<div class="input_form">
		<form action="handle_add.php" method="post">
			<fieldset>
			Tile: <input type="text" name="title"/>
			Genre:	<input type="text" name="genre"/>
			Summary: 		<input type="text" name="summary"/>
			Year: 	<input type="text" name="year"/>
			<input type="submit"/>
			</fieldset>
		</form>
	</div>
	<a href="index.php">Back to App home</a>
	<br>
</body>
</html>
