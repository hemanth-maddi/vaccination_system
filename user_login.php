<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
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
        
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 4px;
            text-align: center;
        }
        
        .form-container label {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 10px;
        }
        
        .form-container label span {
            margin-right: 10px;
        }
        
        .form-container input[type="text"],
        .form-container input[type="password"],
        .form-container input[type="email"] {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }
        
        .form-container input[type="submit"] {
            background-color: #0099ff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .form-container p {
            margin-top: 10px;
            color: #ff0000;
            font-weight: bold;
        }
    </style>
</head>
<body>
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

    $message = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Retrieve user details from database based on email
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if ($row['password'] === $password) {
                $message = "Login successful!!!!!";
            } else {
                $message = "Invalid password!!!";
            }
        } else {
            $message = "Invalid email!!";
        }
    }

    $conn->close();
    ?>
    
    
    
    <div class="form-container">
    <h1>Login</h1>
        <form action="" method="post">
            <label for="email">
                <span>Email:</span>
                <input type="email" name="email" id="email" required>
            </label>
            
            <label for="password">
                <span>Password:</span>
                <input type="password" name="password" id="password" required>
            </label>
            
            <input type="submit" value="Login">
            <p><?php echo $message; ?></p>
        </form>
    </div>
</body>
</html>


