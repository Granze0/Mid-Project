<?php
session_start();
include("php/config.php");

if (!(isset($_SESSION['valid_email']) && isset($_SESSION['valid_password']))) {
    header("Location: index.php ");
}

if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];

    
    if (!empty($userId)) {
        
        $sql = "SELECT * FROM user WHERE id = '$userId'";


        $result = $con->query($sql);

        if ($result === FALSE) {
            
            echo "Error: " . $con->error;
            exit();
        }

        if ($result->num_rows > 0) {
            $userDetails = $result->fetch_assoc();
        } else {
            echo "User not found!";
            exit();
        }
    } else {
        echo "User ID is empty!";
        exit();
    }
} else {
    echo "User ID not provided!";
    exit();
}

$con->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/view.css">
    <title>View User</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <a href="dashboard.php"><button class="btn">Dashboard</button></a>
        </div>
        <div class="right-links">
            <a href="profile.php"><button class="btn2">Profile</a>
            <a href="logout.php"><button class ="btn"> Log Out </button></a>
        </div>
    </div>

    <main>
        <div class="container">
            <div class="main-header"></div>
            <div class="header">
                <h2>User Details</h2>
            </div>

            <div class="user-data">
                <h3>Information</h3>

                <div>
                    <img src="your-image-path.jpg" alt="User Image"> 
                </div>

                
                <div>
                    <label for="firstName">First Name:</label>
                    <p id="firstName" class="inline"><?= $userDetails['firstName']?> </p>
                </div>

                <div>
                    <label for="lastName">Last Name:</label>
                    <p id="lastName" class="inline"><?= $userDetails['lastName']?></p>
                </div>


                <div>
                    <label for="email">Email:</label>
                    <p id="email" class="inline"><?= $userDetails['email']?></p> <br>
                </div>

                <div>
                    <label for="bio">Bio:</label> 
                    <p id="bio"><?= $userDetails['bio']?></p>
                </div>

            </div>
        
            
            <div class="field2">
                <a href="dashboard.php"><button class="btn">Back to User List</button></a>
            </div>


            

        </div>
        
    </main>
</body>
</html>
