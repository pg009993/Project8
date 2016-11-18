<!DOCTYPE html>
<html>

<head>
    <title>My Movie Database (MyMDb)</title>
    <meta charset="utf-8" />
    <!-- Link to your CSS file that you should edit -->
    <link href="bacon.css" type="text/css" rel="stylesheet" /> </head>

<body>
    <div id="banner">
        <!--            Same as index.php file, banner style taken from bacon.css-->
        <a href="index.php"><img src="mymdb.png" alt="banner logo" /></a> My Movie Database </div>
    <div id="content">
        <!--            Style for id=content taken from bacon.css-->
        <h1>Results for <?php echo $_GET['firstname'] . ' ' . $_GET['lastname']; ?> </h1>
        <?php
//            Line below makes connection to database, which was done in common.php
            include 'common.php';
//            Lines below set user input to variables $firstname and $lastname
            $firstname = $_GET['firstname'];
            $lastname = $_GET['lastname'];

            // Create connection
            try {
                $conn = new PDO("mysql:host=" . $servername . ";dbname=" . $dbname, $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // Uses function from common.php
                $actorid = get_actor_id($firstname, $lastname);

                if ($actorid === -1) {
                    echo "Actor " . $firstname . " " . $lastname . " not found";
                    exit;
                }
                // query below returns movies in which actor has appeared in
                $query = "SELECT * FROM roles, movies WHERE roles.movie_id = movies.id AND actor_id = " . $actorid . " ORDER BY movies.year DESC, movies.name ASC";
                $stmt = $conn->prepare($query);

                $stmt->execute();

                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                echo '<table><tr><th>#</th><th>Title</th><th>Year</th></tr>';
                $index = 1;
                // loop below prints results in html, in table form
                while ($row = $stmt->fetch()) {
                    echo '<tr><td>' . $index . '</td><td>' . $row["name"] . '</td><td>' . $row['year'] . '</td></tr>';
                    $index++;
                }
                echo '</table>';
            } catch (PDOException $e) {
                die('Database connection failed: ' . $e->getMessage());
            }
            $conn = null;
            ?>
            <p>A table showing movies that this actor has starred in.</p>
    </div>
</body>

</html>