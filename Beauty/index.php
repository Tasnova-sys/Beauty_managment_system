<!DOCTYPE html>
<html>

<head>
  
    <title>Beauty Product Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .welcome-container {
            background: white;
            padding: 40px 30px;
            border-radius: 5px;
            border: 1px solid #ddd;
            text-align: center;
            max-width: 500px;
        }

        h1 {
            color: #6b4423;
            margin-bottom: 15px;
            font-size: 28px;
        }

        p {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .button-group {
            margin-top: 20px;
        }

        a {
            display: inline-block;
            padding: 12px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin: 5px 0;
        }

        .btn-primary {
            background: #d4a574;
            color: #333;
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }
    </style>
</head>

<body>
    <div class="welcome-container">
        <h1>Beauty Product Management</h1>
        <p>Welcome to our online beauty product shopping platform. </p>

        <div class="button-group">
            <a href="Management/Buyer/MVC/html/login.php" class="btn-primary">Login</a>
            <a href="Management/Buyer/MVC/html/register.php" class="btn-secondary">Register</a>
        </div>
    </div>
</body>

</html>
