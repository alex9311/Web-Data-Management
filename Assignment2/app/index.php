<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
<head>
<?php include "handle_search.php";?>
<link rel="stylesheet" type="text/css" href="style_bib.css"/>
</head>
<body>
<?php
	$title=""; $author=""; $publisher="";$year="";
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$title = $_POST["title"];
		$author = $_POST["author"];
		$publisher = $_POST["publisher"];
		$year = $_POST["year"];
	}
?>
	<h2 style="text-align:center;">Distributed Bibliographic Database</h2>
	<h4 style="margin-bottom: 0; margin-top: 0; ">Add Entry:</h4><a href="add_form.php">Click here to add new entry</a>
	<h4>Search Existing Entries</h4>
	<div class="input_form">
		<form action="index.php" method="post">
			<fieldset>
			<div class="input_column_left" >
				Tile: <input type="text" name="title" value="<?php echo $title; ?>"/>
				Author:	<input type="text" name="author" value="<?php echo $author; ?>"/>
			</div>
			<div class="input_column_right" >
				Journal or Publisher: 		<input type="text" name="publisher" value="<?php echo $publisher; ?>"/>
				Year: 	<input type="text" name="year" value="<?php echo $year ?>"/>
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
