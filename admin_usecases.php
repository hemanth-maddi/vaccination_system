<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
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
        
        .container input[type="text"],
        .container input[type="time"] {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }
        
        .container input[type="submit"],
        .container input[type="button"] {
            background-color: #0099ff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .container input[type="button"] {
            background-color: red;
        }
        
        .container table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .container th, .container td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .container th {
            background-color: #0099ff;
            color: #fff;
        }
        
        .container tr:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Panel</h1>

        <!-- Add New Vaccination Center Form -->
        <h2>Add New Vaccination Center</h2>
        <form action="" method="post">
            <label for="centerName">Center Name:</label>
            <input type="text" name="centerName" id="centerName" required>
            <br>
            <label for="workingHours">Working Hours:</label>
            <input type="time" name="workingHours" id="workingHours" required>
            <br>
            <input type="submit" name="addCenter" value="Add Center">
        </form>

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

        // Add new vaccination center
        if (isset($_POST['addCenter'])) {
            $centerName = $_POST['centerName'];
            $workingHours = $_POST['workingHours'];

            $sql = "INSERT INTO vaccination_centers (center_name, working_hours) VALUES ('$centerName', '$workingHours')";
            if ($conn->query($sql) === TRUE) {
                echo "<p>Vaccination center added successfully!</p>";
            } else {
                echo "<p>Error adding vaccination center: " . $conn->error . "</p>";
            }
        }

        // Delete vaccination center
        if (isset($_POST['deleteCenter'])) {
            $centerID = $_POST['centerID'];

            $sql = "DELETE FROM vaccination_centers WHERE id = $centerID";
            if ($conn->query($sql) === TRUE) {
                echo "<p>Vaccination center deleted successfully!</p>";
            } else {
                echo "<p>Error deleting vaccination center: " . $conn->error . "</p>";
            }
        }

        // Retrieve vaccination centers
        $sql = "SELECT * FROM vaccination_centers";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Vaccination Centers</h2>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Center Name</th><th>Working Hours</th><th>Action</th><th>User Details</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['center_name'] . "</td>";
                echo "<td>" . $row['working_hours'] . "</td>";
                echo "<td><form action='' method='post'><input type='hidden' name='centerID' value='" . $row['id'] . "'><input type='submit' name='deleteCenter' value='Delete'></form></td>";

                // Retrieve user details for the current center
                $centerID = $row['id'];
                $userDetailsSql = "SELECT u.name, u.phn FROM vaccination_details v JOIN users u ON v.user_id = u.id WHERE v.center_id = $centerID";
                $userDetailsResult = $conn->query($userDetailsSql);

                echo "<td>";
                if ($userDetailsResult->num_rows > 0) {
                    echo "<table>";
                    while ($userRow = $userDetailsResult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $userRow['name'] . "</td>";
                        echo "<td>" . $userRow['phn'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No user details found.";
                }
                echo "</td>";

                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No vaccination centers found.</p>";
        }

        // Retrieve dosage details grouped by vaccination centers
        $dosageSql = "SELECT vc.center_name, COUNT(vd.id) as total_dosage FROM vaccination_centers vc LEFT JOIN vaccination_details vd ON vc.id = vd.center_id GROUP BY vc.id";
        $dosageResult = $conn->query($dosageSql);

        if ($dosageResult->num_rows > 0) {
            echo "<h2>Dosage Details (Grouped by Centers)</h2>";
            echo "<table>";
            echo "<tr><th>Center Name</th><th>Total Dosage</th></tr>";
            while ($dosageRow = $dosageResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $dosageRow['center_name'] . "</td>";
                echo "<td>" . $dosageRow['total_dosage'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No dosage details found.</p>";
        }

        $conn->close();
        ?>

        <p><a href="index.html">Logout</a></p>
    </div>
</body>
</html>
