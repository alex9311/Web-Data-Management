<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
<head>
<?php include "handle_search.php";?>
<link rel="stylesheet" type="text/css" href="style_bib.css"/>
</head>
<body>
	<h2 style="text-align:center;">Seach DB</h2>
	<div class="input_form">
		<form action="search_form.php" method="post">
			<fieldset>
			<div class="input_column_left" >
				Tile: <input type="text" name="title"/>
				Author:	<input type="text" name="author"/>
			</div>
			<div class="input_column_right" >
				Journal or Publisher: 		<input type="text" name="publisher"/>
				Year: 	<input type="text" name="year"/>
			</div>
			<input type="submit"/>
			</fieldset>
		</form>
	</div>
	<br>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	show_search_results($_POST);
}

?>

</body>
</html>
