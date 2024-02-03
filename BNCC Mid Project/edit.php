<?php
session_start();
include("php/config.php");

if (!(isset($_SESSION['valid_email']) && isset($_SESSION['valid_password']))) {
    header("Location: index.php");
    exit();
}

$userId = isset($_GET['userId']) ? $_GET['userId'] : null;

if (empty($userId)) {
    echo "User ID not provided!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $userId = $_POST['userId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $bio = $_POST['bio'];

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $image = $_FILES['photo'];
        $imageFileName = $image['name'];
        $imageTmpName = $image['tmp_name'];
        $imagePath = "uploads/" . $imageFileName; 

        move_uploaded_file($imageTmpName, $imagePath);
    } 
    
    $updateSql = "UPDATE user SET firstName=?, lastName=?, email=?, bio=?, photo=? WHERE id=?";
    $updateStmt = $con->prepare($updateSql);
    $updateStmt->bind_param("ssssss", $firstName, $lastName, $email, $bio, $imagePath, $userId);

    if ($updateStmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error updating user: " . $updateStmt->error;
        exit();
    }
} else {
    
    $sql = "SELECT * FROM user WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

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
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/edit1.css">
    <title>Edit User</title>
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
                <h1>Edit User</h1>
            </div>
    
            <form action="edit.php?userId=<?= $userId ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="userId" value="<?= $userId ?>">

                    <div class="image-container">
                        <?php
                            $resizeWidth = 350;
                            $resizeHeight = 350;
                        ?>
                        <?php if (!empty($userDetails['photo'])): ?>
                            <img src="<?= $userDetails['photo'] ?>" alt="User Image">
                        <?php else: ?>
                            <img src="/Project1/Asset/SOEKARNO.jpg" alt="Default Image">
                        <?php endif; ?>
                        <div>
                            <label for="photo">Profile Image:</label>
                            <input type="file" id="photo" name="photo" accept="image/*">
                        </div>
                    </div>

                <div>
                    <label for="firstName">First Name:</label>
                    <input type="text" id="firstName" name="firstName" value="<?= $userDetails['firstName']?>" required>
                </div>

                <div>
                    <label for="lastName">Last Name:</label>
                    <input type="text" id="lastName" name="lastName" value="<?= $userDetails['lastName']?>" required>
                </div>

                <div>
                    <label for="email">Email:</label> 
                    <input type="email" id="email" name="email" value="<?= $userDetails['email']?>" required>
        
                </div>
                
                <div class="bio-container">
                    <label for="bio">
                        <div class="bio"> 
                            Bio:
                        </div>
                    </label> 
                    <textarea id="bio" name="bio" rows="4"><?= $userDetails['bio']?></textarea>
                    
                </div>
                
                <div class="field">
                    <button type="submit" class="btn">Save Changes</button>
                </div>

                <div class="field2">
                    <a href="dashboard.php"><button type="button" class="btn">Cancel</button></a>
                </div>

            </form>
        </div>
    </main>
   
</body>
</html>
