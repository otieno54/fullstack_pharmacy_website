<!DOCTYPE html>
<html>

<link rel="stylesheet" type="text/css" href="login1.css">

<head>
    <div class="header">
        <h1>PHARMACY MANAGEMENT SYSTEM</h1>
        <p style="margin-top:-20px;line-height:1;font-size:30px;"> MY PHARMACY</p>
    </div>
    <title>
        Register - My Pharmacy
    </title>
</head>

<body>

    <br><br><br><br>
    <div class="container">
        <form method="post" action="">
            <div id="div_login">
                <h1>Register</h1>
                <center>
                    <div>
                        <input type="text" class="textbox" id="uname" name="uname" placeholder="Username" required />
                    </div>
                    <div>
                        <input type="email" class="textbox" id="email" name="email" placeholder="Email" required />
                    </div>
                    <div>
                        <input type="password" class="textbox" id="pwd" name="pwd" placeholder="Password" required />
                    </div>
                    <div>
                        <input type="password" class="textbox" id="confirm_pwd" name="confirm_pwd" placeholder="Confirm Password" required />
                    </div>
                    <div>
                        <input type="submit" value="Register" name="submit" id="submit" />
                    </div>

                    <?php
                    include "config.php"; // Include database connection file

                    if (isset($_POST['submit'])) {
                        // Getting form data
                        $uname = mysqli_real_escape_string($conn, $_POST['uname']); // Correct the variable to 'uname'
                        $email = mysqli_real_escape_string($conn, $_POST['email']);
                        $password = mysqli_real_escape_string($conn, $_POST['pwd']);
                        $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_pwd']);

                        // Password validation
                        if ($password !== $confirm_password) {
                            echo "<p style='color:red;'>Passwords do not match!</p>";
                        } else {
                            // Hashing the password for security
                            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                            // Check if username or email already exists in the `users` table
                            $sql_check = "SELECT * FROM users WHERE username='$uname' OR email='$email'";
                            $result_check = $conn->query($sql_check);

                            if ($result_check->num_rows > 0) {
                                echo "<p style='color:red;'>Username or Email already exists in users!</p>";
                            } else {
                                // Insert new user into `users` table
                                $sql_insert_user = "INSERT INTO users (username, email, password) VALUES ('$uname', '$email', '$hashed_password')";
                                if ($conn->query($sql_insert_user) === TRUE) {
                                    echo "<p style='color:green;'>User registration successful! You can now <a href='login.php'>login</a>.</p>";
                                } else {
                                    echo "<p style='color:red;'>Error in user registration: " . $conn->error . "</p>";
                                }
                            }
                        }
                    }
                    ?>
                </center>

                <!-- Link to login page -->
                <p style="text-align:center; font-size:14px; margin-top:20px;">Already have an account? <a href="mainpage.php">Login here</a></p>

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
