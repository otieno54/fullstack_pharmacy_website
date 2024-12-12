<?php
// Ensure session is started
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="nav2.css">
    <link rel="stylesheet" type="text/css" href="form3.css">
    <link rel="stylesheet" type="text/css" href="table2.css">
    <title>New Sales</title>
</head>

<body>

    <div class="sidenav">
        <h2 style="font-family:Arial; color:white; text-align:center;"> MY PHARMACY </h2>
        <a href="adminmainpage.php">Dashboard</a>
        <button class="dropdown-btn">Medicine <i class="down"></i></button>
        <div class="dropdown-container">
            <a href="inventory-add.php">Add New Medicine</a>
            <a href="inventory-view.php">Manage Medicine</a>
        </div>
        <button class="dropdown-btn">Patients <i class="down"></i></button>
        <div class="dropdown-container">
            <a href="customer-add.php">Add New Patient</a>
            <a href="customer-view.php">Manage Patients</a>
        </div>
        <a href="salesitems-view.php">View Sold Products Details</a>
        <a href="pos1.php">Add New Sale</a>
    </div>

    <div class="topnav">
        <a href="logout.php">Logout</a>
    </div>

    <center>
        <div class="head">
            <h2> POINT OF SALE</h2>
        </div>
    </center>

    <!-- Form for Customer -->
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <center>
            <select id="cid" name="cid">
                <option value="0" selected="selected">*Select Patient's ID (only once for a patient's sales)</option>
                <?php
                include "config.php";
                $qry = "SELECT c_id FROM customer";
                $result = $conn->query($qry);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option>" . $row["c_id"] . "</option>";
                    }
                }
                ?>
            </select>
            &nbsp;&nbsp;
            <input type="submit" name="custadd" value="Add to Proceed.">
        </center>
    </form>

    <?php
    if (isset($_POST['custadd']) && isset($_POST['cid']) && $_POST['cid'] != '0') {
        $cid = $_POST['cid'];

        // Get current admin ID
        $qry1 = "SELECT id FROM admin WHERE a_username='$_SESSION[user]'";
        $result1 = $conn->query($qry1);
        $row1 = $result1->fetch_row();
        $eid = $row1[0];

        // Insert into sales
        $qry2 = "INSERT INTO sales(c_id,e_id) VALUES ('$cid','$eid')";
        if (!$conn->query($qry2)) {
            echo "<p style='font-size:8; color:red;'>Invalid! Enter valid Customer ID to record Sales.</p>";
        }
    }
    ?>

    <!-- Form for Medicine Search -->
    <form method="post">
        <center>
            <select id="med" name="med">
                <option value="0" selected="selected">Select Medicine</option>
                <?php
                $qry3 = "SELECT med_name FROM meds";
                $result3 = $conn->query($qry3);
                if ($result3->num_rows > 0) {
                    while ($row4 = $result3->fetch_assoc()) {
                        echo "<option>" . $row4["med_name"] . "</option>";
                    }
                }
                ?>
            </select>
            &nbsp;&nbsp;
            <input type="submit" name="search" value="Search">
        </center>
    </form>

    <?php
    if (isset($_POST['search']) && isset($_POST['med']) && $_POST['med'] != '0') {
        $med = $_POST['med'];
        $qry4 = "SELECT * FROM meds WHERE med_name='$med'";
        $result4 = $conn->query($qry4);
        if ($result4->num_rows > 0) {
            $row4 = $result4->fetch_row();
        }
    }
    ?>
<div class="one row" style="margin-right:160px;">
    <form method="post">
        <div class="column">
            <label for="medid">Medicine ID:</label>
            <!-- Remove readonly to make the field editable -->
            <input type="number" name="medid" value="<?php echo isset($row4) ? $row4[0] : ''; ?>"><br><br>

            <label for="mdname">Medicine Name:</label>
            <!-- Remove readonly to make the field editable -->
            <input type="text" name="mdname" value="<?php echo isset($row4) ? $row4[1] : ''; ?>"><br><br>
        </div>
        <div class="column">
            <label for="mcat">Category:</label>
            <!-- Remove readonly to make the field editable -->
            <input type="text" name="mcat" value="<?php echo isset($row4) ? $row4[3] : ''; ?>"><br><br>

            <label for="mloc">Location:</label>
            <!-- Remove readonly to make the field editable -->
            <input type="text" name="mloc" value="<?php echo isset($row4) ? $row4[5] : ''; ?>"><br><br>
        </div>
        <div class="column">
            <label for="mqty">Quantity Available:</label>
            <!-- Remove readonly to make the field editable -->
            <input type="number" name="mqty" value="<?php echo isset($row4) ? $row4[2] : ''; ?>"><br><br>

            <label for="mprice">Price of One Unit:</label>
            <!-- Remove readonly to make the field editable -->
            <input type="number" name="mprice" value="<?php echo isset($row4) ? $row4[4] : ''; ?>"><br><br>
        </div>

        <label for="mcqty">Quantity Required:</label>
        <input type="number" name="mcqty">
        &nbsp;&nbsp;&nbsp;
        <input type="submit" name="add" value="Add Medicine">&nbsp;&nbsp;&nbsp;
    </form>
</div>

    <?php
    if (isset($_POST['add'])) {
        $mid = $_POST['medid'];
        $aqty = $_POST['mqty'];
        $qty = $_POST['mcqty'];

        if ($qty > $aqty || $qty == 0) {
            echo "QUANTITY INVALID!";
        } else {
            $price = $_POST['mprice'] * $qty;

            // Get latest sale_id
            $qry5 = "SELECT sale_id FROM sales ORDER BY sale_id DESC LIMIT 1";
            $result5 = $conn->query($qry5);
            $row5 = $result5->fetch_row();
            $sid = $row5[0];

            // Check if the sale already exists for this medicine
            $qry_check = "SELECT * FROM sales_items WHERE sale_id = $sid AND med_id = $mid";
            $result_check = $conn->query($qry_check);

            // If sale exists, display error, else insert new record
            if ($result_check->num_rows > 0) {
                echo "This medicine has already been added to the sale.";
            } else {
                // Insert into sales_items
                $qry6 = "INSERT INTO sales_items(`sale_id`,`med_id`,`sale_qty`,`tot_price`) VALUES($sid,$mid,$qty,$price)";
                if ($conn->query($qry6)) {
                    echo "<br><br><center><a class='button1 view-btn' href=pos2.php?sid=" . $sid . ">View Order</a></center>";
                } else {
                    echo mysqli_error($conn);
                }
            }
        }
    }
    ?>

    <script>
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });
        }
    </script>

</body>
</html>
