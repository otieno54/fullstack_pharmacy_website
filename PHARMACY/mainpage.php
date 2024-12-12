<!DOCTYPE html>
<html>

<link rel="stylesheet" type="text/css" href="login1.css">
<head>
<div class="header">
  <h1>PHARMACY MANAGEMENT SYSTEM</h1>
  <p style="margin-top:-20px;line-height:1;font-size:30px;"> MY PHARMACY</p>
</div>
<title>
My Pharmacy
</title>
</head>

<body>

    <br><br><br><br>
    <div class="container">
        <form method="post" action="">
            <div id="div_login">
                <h1>Login</h1>
                <center>
                    <div>
                        <input type="text" class="textbox" id="uname" name="uname" placeholder="Username" required />
                    </div>
                    <div>
                        <input type="password" class="textbox" id="pwd" name="pwd" placeholder="Password" required />
                    </div>
                    <div>
                        <input type="submit" value="Submit" name="submit" id="submit" />
                    </div>
                    <p style="margin-top: 10px;">
                        Don't have an account? 
                        <a href="register.php" style="color: blue; text-decoration: underline;">Register</a>.
                    </p>
<?php

    include "config.php";

    if (isset($_POST['submit'])) {
        // Get the form inputs
        $username = mysqli_real_escape_string($conn, $_POST['uname']);  // Use 'uname' here
        $password = mysqli_real_escape_string($conn, $_POST['pwd']);    // Use 'pwd' here

        if ($username != "" && $password != "") {
            // Fetch user data from `users` table
            $sql = "SELECT * FROM users WHERE username='$username'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            if ($row) {
                // Verify the password
                if (password_verify($password, $row['password'])) {
                    // Start a session if credentials are correct
                    session_start();
                    $_SESSION['user'] = $username;
                    echo "<p style='color:green;'>Login successful! Redirecting...</p>";
                    header("location:adminmainpage.php");  // Redirect to main page
                } else {
                    echo "<p style='color:red;'>Invalid username or password!</p>";
                }
            } else {
                echo "<p style='color:red;'>Invalid username or password!</p>";
            }
        }
    }


?>
                </center>
            </div>
        </form>
    </div>

    <div class="footer">
        <br>
        Copyright. 
        <br><br>
    </div>

</body>

</html>

