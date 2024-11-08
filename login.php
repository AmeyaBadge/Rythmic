<?php
session_start();
require('admin/comps/functions.php');
require('comp/connection.php');

if(isset($_SESSION['userID'])){
    redirect('index.php');
}else{
    if(isset($_POST['signin'])){
        require_once('comp/connection.php');
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $password = $_POST['password'];
        
        $query = "SELECT * FROM user_accounts WHERE email_id='$email' AND password='$password';";

        $res = $conn->query($query);
        if($res->num_rows==1){
            
            echo "Login Successful!";
            $_SESSION['userID'] = $res->fetch_assoc()['user_id'];
            redirect('index.php');
        }
        
    }else if(isset($_POST['signup'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user_sql = "INSERT INTO users (username, email_id) VALUES (?, ?)";
    $user_stmt = $conn->prepare($user_sql);
    $user_stmt->bind_param("ss", $username,  $email);
    $user_stmt->execute();

    // Get the last inserted user_id
    $user_id = $conn->insert_id;

    // Insert data into user_accounts table
    $account_sql = "INSERT INTO user_accounts (user_id, account_name, password, email_id) VALUES (?, ?, ?, ?)";
    $account_stmt = $conn->prepare($account_sql);
    $account_stmt->bind_param("isss", $user_id, $username, $password, $email);
    $account_stmt->execute();

    // Commit transaction
    if($conn->commit()){
        echo "User created successfully";
        $_SESSION['userID'] = $user_id;
        redirect('index.php');
    }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="login.css"> 
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"> 
</head>
<body>
    <div class="container" id="main">
        <div class="sign-up">
            <form action="" method="post">
                <h1>Create Account</h1>

                <p>or use email for registration</p>
                <input type="text" name="username" placeholder="Username" required="">
                <input type="email" name="email" placeholder="Email" required="">
                <input type="password" name="password" placeholder="Password" required="">
                <button id="up-btn" type="submit" name="signup" >Sign Up</button>
            </form>
        </div>
        <div class="sign-in">
            <form action="" method="post">
                <h1>Sign In</h1>

                <p>or use email for registration</p>
                <input type="email" name="email" placeholder="Email" required="">
                <input type="password" name="password" placeholder="Password" required="">
                <a href="#">Forgot Password</a>
                <button type="submit" name="signin" id="in-btn">Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-left">
                     <h1>Welcome Back!</h1>
                     <p>To continue please log-in</p>
                     <button id="signIn">Sign In</button>
                </div>
                <div class="overlay-right">
                    <h1>Enter your Deatils</h1>
                    <p>To get started</p>
                    <button id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script src="login.js"> </script>
</body>
</html>