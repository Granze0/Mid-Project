
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Register Page</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
        <?php
                include("php/config.php");

                if (isset($_POST['submit'])) {
                    $firstName = $_POST['firstName'];
                    $lastName = $_POST['lastName'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    if ($passwordHash === false) {
                        die("Password hashing failed.");
                    }

                
                    $maxIdQueryUser = mysqli_query($con, "SELECT MAX(id) AS maxId FROM user");
                    $maxIdQueryAdmin = mysqli_query($con, "SELECT MAX(id) AS maxId FROM admin");

                    $maxIdUser = mysqli_fetch_assoc($maxIdQueryUser)['maxId'];
                    $maxIdAdmin = mysqli_fetch_assoc($maxIdQueryAdmin)['maxId'];

                    
                    $newId = 'U' . sprintf('%03d', max(intval(substr($maxIdUser, 1)), intval(substr($maxIdAdmin, 1))) + 1);


                    
                    $idExistsQuery = mysqli_query($con, "SELECT id FROM user WHERE id = '$newId' UNION SELECT id FROM admin WHERE id = '$newId'");

                    if (mysqli_num_rows($idExistsQuery) != 0) {
                        echo "<div class='message'>
                                <p>An error occurred while generating the ID. Please try again.</p>
                            </div> <br>";
                        echo "<a href='javascript:history.back()'><button class='btn'>Go Back</button></a>";
                    } else {
                        
                        $verifyQuery = mysqli_query($con, "SELECT email FROM user WHERE email = '$email' UNION SELECT email FROM admin WHERE email = '$email'");

                        if (mysqli_num_rows($verifyQuery) != 0) {
                            echo "<div class='message'>
                                    <p>This email is used, try another one, please!</p>
                                </div> <br>";
                            echo "<a href='javascript:history.back()'><button class='btn'>Go Back</button></a>";
                        } else {
                            // Insert into 'user' table
                            $insertQuery = "INSERT INTO user(id, firstName, lastName, email, passwordHash, password) VALUES('$newId','$firstName','$lastName','$email','$passwordHash','$password')";
                            mysqli_query($con, $insertQuery) or die("Error Occurred: " . mysqli_error($con));

                            echo "<div class='message'>
                                    <p>Registration Successful!</p>
                                </div> <br>";
                            echo "<a href='dashboard.php'><button class='btn'>Login Now</button></a>";
                        }
                    }
                } else {
                
            ?>
    
                <h1>Sign Up</h1>
                <form action="" method="post">

                <div class="field input">
                    <label for="firstName">First Name</label>
                    <input type="text" name="firstName" id="firstName" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="lastName">Last Name</label>
                    <input type="text" name="lastName" id="lastName" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Register" required>
                </div>

                <div class="links">
                    Already a member? <a href="index.php">Sign Here</a>
                </div>
            </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>

