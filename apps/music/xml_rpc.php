<html>
<head>
<title>Music app</title>
</head>
<body>
<h1>Music application</h1>
<form action="upload.php" method="post" enctype="multipart/form-data">
    Select musicXML file to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload musicXML" name="submit">
</form>
<?php
include "get_score_form.php";
include "test_lily/convert.php";
echo get_score_form();
?>

<div id="music_container">
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $document_title = $_POST["score"];
        
        echo convert($document_title);
    }
?>
</div>
</body></html>
