<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="nav2.css">
<link rel="stylesheet" type="text/css" href="table1.css">
<title>
Products - Sale
</title>
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
	<h2> LIST OF PRODUCTS SOLD</h2>
	</div>
	</center>
	
	<table align="right" id="table1" style="margin-right:100px;">
		<tr>
			<th>Sale ID</th>
			<th>Medicine ID</th>
			<th>Medicine Name</th>
			<th>Quantity Sold</th>
			<th>Total Price</th>
			
		</tr>
		
	<?php
	
	include "config.php";
	$sql = "SELECT sale_id, med_id,sale_qty,tot_price FROM sales_items";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	
	while($row = $result->fetch_assoc()) {
		
		$sql1="SELECT med_name from meds where med_id=".$row["med_id"]."";
		$result1 = $conn->query($sql1);
		
		
		while($row1 = $result1->fetch_assoc()) {
		
			echo "<tr>";
				echo "<td>" . $row["sale_id"]. "</td>";
				echo "<td>" . $row["med_id"] . "</td>";
				echo "<td>" . $row1["med_name"]. "</td>";
				echo "<td>" . $row["sale_qty"]. "</td>";
				echo "<td>" . $row["tot_price"]. "</td>";
			echo "</tr>";
		}
	}
	
	echo "</table>";
} 

	$conn->close();
	
	?>
	
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
