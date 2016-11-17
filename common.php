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

function get_actor_id($firstname, $lastname) {
    try {
        $conn = new PDO("mysql:host=" . $GLOBALS['servername'] . ";dbname=" . $GLOBALS['dbname'], $GLOBALS['username'], $GLOBALS['password']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT * FROM actors WHERE first_name LIKE '%" . $firstname . "%' AND last_name = '" . $lastname . "'";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        $results = array();
        $numresults = 0;
        while ($row = $stmt->fetch()) {
            $numresults++;
            array_push($results, $row);
        }

        if ($numresults === 0) {
            return -1;
        } else if ($numresults === 1) {
            return $results[0]['id'];
        } else {
            $query = "SELECT * FROM roles WHERE actor_id = " . $GLOBALS['kevinsid'];
            $stmt = $conn->prepare($query);
            $stmt->execute();

            $kevinmovies = array();
            while ($row = $stmt->fetch()) {
                array_push($kevinmovies, $row['movie_id']);
            }


            $counts = array();

            foreach ($results as $result) {
                $query = "SELECT * FROM roles WHERE actor_id = " . $result['id'];
                $stmt = $conn->prepare($query);
                $stmt->execute();

                $count = 0;
                while ($row = $stmt->fetch()) {
                    foreach ($kevinmovies as $kevinmovie) {
                        if ($kevinmovie === $row['movie_id']) {
                            $count++;
                        }
                    }
                }

                $counts[$result['id']] = $count;
            }

            $lowest = max($counts);
            $lowest_arr = array();
            foreach ($results as $result) {
                if ($counts[$result['id']] === $lowest) {
                    array_push($lowest_arr, $result);
                }
            }

            if (count($lowest_arr) === 1) {
                return $lowest_arr[0]['id'];
            } else {
                $min = PHP_INT_MAX;
                foreach ($lowest_arr as $r) {
                    if ($r['id'] < $min) {
                        $min = $r['id'];
                    }
                }
                return $min;
            }
        }
    } catch (PDOException $e) {
        die('Database connection failed: ' . $e->getMessage());
    }
}

?>