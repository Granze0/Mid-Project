<?php
session_start();
include("php/config.php");

if (!(isset($_SESSION['valid_email']) && isset($_SESSION['valid_password']))) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $firstName = mysqli_real_escape_string($con, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($con, $_POST['lastName']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $bio = mysqli_real_escape_string($con, $_POST['bio']);


    $result = $con->query("SELECT MAX(id) FROM user");
    $row = $result->fetch_assoc();
    $previousMaxId = $row['MAX(id)'];

    $numericPart = intval(substr($previousMaxId, 1));
    $newNumericPart = $numericPart + 1;

    $newId = 'U' . sprintf("%03d", $newNumericPart);

    $stmt = $con->prepare("INSERT INTO user (id,firstName, lastName, email, bio) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss",$newId, $firstName, $lastName, $email, $bio);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/adduser.css">
    <title>Add User</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <a href="dashboard.php"><button class="btn">Dashboard</button></a>
        </div>
        <div class="right-links">
            <a href="profile.php"><button class="btn profile-btn">Profile</a>
            <a href="logout.php"><button class ="btn">Log Out </button></a>
        </div>
    </div>


    <div class="container">
        <div class="container-head"></div>
        <div class="title">
            <h1>Add User</h1>
        </div>
        <script src="img.js"></script>
        <form class="add-user-form" method="post" enctype="multipart/form-data">

            <div class="avatar-container">
                <label for="avatar">Choose File:</label>
                <input type="file" id="avatar" name="avatar" accept="image/*">
                <img id="avatar-preview" src="#" alt="Avatar Preview">
            </div>
    
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" required>
    
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" required>
    
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
    
            <label for="bio">Bio:</label>
            <textarea id="bio" name="bio" rows="10"></textarea>
    
            <button type="submit" class="button">Add User</button></a>
        </form>
    </div>
    </body>
</html>
    
