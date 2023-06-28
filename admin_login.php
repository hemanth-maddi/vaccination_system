<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
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
            width: 300px;
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            padding: 20px;
            text-align: center;
            margin: 0 auto;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        input[type="submit"] {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0099ff;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        input[type="submit"]:hover {
            background-color: #0077cc;
        }
        
        .success-message {
            color: green;
        }
        
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <?php
    $successMessage = '';
    $errorMessage = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

        // Get form data
        $adminName = $_POST['adminName'];
        $adminPassword = $_POST['adminPassword'];

        // Check admin credentials
        $sql = "SELECT * FROM admin WHERE admin = '$adminName' AND password = '$adminPassword'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Admin login successful
            $successMessage = "Login successful!";
        } else {
            // Admin login failed
            $errorMessage = "Invalid admin credentials.";
        }

        $conn->close();
    }
    ?>
    
    
    <div class="container">
    <h1>Admin Login</h1>
        <form action="" method="post">
            <label for="adminName">Admin Name:</label>
            <input type="text" name="adminName" id="adminName" required><br><br>
            
            <label for="adminPassword">Password:</label>
            <input type="password" name="adminPassword" id="adminPassword" required><br><br>
            
            <input type="submit" value="Login">
            
            <?php if ($successMessage): ?>
                <p class="success-message"><?php echo $successMessage; ?></p>
            <?php endif; ?>
            
            <?php if ($errorMessage): ?>
                <p class="error-message"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
