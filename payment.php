<?php
    session_start();
    
    require_once("config/database.config.php");
    $status = false;
    $action = '<?php echo $_SERVER[PHP_SELF]; ?>';
    $amount = "";
    $id = "";

    if (isset($_SESSION['username']) && isset($_SESSION['role']) && isset($_SESSION['id'])){
        $role = $_SESSION['role'];
        $cid = $_SESSION["id"];

        if (isset($_GET['id'])){
            $id = $_GET['id'];

            $_SESSION['bId'] = $id;
            
            $sql = "SELECT booked,price FROM `booking` WHERE `id`='$id'";
            $res = $dbc->query($sql);
            if ($res->num_rows > 0){
                while($row = $res->fetch_assoc()){
                    $status = $row["booked"];
                    $amount = $row["price"];
                }
            }

            if ($status == true){
                echo "You have already made payments";
                
            }

        }

        if (isset($_POST['submit'])){
            $date = $_POST['date'];
            $type = $_POST['type'];
            $id = $_SESSION['bId'];
            $amount = $_POST['amount'];


            $sql_p = "INSERT INTO payment (booking_id,customer_id,receptionist_id,manager_id,date,type,amount) VALUES('$id','$cid','1','1','$date','$type','$amount')";

            $sql_u = "UPDATE booking SET `booked` = '1' WHERE `id`= '$id'";

            if ($dbc->query($sql_p)) {
                printf("Record inserted successfully.<br />");
                $dbc->query($sql_u);
            }
            if ($dbc->errno) {
                printf("Could not insert record into table: %s<br />", $dbc->error);
            }
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
    <title>Make Payments</title>
    <link rel="stylesheet" href="style/site.css">
</head>
<body>
<header>
        <nav>
            <div>
                <h1>Customer Dashboard</h1>
            </div>

            <ul>
                <li><?php echo $_SESSION['username'];  ?></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main class="container">
       <form action="<?php echo $_SERVER["PHP_SELF"];  ?>" method="post" id="form">

        <div class="input-field">
                <input type="radio" name="type" value="Debit Card" checked>Debit Card
                <input type="radio" name="type" value="Credit Card">Credit Card
                <input type="radio" name="type" value="Paypal">Paypal
            </div>
            <div class="input-field">
                <label for="date">Date</label>
                <input type="date" name="date" placeholder="Enter date" required>
            </div>

            <div class="input-field">
                <label for="number">Card Number</label>
                <input type="text" name="card" placeholder="Enter card number" required>
            </div>

            <div class="input-field">
                <label for="number">CVV</label>
                <input type="text" name="card" placeholder="Enter CVV" required>
            </div>

            <div class="input-field">
                <label for="amount">Amount</label>
                <input type="text" name="amount" value="$<?php echo $amount; ?>" readonly>
            </div>

            <div class="input-field">
                <button type="submit" name="submit">Make Payment</button>
            </div>
        </form>
        
    </main>
</body>
</html>