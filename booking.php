<?php
    session_start();

    require_once("config/database.config.php");
    $bookings = [];
    $rooms = [];

    if (isset($_SESSION['username']) && isset($_SESSION['role'])){
        $role = $_SESSION['role'];
        $id = $_SESSION["id"];
        if ($role === "customer"){
            $sql_r = "SELECT * FROM `room`";
            $sql_bk = "SELECT * FROM `booking`";

            $result = $dbc->query($sql_r);
            $result1 = $dbc->query($sql_bk);

            if ($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                        array_push($rooms, $row);
                }
            }

            if ($result1->num_rows > 0){
                while($row = $result1->fetch_assoc()){
                    if ($row["customer_id"] === $id){
                        array_push($bookings, $row);
                    }
                }
            }

            if (isset($_POST["submit"])){
                $room = $_POST['room'];
                $date = $_POST['date'];
                //$price = rand(10,100);
                $name = "";
                $type = "";
                $price = "";

                $sql_rm = "SELECT name,type,price from `room` WHERE `id`='$room'";
                $res = $dbc->query($sql_rm);
                if ($res->num_rows > 0){
                    while($row = $res->fetch_assoc()){
                        $name = $row["name"];
                        $type = $row["type"];
                        $price = $row["price"];
                    }
                }



                $sql = "INSERT INTO booking (room_id,receptionist_id,customer_id,manager_id,name,date,type,price,booked) VALUES('$room', '1', '$id', '1', '$name', '$date', '$type', '$price', 'false')";

                if ($dbc->query($sql)) {
                    printf("Record inserted successfully.<br />");
                    header("Location: http://localhost/krishna/booking.php");
                 }
                 if ($dbc->errno) {
                    printf("Could not insert record into table: %s<br />", $dbc->error);
                 }
                 
            }

        }else if($role === "reception"){
            header("Location: http://localhost/krishna/reception.php");
        }else{
            header("Location: http://localhost/krishna/admin.php");
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
    <title> Intership</title>
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
        <div class="top">
            <h1> Conclusion for IT programming </h1>
            <button class="f-right" id="myBtn">Add</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

            <?php
                foreach($bookings as $bk){
                    echo "<tr>
                            <td>".$bk["name"]."</td>
                            <td>".$bk["date"]."</td>
                            <td>".$bk["type"]."</td>
                            <td>".$bk["price"]."</td>
                            <td><a href=payment.php?id=".$bk["id"].">Pay</a></td>
                             
                        </tr>";                    
                }

            ?>
             
            </tbody>
        </table>

    </main>

    <div id="myModal" class="modal">

        <div class="modal-content">
            <span class="close">&times;</span>
            <form action="<?php echo $_SERVER["PHP_SELF"];  ?>" method="post">
            <h1>New Booking</h1>
            <div class="input-field">
                <label for="room">Room Name</label>
                <select name="room">
                    <option value="" selected disabled>-- select room --</option>
                    <?php 
                        foreach($rooms as $rm){
                            echo "<option value=".$rm["id"]. ">". $rm["name"]. " - " . $rm["type"] ."</option>";
                        }
                    
                    ?>
                </select>
            </div>
            <div class="input-field">
                <label for="date">Date</label>
                <input type="date" name="date" placeholder="Enter date" required>
            </div>
            <div class="input-field">
                <label for=""></label>
                <button type="submit" name="submit">Submit</button>
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