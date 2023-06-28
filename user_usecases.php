<!DOCTYPE html>
<html>
<head>
    <title>User Use Cases</title>
    <style>
        body {
            background-image: url('background.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        
        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 4px;
            text-align: center;
        }
        
        .container p {
            margin-bottom: 10px;
        }
        
        .container ul {
            list-style-type: none;
            padding: 0;
        }
        
        .container ul li {
            margin-bottom: 10px;
        }
        
        .container a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0099ff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        
        .container a:hover {
            background-color: #0080ff;
        }

        .container input[type="submit"] {
            background-color: blue;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <?php
        // Database configuration
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "vaccination";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve vaccination centers from the database
            $sql = "SELECT * FROM vaccination_centers";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<p>List of Vaccination Centers:</p>";
                echo "<ul>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li>" . $row['center_name'] . " - Working Hours: " . $row['working_hours'] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No vaccination centers found.</p>";
            }
        }

        $conn->close();
        ?>
        
        <form action="" method="post">
            <input type="submit" name="search" value="Search for Centers">
        </form>

        <form action="apply_vaccination.php" method="post">
            <input type="submit" name="apply" value="Apply for Vaccination">
        </form>
        
        <p><a href="index.html">Logout</a></p>
    </div>
</body>
</html>
