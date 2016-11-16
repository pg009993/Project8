<!DOCTYPE html>
<html>
	<head>
        <title>My Movie Database (MyMDb)</title>
		<meta charset="utf-8" />

		<!-- Link to your CSS file that you should edit -->
		<link href="bacon.css" type="text/css" rel="stylesheet" />
	</head>

	<body>

<?php

$firstname =  $_GET['firstname'];
$lastname =  $_GET['lastname'];

$servername = "127.0.0.1";
$username = "root";
$password = "perfectmint299";

// Create connection
$conn = mysql_connect($servername, $username, $password);
if(! $conn){
    die("Database connection failed: ".mysql_error());
}

$db_select = mysql_select_db("myDB", $conn);
if(! $db_select){
    die("Database conn failed: ".mysql_error());
}
else{
    $query = "SELECT * FROM myDB.actors WHERE first_name = '" . $firstname . "' AND last_name = '" . $lastname . "'";
    $result = mysql_query($query);
    if($result){
    $row = mysql_fetch_assoc($result);
    
    $query = "SELECT * FROM myDB.roles, myDB.movies WHERE myDB.roles.movie_id = myDB.movies.id AND actor_id = " . $row['id'];
    $result = mysql_query($query);
    if($result){
    	while($row = mysql_fetch_assoc($result)){
    		var_dump($row);
    	}
    } else {
    	echo "err";
    }
} else {
	echo "err";
}
}

?>

	</body>
</html>
