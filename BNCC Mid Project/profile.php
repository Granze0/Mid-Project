<?php
session_set_cookie_params(3600);
session_start();
include("php/config.php");

if (!(isset($_SESSION['valid_email']) && isset($_SESSION['valid_password']) &&
      !empty($_SESSION['valid_email']) && !empty($_SESSION['valid_password']))) {
    header("Location: index.php");
    exit();
}

$userEmail = $_SESSION['valid_email'];

$sqlUser = "SELECT * FROM user WHERE email = ?";
$stmtUser = $con->prepare($sqlUser);
$stmtUser->bind_param("s", $userEmail);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();

$sqlAdmin = "SELECT * FROM admin WHERE email = ?";
$stmtAdmin = $con->prepare($sqlAdmin);
$stmtAdmin->bind_param("s", $userEmail);
$stmtAdmin->execute();
$resultAdmin = $stmtAdmin->get_result();

$userData = [];

if ($resultUser->num_rows > 0) {
    $userData = $resultUser->fetch_assoc();
} elseif ($resultAdmin->num_rows > 0) {
    $userData = $resultAdmin->fetch_assoc();
}

$stmtUser->close();
$stmtAdmin->close();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/profile.css">
    <title>User Profile</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <a href="dashboard.php"><button class="btn">Dashboard</button></a>
        </div>
        <div class="right-links">
            <a href="dashboard.php"><button class="btn return-btn">Return</button></a>
            <a href="logout.php"><button class ="btn"> Log Out </button></a>
        </div>
    </div>

    <div class="container">

        <header> 
            <h2>User Profile</h2>
        </header>
    

      <div class="profile-data">
        
        <div>
            <label for="firstName">First Name:</label>
            <p id="firstName" class="inline" style="display: inline"><?= $userData['firstName'] ?></p>
        </div>

        <div>
            <label for="lastName">Last Name:</label>
            <p id="lastName" class="inline" style="display: inline"><?= $userData['lastName'] ?></p></p>
        </div>


        <div>
            <label for="email">Email:</label>
            <p id="email" class="inline" style="display: inline"><?= $userData['email'] ?></p> 
        </div>

        <div>
            <label for="bio">Bio:</label> 
            <p id="bio" ><?= $userData['bio'] ?></p>
        </div>
               
        <div class="field">
            <a href ="editprofile.php">
                <input type="submit" class="btn" name="submit" value="Edit Profile" required>
            </a>
                
        </div>
    </div>
    </div>
</body>
</html>





