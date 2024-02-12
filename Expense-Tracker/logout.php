<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <link rel="stylesheet" href="style.css">
    <style>
        
        body {
            text-align: center;
            margin-top: 100px;
        }

        .logout-options {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .logout-options a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .logout-options a:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <?php
    session_abort();
    ?>
    <h1>You have been logged out</h1>
    <div class="logout-options">
        <a href="index.html">Login</a>
        <a href="signup.html">Signup</a>
    </div>
</body>

</html>
