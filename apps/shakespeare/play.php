<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<link rel="stylesheet" type="text/css" href="style_plays.css"/>
		<script src="toggle_speakers.js" type="text/javascript"></script>
		<?php require_once("helpers.php"); ?>
		<?php include "queries/get_play_form.php"; ?>
		<?php include "queries/get_play_list.php"; ?>
	</head>
	<body>
		<h2>Play Viewer</h2>
		<?php echo (get_play_form());?>
		<div id="play_container">
		<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') { echo (get_play_list($_POST["play"])); }?>
		</div>
		<div style="text-align:center"><a href="../../index.html">Back to Home Screen</a></div>
	</body>
</html>
