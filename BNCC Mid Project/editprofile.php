<?php
session_set_cookie_params(3600);
session_start();
include("php/config.php");

if (!(isset($_SESSION['valid_email']) && isset($_SESSION['valid_password']) &&
      !empty($_SESSION['valid_email']) && !empty($_SESSION['valid_password']))) {
        var_dump($_SESSION);
       header("Location: index.php ");
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $bio = $_POST['bio'];

    
    if (!empty($userData)) {
        $updateUserSql = "UPDATE user SET firstName=?, lastName=?, email=?, bio=? WHERE email=?";
        $stmtUpdateUser = $con->prepare($updateUserSql);
        $stmtUpdateUser->bind_param("sssss", $firstName, $lastName, $email, $bio, $userEmail);
        $stmtUpdateUser->execute();
        $stmtUpdateUser->close();
    }

   
    if (!empty($userData)) {
        $updateAdminSql = "UPDATE admin SET firstName=?, lastName=?, email=?, bio=? WHERE email=?";
        $stmtUpdateAdmin = $con->prepare($updateAdminSql);
        $stmtUpdateAdmin->bind_param("sssss", $firstName, $lastName, $email, $bio, $userEmail);
        $stmtUpdateAdmin->execute();
        $stmtUpdateAdmin->close();
    }

    
    header("Location: profile.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/editprofile.css">
    <title>Edit Profile</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <a href="dashboard.php"><button class="btn">Dashboard</button></a>
        </div>
        <div class="right-links">
            <a href="profile.php"><button class="btn profile-btn">Profile</button></a>
            <a href="logout.php"><button class="btn">Log Out</button></a>
        </div>
    </div>

    <main>
        <div class="container">
            <div class="container-header">
                <h1>Edit Profile</h1>
            </div>
    
            <form action="editprofile.php" method="post">

                <div>
                    <label for="firstName">First Name:</label>
                    <input type="text" id="firstName" name="firstName" value="<?= $userData['firstName'] ?>" required>
                </div>

                <div>
                    <label for="lastName">Last Name:</label>
                    <input type="text" id="lastName" name="lastName" value="<?= $userData['lastName'] ?>" required>
                </div>

                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?= $userData['email'] ?>" required>
                </div>
                
                <div class="bio-container">
                    <label for="bio">Bio:</label>
                    <textarea id="bio" name="bio" rows="5"><?= $userData['bio'] ?></textarea>
                    
                </div>
                
                <div class="field">
                    <button type="submit" class="btn">Save Changes</button>
                </div>

                <div class="field2">
                    <a href="profile.php"><button type="button" class="btn">Cancel</button></a>
                </div>

            </form>
        </div>
    </main>
</body>
</html>
