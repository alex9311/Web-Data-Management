<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
include 'lib/Client.class.php';
include 'lib/Query.class.php';
include 'lib/ResultSet.class.php';
include 'lib/SimpleXMLResultSet.class.php';
include 'lib/DOMResultSet.class.php';

$target_dir = "xml/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($fileType != "xml") {
    echo "Sorry, only XML files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $connConfig = array(
            'protocol'=>'http',
            'user'=>'admin',
            'password'=>'alex',
            'host'=>'localhost',
            'port'=>'8080',
            'path'=>'/exist/xmlrpc'
        );
        $conn = new \ExistDB\Client($connConfig);
	
	$conn->createCollection('music');	

	$catalogAsSingleNode = simplexml_load_file($target_file);
	$conn->storeDocument(
                'music/'.basename( $_FILES["fileToUpload"]["name"]),
                $catalogAsSingleNode->asXML()
        );
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
