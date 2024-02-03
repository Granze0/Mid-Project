<?php
session_set_cookie_params(3600);
session_start();
include("php/config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login Page</title>
</head>


<body>
    <div class="container">
        <div class="box form-box">
        <?php
            include("php/config.php");

            $rememberMe = isset($_POST['remember']);
            //check user database *_*
            if (isset($_POST['submit'])) {
                $email = mysqli_real_escape_string($con, $_POST['email']);
                $password = mysqli_real_escape_string($con, $_POST['password']);

                
                $result_user = mysqli_query($con, "SELECT * FROM user WHERE email = '$email' AND password ='$password'") or die("Select Error");
                $row_user = mysqli_fetch_assoc($result_user);

                // if not in  user database then check in admin database 0_0
                if (!is_array($row_user) || empty($row_user)) {
                    $result_admin = mysqli_query($con, "SELECT * FROM admin WHERE email = '$email' AND password ='$password'") or die("Select Error");
                    $row_admin = mysqli_fetch_assoc($result_admin);

                    if (is_array($row_admin) && !empty($row_admin)) {
                        $_SESSION['valid_email'] = $row_admin['email'];
                        $_SESSION['valid_password'] = $row_admin['password'];

                        if ($rememberMe) {
                            setcookie('remember_email', $email, time() + (30 * 24 * 60 * 60));
                            setcookie('remember_password', $password, time() + (30 * 24 * 60 * 60));
                        } else {
                            setcookie('remember_email', '', time() - 3600);
                            setcookie('remember_password', '', time() - 3600);
                        }
                    } else {
                        echo "<div class='message'>
                                <p> Wrong email or password</p>
                              </div> <br>";
                        echo "<a href='index.php'><button class='btn'>Go Back</button></a>";
                    }
                } else {
                    $_SESSION['valid_email'] = $row_user['email'];
                    $_SESSION['valid_password'] = $row_user['password'];
                    

                    if ($rememberMe) {
                        setcookie('remember_email', $email, time() + (30 * 24 * 60 * 60));
                        setcookie('remember_password', $password, time() + (30 * 24 * 60 * 60));
                    } else {
                        setcookie('remember_email', '', time() - 3600);
                        setcookie('remember_password', '', time() - 3600);
                    }
                }

                if (isset($_SESSION['valid_email']) && isset($_SESSION['valid_password']) && !empty($_SESSION['valid_email']) && !empty($_SESSION['valid_password'])) {
                    var_dump($_SESSION);
                    header("Location: dashboard.php");
                    
                }
            } else {
            ?>
                <header>Login</header>
            
        
            <form action="" method ="post">
                <div class="field input">
                    <label for = "email">Email</label>
                    <input type ="text" name="email" id="email" required>
                </div>

                <div class="field input">
                    <label for = "password">Password</label>
                    <input type ="password" name="password" id="password" required>
                </div>

                <div class="bottom">
                    <div class="left">
                        <input type="checkbox" name="remember" id="check">
                        <label for="check">Remember Me </label>
                    </div>
                    
                </div>
                
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>

                <div class="links">
                    Don't have an account ? <a href="register.php"> Register Here</a>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
</div>
</body>
</html>