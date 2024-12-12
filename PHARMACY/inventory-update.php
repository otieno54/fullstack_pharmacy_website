<?php 
	include "config.php";
	
	// Check if 'id' is present in the URL
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$qry1 = "SELECT * FROM meds WHERE med_id = '$id'";
		$result = $conn->query($qry1);
		
		// Check if the query returned a result
		if ($result->num_rows > 0) {
			$row = $result->fetch_row(); // Fetch the data into $row
		} else {
			// If no record is found, exit the script
			echo "<p style='color:red;'>Medicine ID not found.</p>";
			exit();
		}
	}

	// Handle form submission
	if (isset($_POST['update'])) {
		$id = $_POST['medid'];
		$name = $_POST['medname'];
		$qty = $_POST['qty'];
		$cat = $_POST['cat'];
		$price = $_POST['sp'];
		$lcn = $_POST['loc'];

		// Update the database
		$sql = "UPDATE meds SET med_name = '$name', med_qty = '$qty', category = '$cat', med_price = '$price', location_rack = '$lcn' WHERE med_id = '$id'";

		if ($conn->query($sql) === TRUE) {
			// If update is successful, redirect to the inventory view page
			header("Location: inventory-view.php");
			exit(); // Stop the script after the redirect
		} else {
			echo "<p style='font-size:8;color:red;'>Error! Unable to update.</p>";
		}
	} else {
		// If the form was not submitted, check if $row is set and retrieve the data
		if (isset($row)) {
			$name = $row[1];
			$qty = $row[2];
			$cat = $row[3];
			$price = $row[4];
			$lcn = $row[5];
		} else {
			// If no data, set default empty values
			$name = '';
			$qty = '';
			$cat = '';
			$price = '';
			$lcn = '';
		}
	}
?>

<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="nav2.css">
<link rel="stylesheet" type="text/css" href="form4.css">
<title>Medicines</title>
</head>

<body>

	<div class="sidenav">
		<h2 style="font-family:Arial; color:white; text-align:center;"> MY PHARMACY </h2>
		<a href="adminmainpage.php">Dashboard</a>
		<button class="dropdown-btn">Medicine
		<i class="down"></i>
		</button>
		<div class="dropdown-container">
			<a href="inventory-add.php">Add New Medicine</a>
			<a href="inventory-view.php">Manage Medicine</a>
		</div>
		<button class="dropdown-btn">Patients
		<i class="down"></i>
		</button> 
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
	<h2> UPDATE MEDICINE DETAILS</h2>
	</div>
	</center>

	<div class="one">
		<div class="row">
			<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
				<div class="column">
				<p>
					<label for="medid">Medicine ID:</label><br>
					<input type="number" name="medid" value="<?= isset($id) ? $id : ''; ?>" readonly>
				</p>
				<p>
					<label for="medname">Medicine Name:</label><br>
					<input type="text" name="medname" value="<?= $name; ?>">
				</p>
				<p>
					<label for="qty">Quantity:</label><br>
					<input type="number" name="qty" value="<?= $qty; ?>">
				</p>
				<p>
					<label for="cat">Category:</label><br>
					<input type="text" name="cat" value="<?= $cat; ?>">
				</p>
				</div>
				
				<div class="column">
				<p>
					<label for="sp">Price: </label><br>
					<input type="number" step="0.01" name="sp" value="<?= $price; ?>">
				</p>
				<p>
					<label for="loc">Location:</label><br>
					<input type="text" name="loc" value="<?= $lcn; ?>">
				</p>
				</div>
		
				<input type="submit" name="update" value="Update">
			</form>
		</div>
	</div>
	
</body>

<script>
	// Dropdown menu script for side navigation
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

</html>
