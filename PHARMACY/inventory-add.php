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
			<h2 style="font-family:Arial; color:white; text-align:center;"> MY PHARMACY</h2>
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
	<h2> ADD MEDICINE DETAILS</h2>
	</div>
	</center>
	
	<br><br><br><br><br><br><br><br>
	
	<div class="one">
		<div class="row">
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
				<div class="column">
					<p>
						<label for="medid">Medicine ID:</label><br>
						<input type="number" name="medid" required>
					</p>
					<p>
						<label for="medname">Medicine Name:</label><br>
						<input type="text" name="medname" required>
					</p>
					<p>
						<label for="qty">Quantity:</label><br>
						<input type="number" name="qty" required>
					</p>
					<p>
						<label for="cat">Category:</label><br>
						<select id="cat" name="cat" required>
								<option value="Tablet">Tablet</option>
								<option value="Capsule">Capsule</option>
								<option value="Syrup">Syrup</option>
						</select>
					</p>
				</div>
				<div class="column">
					<p>
						<label for="sp">Price: </label><br>
						<input type="number" step="0.01" name="sp" required>
					</p>
					<p>
						<label for="loc">Location:</label><br>
						<input type="text" name="loc" required>
					</p>
				</div>
			
			<input type="submit" name="add" value="Add Medicine">
			</form>
		<br>
		
	<?php
		include "config.php";

		// Check if form is submitted
		if (isset($_POST['add'])) {
			// Sanitize user input
			$id = mysqli_real_escape_string($conn, $_POST['medid']);
			$name = mysqli_real_escape_string($conn, $_POST['medname']);
			$qty = mysqli_real_escape_string($conn, $_POST['qty']);
			$category = mysqli_real_escape_string($conn, $_POST['cat']);
			$sprice = mysqli_real_escape_string($conn, $_POST['sp']);
			$location = mysqli_real_escape_string($conn, $_POST['loc']);

			// Validate inputs
			if (empty($id) || empty($name) || empty($qty) || empty($category) || empty($sprice) || empty($location)) {
				echo "<p style='color:red;'>All fields are required!</p>";
			} else {
				// Prepare and execute the SQL query to insert data into meds table
				$sql = "INSERT INTO meds (med_id, med_name, med_qty, category, med_price, location_rack) 
						VALUES ('$id', '$name', '$qty', '$category', '$sprice', '$location')";
				
				if (mysqli_query($conn, $sql)) {
					echo "<p style='color:green;'>Medicine details successfully added!</p>";
				} else {
					echo "<p style='color:red;'>Error! Check details: " . mysqli_error($conn) . "</p>";
				}
			}
		}

		// Close the database connection
		$conn->close();
	?>
		</div>
	</div>
			
</body>

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

</html>
