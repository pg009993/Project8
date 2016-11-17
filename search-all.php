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
        $firstname = $_GET['firstname'];
        $lastname = $_GET['lastname'];

        $servername = 'localhost:3306';
        $dbname = 'myDB';
        $username = 'root';
        $password = 'Gpp!NzTRM2Cbs';

        // Create connection
        try {
            $conn = new PDO("mysql:host=" . $servername . ";dbname=" . $dbname, $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM actors WHERE first_name = '" . $firstname . "' AND last_name = '" . $lastname . "'";
            $stmt = $conn->prepare($query);

            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            
            $query = "SELECT * FROM roles, movies WHERE roles.movie_id = movies.id AND actor_id = " . $row['id'];
            $stmt = $conn->prepare($query);

            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            while($row = $stmt->fetch()){
                echo $row["name"] . '<br>';
            }
            
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
        ?>

    </body>
</html>
