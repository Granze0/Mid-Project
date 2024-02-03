<?php
    session_start();
    include("php/config.php");

    if (!(isset($_SESSION['valid_email']) && isset($_SESSION['valid_password']) &&
        !empty($_SESSION['valid_email']) && !empty($_SESSION['valid_password']))) {
        header("Location: index.php ");
    }


    $sql = "SELECT * FROM user WHERE id IS NOT NULL"; 
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $userList = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $userList = [];
    }
    
    $sql = "DELETE FROM user WHERE id IS NULL";
    $result = $con->query($sql);


    if (isset($_GET['userId']) && !empty($_GET['userId'])) {
        $userIdToDelete = $_GET['userId'];

        $deleteSql = "DELETE FROM user WHERE id = '$userIdToDelete'";
        $deleteResult = $con->query($deleteSql);

        if ($deleteResult) {
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error deleting user: " . $con->error;
        }

    }


    if(isset($_GET['search']) && !empty($_GET['search'])) {
        $searchTerm = $_GET['search'];

        
        $sql = "SELECT * FROM user WHERE id IS NOT NULL AND (firstName LIKE '%$searchTerm%' OR lastName LIKE '%$searchTerm%')";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            $userList = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $userList = [];
        }
    } else {
        
        $sql = "SELECT * FROM user WHERE id IS NOT NULL";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            $userList = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $userList = [];
        }
    }

    $sql = "SELECT id, firstName, lastName, email, photo FROM user WHERE id IS NOT NULL";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $userList = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $userList = [];
    }



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <script src="https://kit.fontawesome.com/43c9ab6ad0.js" crossorigin="anonymous"></script>


    <style>
        .social-icons {
            margin-top: 10px;
        }

        .social-icons a {
            display: inline-block;
            margin-right: 10px;
        }

        .social-icons i {
            font-size: 30px; 
            margin-right: 10px;
            border-radius: 50%;
            padding: 10px; 
            background-color: #333; 
            color: #fff; 
            text-align: center;
            line-height: 50px; 
        }
    </style>

    <title>Dashboard Page</title>

    <script>
        function confirmDelete(userId) {
            console.log("Confirm delete called with userId:", userId);
            var confirmation = confirm("Are you sure you want to delete this user?");
            if (confirmation) {
                
                window.location.href = "dashboard.php?userId=" + encodeURIComponent(userId);
            }
        }
    </script>

</head>
<body>
    <div class="nav">
        <div class="logo">
            <a href="dashboard.php"><button class="btn">Dashboard</button></a>
        </div>
        <div class="right-links">
            <a href="profile.php"><button class="btn profile-btn">Profile</a>
            <a href="logout.php"><button class ="btn"> Log Out </button></a>
        </div>
    </div>

   
    <main>
        <div class="wrapper">

            <div class="search-container">
                <form method="GET" action="dashboard.php">
                    <input type="text" class="search-input" placeholder="Search user based on name">
                    <button type="submit" class="search-button">Search</button>
                </form>
            </div>

            <h1>User List</h1>

            
            <table>
                <tr>
                    <th>No</th>
                    <th>Photo</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Action</th>

                </tr>
                
                <?php foreach($userList as $index => $user) :  ?>
                <tr>
                    <td><?= $index + 1?></td>
                    <td data-cell="photo">
                        <?php if (!empty($user['photo'])): ?>
                            <?php
                                $resizeWidth = 150;
                                $resizeHeight = 150;
                                $base64Image = base64_encode($user['photo']);
                            ?>
                            <img src="data:image/jpeg;base64,<?= $base64Image ?>" alt="User Image" style="width: <?= $resizeWidth ?>px; height: <?= $resizeHeight ?>px;">
                        <?php else: ?>
                            <?php
                                $resizeWidth = 150;
                                $resizeHeight = 150;
                            ?>
                            <img src="/Project1/Asset/SOEKARNO.jpg" alt="Default Image" style="width: <?= $resizeWidth ?>px; height: <?= $resizeHeight ?>px;">
                        <?php endif; ?>
                    </td>
                    <td data-cell="fullName"><?= $user['firstName'] . ' ' .$user['lastName'] ?></td>
                    <td data-cell="email"><?= $user['email'] ?></td>
                    <td data-cell="action">
                        <div class="field">
                            <a href="view.php?userId=<?= $user['id'] ?>">
                                <input type="submit" class="btn" name="submit" value="View" required>
                            </a>
                        </div>

                        <div class="field2">
                            <a href="edit.php?userId=<?= $user['id'] ?>">
                                <input type="submit" class="btn" name="submit" value="Edit" required>
                            </a>
                            
                        </div>

                        <div class="field3">
                            <input type="button" class="btn" name="submit" value="Delete" onclick="confirmDelete('<?= $user['id'] ?>')" required>
                        </div>

                    </td>

                </tr>
             <?php endforeach; ?>
                

            </table>


        </div>

    </main>

    <div class="field4">
       <a href ="adduser.php"><button class="btn"> + Add User </button></a> 
    </div>


    <div class="footer-bottom">
        <p>&copy; 2024 Miracle Co. All rights reserved.</p>
        <div class="social-icons">
            <a href="#" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
        </div>
    </div>

</body>
</html>

