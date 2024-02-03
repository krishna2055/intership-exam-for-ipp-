<?php

    session_start();
    require_once("config/database.config.php");

    // handle login
    // check if there exists a session
    if (isset($_SESSION['username']) && isset($_SESSION['role'])){
        // there exists a session
        $role = $_SESSION['role'];
        if($role === "admin"){
            // redirect to admin page
            header("Location: http://localhost/krishna/admin.php");
        }else if ($role === "reception"){
            // redirect to reception's page
            header("Location: http://localhost/krishna/admin.php");
        }else{
            // redirect to customer page
            header("Location: http://localhost/krishna/booking.php");
        }
    }else{
        // login user

        if (isset($_POST['submit'])){

            // get credentials
            $username = $_POST["username"];
            $password = $_POST["password"];

            // trim 
            $username = stripslashes($username);
            $password = stripslashes($password);

            // attempt to login the user
            $sql_c = "SELECT * FROM customer WHERE `username` ='$username' AND `password` = '$password' ";
            $sql_r = "SELECT * FROM receptionist WHERE `username` ='$username' AND `password` = '$password' ";
            $sql_a = "SELECT * FROM manager WHERE `username` ='$username' AND `password` = '$password' ";

            $result = $dbc->query($sql_c);
            $result2 = $dbc->query($sql_r);
            $result3 = $dbc->query($sql_a); 

            

            if ($result->num_rows > 0){
                $row = $result->fetch_assoc();
                // login customer
                $_SESSION['username'] = $username;
                $_SESSION['role'] = "customer";
                $_SESSION['id'] = $row["id"];
                // redirect to booking
                header("Location: http://localhost/krishna/booking.php");
            }
            else if ($result2->num_rows > 0){
                // login receptionist
                $_SESSION['username'] = $username;
                $_SESSION['role'] = "reception";
                header("Location: http://localhost/krishna/admin.php");
            }
            else if ($result3->num_rows > 0){
                // login manager
                $_SESSION['username'] = $username;
                $_SESSION['role'] = "admin";
                header("Location: http://localhost/krishna/admin.php");
            }else{
                
                echo 'send your link into your account';
            }
            
            

        }

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>intership</title>
    <link rel="stylesheet" href="style/site.css">
</head>
<body>
    <header>
        <nav>
            <div>
                <h1>Intership</h1>
            </div>

            <ul>
                <li><a href="index.php">Login</a></li>
                <li><a href="signup.php">Create Account</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <form action="<?php echo $_SERVER["PHP_SELF"];  ?>" method="post" autocomplete="off">
        <h1>Login Here</h1>
            <div class="input-field">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" autocomplete="Username" placeholder="Enter username" required>
            </div>
            <div class="input-field">
                <label for="username">Password</label>
                <input type="password" name="password" class="form-control" autocomplete="Enter password" placeholder="Enter password" required>
            </div>
            <div class="input-field">
                <label for=""></label>
                <button type="submit" class="button" name="submit">Login</button>
            </div>
            
        </form>
    </main>

</body>
</html>
