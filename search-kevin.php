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
        include 'common.php';
        
        $firstname = $_GET['firstname'];
        $lastname = $_GET['lastname'];

        // Create connection
        try {
            $conn = new PDO("mysql:host=" . $servername . ";dbname=" . $dbname, $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $actorid =  get_actor_id($firstname, $lastname);
            
            if($actorid === -1){
                echo  "Actor " . $firstname . " " . $lastname . " not found";
                exit;
            }
            
            
            $query = "SELECT * FROM movies m JOIN roles r ON r.movie_id = m.id JOIN actors a ON r.actor_id = a.id JOIN roles rr ON rr.movie_id = m.id JOIN actors aa ON rr.actor_id = aa.id WHERE r.movie_id = rr.movie_id AND r.actor_id = '" . $actorid . "' AND rr.actor_id = " . $kevinsid . " ORDER BY m.year DESC, m.name ASC";
            $stmt = $conn->prepare($query);

            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            echo '<table><tr><th>#</th><th>Title</th><th>Year</th></tr>';
            $index = 1;
            while($row = $stmt->fetch()){
                echo '<tr><td>' . $index . '</td><td>' .  $row["name"] . '</td><td>' . $row['year'] . '</td></tr>';
                $index++;
            }
            echo '</table>';
            
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
        ?>

	</body>
</html>