<?php

    require_once("config/database.config.php");

    if (isset($_POST['submit'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "INSERT INTO `customer` (name,phone,email,username,address,password) VALUES('$name', '$phone', '$email', '$username', '$address', '$password')";
        ;
        if ($dbc->query($sql)) {
            printf("Record inserted successfully.<br />");
            header("Location: http://localhost/krishna/index.php");
         }
         if ($dbc->errno) {
            printf("Could not insert record into table: %s<br />", $dbc->error);
         }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style/site.css">
</head>
<body>
    <header>
        <nav>
            <div>
                <h1> Intership </h1>
            </div>

            <ul>
                <li><a href="index.php">Login</a></li>
                <li><a href="signup.php">Create Account</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <div class="input-field">
                <label for="name">Enter name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
            </div>
            <div class="input-field">
                <label for="address">Address</label>
                <input type="text" name="address" class="form-control" placeholder="Enter address" required>
            </div>
            <div class="input-field">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
            </div>
            <div class="input-field">
                <label for="phone">Phone</label>
                <input type="text" name="phone" class="form-control" placeholder="Enter phone" required>
            </div>
            <div class="input-field">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter username" required>
            </div>
            <div class="input-field">
                <label for="username">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>
            <div class="input-field">
                <button type="submit" name="submit" class="btn-submit">Confirm</button>
            </div>
            
        </form>
    </main>
</body>
</html>