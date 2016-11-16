<!DOCTYPE html>
<html>

<head>
    <title>My Movie Database (MyMDb)</title>
    <meta charset="utf-8" />
    <!-- Link to your CSS file that you should edit -->
    <link href="bacon.css" type="text/css" rel="stylesheet" /> </head>

<body>
    <?php
        
$firstname =  $_GET['first_name'];
$lastname =  $_GET['last_name'];

    
//Establish a connection with PHP PDO API    
$servername = "127.0.0.1";
$username = "root";
$password = "root"; // insert your password here. 
$database = "myDB"; 

    
try {
    $conn = new PDO("mysql:host=$servername;dbname=myDB", $username, $password);
    //echo "Connected successfully";
}
    
catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
    }


$stmt = $conn->query('SELECT * FROM actors');
foreach ($stmt as $row)
{
    echo $row['first_name']."\t";
}
    
   $conn = null;      
?>
</body>

</html>