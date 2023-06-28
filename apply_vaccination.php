<!DOCTYPE html>
<html>
<head>
    <title>Apply for Vaccination</title>
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
        
        .container select {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
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

        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve the selected center_name from the form
            $centerName = $_POST['center'];

            // Check if the maximum limit of 10 users per day has been reached for the selected center
            $sql = "SELECT COUNT(*) AS total FROM applied_vaccinations WHERE center_name = '$centerName' AND DATE(apply_date) = CURDATE()";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $totalUsers = $row['total'];

            if ($totalUsers < 10) {
                // Insert the user's vaccination application into the database
                $sql = "INSERT INTO applied_vaccinations (center_name, apply_date) VALUES ('$centerName', NOW())";
                if ($conn->query($sql) === TRUE) {
                    echo "<p>Application successful! You have applied for vaccination at $centerName.</p>";
                } else {
                    echo "<p>Failed to apply for vaccination. Please try again later.</p>";
                }
            } else {
                echo "<p>Sorry, the maximum limit of 10 users per day has been reached for $centerName. Please select another vaccination center.</p>";
            }
        }

        // Retrieve the list of vaccination centers from the database
        $sql = "SELECT center_name FROM vaccination_centers";
        $result = $conn->query($sql);
        $centers = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $centers[] = $row['center_name'];
            }
        }

        $conn->close();
        ?>
        
        <h1>Apply for Vaccination</h1>
        
        <form action="" method="post">
            <select name="center">
                <?php
                // Generate the options for vaccination centers
                foreach ($centers as $center) {
                    echo "<option value='$center'>$center</option>";
                }
                ?>
            </select>
            <br>
            <input type="submit" name="apply" value="Apply">
        </form>
        
        <p><a href="index.html">Logout</a></p>
    </div>
</body>
</html>
