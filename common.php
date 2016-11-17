<?php

$servername = 'localhost:3306';
$dbname = 'myDB';
$username = 'root';
$password = 'Gpp!NzTRM2Cbs';

try {
    $conn = new PDO("mysql:host=" . $GLOBALS['servername'] . ";dbname=" . $GLOBALS['dbname'], $GLOBALS['username'], $GLOBALS['password']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT * FROM actors WHERE first_name = 'Kevin' AND last_name = 'Bacon'";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $row = $stmt->fetch();
    $kevinsid = $row['id'];
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
$conn = null;

function get_actor_id($firstname, $lastname) {
    try {
        $conn = new PDO("mysql:host=" . $GLOBALS['servername'] . ";dbname=" . $GLOBALS['dbname'], $GLOBALS['username'], $GLOBALS['password']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT id FROM actors WHERE (first_name LIKE '%" . $firstname . "%' AND last_name = '" . $lastname . "') AND film_count >= all(SELECT film_count FROM actors WHERE first_name LIKE '%" . $firstname . "%' AND last_name = '" . $lastname . "')";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch();
        if($row['id']){
            return $row['id'];
        } else {
            return -1;
        }
    } catch (PDOException $e) {
        die('Database connection failed: ' . $e->getMessage());
    }
        
    $conn = null;
}

?>