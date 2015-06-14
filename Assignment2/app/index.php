<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
<head>
<?php include "handle_search.php";?>
<link rel="stylesheet" type="text/css" href="style_bib.css"/>
</head>
<body>
<?php
	session_start();
        if(isset($_SESSION["message"])){      	
		echo '<p style="background-color: rgb(51, 204, 255)">'.$_SESSION["message"].'</p>'; 
            	unset($_SESSION['message']);
      	}

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
<?php get_log();?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	show_search_results($_POST);
}

?>
<?php
function get_log(){
	$ch = curl_init();
 
	curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:5984/_log 10000');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-type: application/json',
		'Accept: */*'
	));
 
	curl_setopt($ch, CURLOPT_USERPWD, 'admin:admin');
 
	$response = curl_exec($ch);
	print_r(str_replace("- -","<br>- -",$response));

	curl_close($ch);
}
?>
</body>
</html>
