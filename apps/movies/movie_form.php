<?php
$response = file_get_contents('http://localhost:8080/exist/rest/db/movies/movies.xml');
echo $response
?>
<html>
<body>

<form action="welcome.php" method="post">
Name: <input type="text" name="name"><br>
E-mail: <input type="text" name="email"><br>
<input type="submit">
</form>

</body>
</html>
