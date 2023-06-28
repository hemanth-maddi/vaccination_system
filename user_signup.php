<!DOCTYPE html>
<html>
<head>
    <title>User Signup</title>
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

        .container {
            width: 400px;
            margin: 0 auto;
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            padding: 20px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            max-width: 250px;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #0099ff;
            color: #fff;
            font-size: 18px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0077cc;
        }
    </style>
</head>
<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Database configuration
        $servername = "127.0.0.1";
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
        $name = $_POST['name'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $phn = $_POST['phone'];

        // Insert user data into "users" table
        $sql = "INSERT INTO users (name, password,email, phn) VALUES ('$name', '$password', '$email', '$phn')";

        if ($conn->query($sql) === TRUE) {
            echo "Signup successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
    
    <div class="container">
        <h1>Signup</h1>
        <form action="" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required><br><br>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br><br>
            
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required><br><br>
            
            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" required><br><br>
            
            <input type="submit" value="Signup">
        </form>
    </div>
</body>
</html>
