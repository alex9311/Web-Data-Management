<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<?php require_once("helpers.php"); ?>
		<?php include "queries/get_play_form.php"; ?>
		<?php include "queries/get_play_list.php"; ?>
		<?php include "queries/get_character_list.php"; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Play Viewer</title>
		<link rel="stylesheet" type="text/css" href="style_plays.css"/>
		<script src="toggle_speakers.js" type="text/javascript"></script>
	</head>
	<body>
		<h2>Play Viewer</h2>
		<?php echo (get_play_form());?>
		<h3><?php echo $_POST["play"]?></h3>
		<div id="play_container" style="float:left; width:50%">
		<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') { echo (get_play_list($_POST["play"])); }?>
		</div>
		<div id="character_list" style="margin-left:50%">
		<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') { echo (get_character_list($_POST["play"])); }?>
		</div>
 <p>
    <a href="http://validator.w3.org/check?uri=referer"><img
      src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
  </p>
		<div style="text-align:center"><a href="../../index.html">Back to Home Screen</a></div>
	</body>
</html>
