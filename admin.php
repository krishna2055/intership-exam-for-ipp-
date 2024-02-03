<?php
    session_start();

    require_once("config/database.config.php");

    $rooms = [];
    $users = [];
    $bookings = [];
    $payments = [];

    if (isset($_SESSION['username']) && isset($_SESSION['role'])){
        $role = $_SESSION['role'];
        if ($role !== "customer" ){

            $sql_c = "SELECT * FROM `customer`";
            $sql_r = "SELECT * FROM `receptionist`";
            $sql_m = "SELECT * FROM `manager`";
            $sql_rm = "SELECT * FROM `room`";
            $sql_pm = "SELECT * FROM `payment`";
            $sql_bk = "SELECT * FROM `booking`";

            $result = $dbc->query($sql_c);
            $result2 = $dbc->query($sql_r);
            $result3 = $dbc->query($sql_m);
            $result4 = $dbc->query($sql_rm);
            $result5 = $dbc->query($sql_pm);
            $result6 = $dbc->query($sql_bk);

            if ($result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
                    array_push($users, $row);
                }
            }

            if ($result2->num_rows > 0){
                while ($row = $result2->fetch_assoc()){
                    array_push($users, $row);
                }
            }

            if ($result3->num_rows > 0){
                while ($row = $result3->fetch_assoc()){
                    array_push($users, $row);
                }
            }

            if ($result4->num_rows > 0){
                while ($row = $result4->fetch_assoc()){
                    array_push($rooms, $row);
                }
            }

            if ($result5->num_rows > 0){
                while ($row = $result5->fetch_assoc()){
                    array_push($payments, $row);
                }
            }

            if ($result6->num_rows > 0){
                while ($row = $result6->fetch_assoc()){
                    array_push($bookings, $row);
                }
            }

            if (isset($_POST['submit'])){
                $name = $_POST['name'];
                $email = $_POST['email'];
                $address = $_POST['address'];
                $phone = $_POST['phone'];
                $username = $_POST['username'];
                $rol = $_POST['role'];
                $password = $_POST['password'];
                $sql = "";

                if ($rol === "admin"){
                    $sql = "INSERT INTO `manager` (name,phone,email,username,address,password) VALUES('$name', '$phone', '$email', '$username', '$address', '$password')";
                }else{
                    $sql = "INSERT INTO `receptionist` (name,phone,email,username,address,password) VALUES('$name', '$phone', '$email', '$username', '$address', '$password')";
                }
        
                
                if ($dbc->query($sql)) {
                    printf("Record inserted successfully.<br />");
                    header("Location: http://localhost/krishna/index.php");
                 }
                 if ($dbc->errno) {
                    printf("Could not insert record into table: %s<br />", $dbc->error);
                 }
            }

        
        }else{
            header("Location: http://localhost/krishna/booking.php");
        }
    }else{
        header("Location: http://localhost/krishna/index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style/site.css">
</head>
<body>

    <header>
        <nav>
            <div>
                <h1>Admin Dashboard</h1>
            </div>

            <ul>
                <li><?php echo $_SESSION['username']; ?></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <div>
            <div class="top">
                <h1>All Users</h1>
                <button class="f-right" id="myBtn">Add</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Username</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($users as $user){
                            echo "<tr>
                                    <td>". $user['name'] ."</td>
                                    <td>". $user['email'] ."</td>
                                    <td>". $user['phone'] ."</td>
                                    <td>". $user['address'] ."</td>
                                    <td>". $user['username'] ."</td>
                            </tr>";
                        }
                    ?>
                </tbody>
            </table>
            <hr>
            <h3>All Bookings</h3>
            <table>
                <thead>
                    <tr>
                        <th>Room ID</th>
                        <th>Customer ID</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($bookings as $bk){
                            echo "<tr>
                                    <td>". $bk['room_id'] ."</td>
                                    <td>". $bk['customer_id'] ."</td>
                                    <td>". $bk['date'] ."</td>
                                    <td>". $bk['type'] ."</td>
                                    <td>". $bk['price'] ."</td>
                                    <td><a href=deletebooking.php?id=". $bk["id"] .">Delete</a></td>
                            </tr>";
                        }
                    ?>
                </tbody>
            </table>
            <hr>
            <h3>All Payments</h3>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($payments as $pay){
                            echo "<tr>
                                    <td>". $pay['booking_id'] ."</td>
                                    <td>". $pay['date'] ."</td>
                                    <td>". $pay['type'] ."</td>
                                    <td>". $pay['amount'] ."</td>
                                    <td><a href=deletepayment.php?id=". $pay["id"] .">Delete</a></td>
                            </tr>";
                        }
                    ?>
                </tbody>
            </table>
            <hr>
        </div>
    </main>

    <div id="myModal" class="modal">

        <div class="modal-content">
            <span class="close">&times;</span>
            <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <h1>Add New Employee</h1>

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
                <label for="role">Role</label>
                <select name="role">
                    <option value="admin">Admin</option>
                    <option value="admin">Receptionist</option>
                </select>
            </div>

            <div class="input-field">
                <label for="pass">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>

                <div class="input-field">
                    <label htmlFor="button"></label>
                    <input type="submit" name="submit" value="Add Employee">
                </div>
            </form>

        </div>

    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
        modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
        modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        }
    </script>
</body>
</html>