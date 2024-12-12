<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="nav2.css">
	<title>
		Dashboard
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
			<h2> DASHBOARD </h2>
		</div>
	</center>

	<a href="customer-view.php" title="View Patients">
		<img src="emp.png" style="padding:8px;margin-left:500px;margin-top:40px;width:200px;height:200px;border:2px solid black;" alt="Employees List">
	</a>


	<a href="inventory-view.php" title="View Medicines">
		<img src="inventory.png" style="padding:8px;margin-left:100px;margin-top:40px;width:200px;height:200px;border:2px solid black;" alt="Inventory">
	</a>



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